<?php

namespace App\Http\Controllers;

use App\Http\Traits\SystemSettingTrait;
use App\Models\Attachment;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageType;
use App\Repositories\PageRepository;
use App\Repositories\SeoMetaRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pages Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles pages in front end and page module in admin.
    |
    */

    use SystemSettingTrait;

    /*
    |--------------------------------------------------------------------------
    | Front
    |--------------------------------------------------------------------------
    */

    /**
     * Create a new controller instance.
     *
     * @param Page $page_model
     * @param PageType $page_type_model
     * @param SeoMetaRepository $seo_meta_repository
     * @param PageRepository $page_repository
     * @param PageSection $page_section_model
     */
    public function __construct(Page $page_model,
                                PageType $page_type_model,
                                SeoMetaRepository $seo_meta_repository,
                                PageRepository $page_repository,
                                PageSection $page_section_model

    )
    {
        /*
         * Model namespace
         * using $this->role_model can also access $this->role_model->where('id', 1)->get();
         * */
        $this->page_model = $page_model;
        $this->page_type_model = $page_type_model;
        $this->page_section_model = $page_section_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of posts with other data (related tables).
         * */
        $this->seo_meta_repository = $seo_meta_repository;
        $this->page_repository = $page_repository;
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('front.pages.home');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @param  string $product_slug
     *
     * @return \Illuminate\Http\Response
     */
    public function showPages($slug = '')
    {
        $page = $category = $product = $categories = $section_services = [];

        if ($slug == '') {
            /* home */
            $page = $this->page_repository->getActivePageBySlug('home');
            if (empty($page)) {
                return view('front.pages.home');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        } else {
            $page = $this->page_repository->getActivePageBySlug($slug);

            /* if not in pages */
            if (empty($page)) {
                abort('404', '404');
            } else {
                $seo_meta = $this->getSeoMeta($page);
            }
        }

        return view('front.pages.custom-pages-index', compact('page', 'seo_meta'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    /**
     * Show the application pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Page')) {
            abort('401', '401');
        }

        $pages = $this->page_model->get();

        return view('admin.pages.page.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }

        $page_types = $this->page_type_model->get();

        return view('admin.pages.page.create', compact('page_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:pages',
            'slug' => 'required|unique:pages',
            'banner_image' => 'mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
//        $input['slug'] = str_slug($input['name']);

        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seo_meta_repository->updateOrCreate($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        $page = $this->page_model->create($input);

        if ($request->hasFile('banner_image'))
            $page->attach($request->file('banner_image'));

        return redirect()->route('admin.pages.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Page ' . $page->title . ' successfully added.',
                'type' => 'success'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $page = $this->page_model->findOrFail($id);
        $page_types = $this->page_type_model->get();

        return view('admin.pages.page.edit', compact('page', 'page_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:pages,name,' . $id,
            'slug' => 'required|unique:pages,slug,' . $id,
        ]);

        $page = $this->page_model->findOrFail($id);
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
//        $input['slug'] = str_slug($input['name']);

        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seo_meta_repository->updateOrCreate($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        if ($request->hasFile('banner_image'))
            $page->attach($request->file('banner_image'));

        $page->fill($input)->save();

        foreach ($page->sections as $section) {
            if ($section->isAttachment) {
                $page->attach($request->file($section->alias));
            } else {
                $section->value = $request->input($section->alias);
                $section->save();
            }
        }

        return redirect()->route('admin.pages.index')
            ->with('flash_message', [
                'title' => '',
                'message' => 'Page ' . $page->title . ' successfully updated.',
                'type' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Page')) {
            abort('401', '401');
        }

        $page = $this->page_model->findOrFail($id);
        $page->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Page successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return json_encode($response);
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('image'))
            return response()->json([
                'status' => false,
                'message' => 'No file provided',
                'data' => []
            ]);

        $file = $request->file('image');

        $attachment = new Attachment();
        $attachment->alias = str_random() . '.' . $file->getClientOriginalExtension();
        $attachment->folder = 'Form';
        $attachment->mime = $file->getClientMimeType();
        $attachment->name = $file->getClientOriginalName();
        $attachment->extension = $file->getClientOriginalExtension();
        $attachment->save();

        $file->move(public_path('storage/Form'), $attachment->alias);

        return response()->json([
            'status' => true,
            'message' => 'Image successfully uploaded',
            'data' => $attachment
        ]);
    }


    /**
     * upload image ckeditor
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function ckEditorImageUpload(Request $request)
    {
//        $CKEditor = $request->get('CKEditor');
        $funcNum = $request->get('CKEditorFuncNum');
        $message = $url = '';
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            if ($file->isValid()) {
//                $filename = $file->getClientOriginalName();
                $filename = uniqid() . time();
                $extension = $file->getClientOriginalExtension();

                $file->move(public_path() . '/uploads/ckeditor/', $filename . '.' . $extension);
                $url = asset('/public/uploads/ckeditor/' . $filename . '.' . $extension);

                /* save image path to browser list */
                $image_json = file_get_contents(public_path() . '/uploads/ckeditor/image_list.json');
                $image_data = json_decode($image_json, true);

                if (!is_array($image_data)) {
                    $image_data = [];
                }

                array_push($image_data, ["image" => $url]);
                $new_image_json = json_encode($image_data);
                file_put_contents(public_path() . '/uploads/ckeditor/image_list.json', $new_image_json);
            } else {
                $message = 'An error occured while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';
    }

}
