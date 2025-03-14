<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Repositories\ClientRepository;

/**
 * Class ClientController
 * @package App\Http\Controllers
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class ClientController extends Controller
{
    /**
     * Client model instance.
     *
     * @var Client
     */
    private $client_model;

    /**
     * ClientRepository repository instance.
     *
     * @var ClientRepository
     */
    private $client_repository;

    /**
     * Create a new controller instance.
     *
     * @param Client $client_model
     * @param ClientRepository $client_repository
     */
    public function __construct(Client $client_model, ClientRepository $client_repository)
    {
        /*
         * Model namespace
         * using $this->client_model can also access $this->client_model->where('id', 1)->get();
         * */
        $this->client_model = $client_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of clients with other data (related tables).
         * */
        $this->client_repository = $client_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Client')) {
            abort('401', '401');
        }

        $clients = $this->client_model->get();

        return view('admin.pages.client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Client')) {
            abort('401', '401');
        }

        return view('admin.pages.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Client')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:clients,name,NULL,id,deleted_at,NULL',
            'slug' => 'required|unique:clients,slug,NULL,id,deleted_at,NULL',
            'content' => 'required',
            'banner_image' => 'mimes:jpg,jpeg,png',
            'file' => 'mimes:docx,doc,pdf',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
        $input['slug'] = str_slug($input['name']);

        $client = $this->client_model->create($input);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->client_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'client_images');
            $client->fill(['banner_image' => $file_upload_path])->save();
        }
        if ($request->hasFile('file')) {
            $file_upload_path = $this->client_repository->uploadFile($request->file('file'), /*'file'*/null, 'client_files');
            $client->fill(['file' => $file_upload_path])->save();
        }

        return redirect()->route('admin.clients.index')->with('flash_message', [
            'title' => '',
            'message' => 'Client ' . $client->name . ' successfully added.',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermissionTo('Read Client')) {
            abort('401', '401');
        }

        $client = $this->client_model->findOrFail($id);

        return view('admin.pages.client.show', compact('client'));
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
        if (!auth()->user()->hasPermissionTo('Update Client')) {
            abort('401', '401');
        }

        $client = $this->client_model->findOrFail($id);

        return view('admin.pages.client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Client')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'name' => 'required|unique:clients,name,' . $id . ',id,deleted_at,NULL',
            'slug' => 'required|unique:clients,slug,' . $id . ',id,deleted_at,NULL',
            'content' => 'required',
            'banner_image' => 'required_if:remove_banner_image,==,1|mimes:jpg,jpeg,png',
            'file' => 'required_if:remove_file,==,1|mimes:docx,doc,pdf',
        ]);

        $client = $this->client_model->findOrFail($id);
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* if slug is hidden, generate slug automatically */
        $input['slug'] = str_slug($input['name']);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->client_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'client_images');
            $input['banner_image'] = $file_upload_path;
        }
        if ($request->has('remove_banner_image') && $request->get('remove_banner_image')) {
            $input['banner_image'] = '';
        }

        if ($request->hasFile('file')) {
            $file_upload_path = $this->client_repository->uploadFile($request->file('file'), /*'file'*/null, 'client_files');
            $input['file'] = $file_upload_path;
        }
        if ($request->has('remove_file') && $request->get('remove_file')) {
            $input['file'] = '';
        }

        $client->fill($input)->save();

        return redirect()->route('admin.clients.index')->with('flash_message', [
            'title' => '',
            'message' => 'Client ' . $client->name . ' successfully updated.',
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Client')) {
            abort('401', '401');
        }

        $client = $this->client_model->findOrFail($id);
        $client->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Client successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
