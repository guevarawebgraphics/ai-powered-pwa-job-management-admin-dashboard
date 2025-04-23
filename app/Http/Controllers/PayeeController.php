<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payee;
use App\Repositories\PayeeRepository;

/**
 * Class PayeeController
 * @package App\Http\Controllers
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class PayeeController extends Controller
{
    /**
     * Payee model instance.
     *
     * @var Payee
     */
    private $payee_model;

    /**
     * PayeeRepository repository instance.
     *
     * @var PayeeRepository
     */
    private $payee_repository;

    /**
     * Create a new controller instance.
     *
     * @param Payee $payee_model
     * @param PayeeRepository $payee_repository
     */
    public function __construct(Payee $payee_model, PayeeRepository $payee_repository)
    {
        /*
         * Model namespace
         * using $this->payee_model can also access $this->payee_model->where('id', 1)->get();
         * */
        $this->payee_model = $payee_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of payees with other data (related tables).
         * */
        $this->payee_repository = $payee_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Payee')) {
            abort('401', '401');
        }

        $payees = $this->payee_model->get();

        return view('admin.pages.payee.index', compact('payees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Payee')) {
            abort('401', '401');
        }

        return view('admin.pages.payee.create');
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
        if (!auth()->user()->hasPermissionTo('Create Payee')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'payee_name'    =>  'required',
            'payee_last_name'   =>  'required',
            'email' => 'required|unique:payees,email,NULL,payee_id,deleted_at,NULL',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        $payee = $this->payee_model->create($input);

        // if ($request->hasFile('banner_image')) {
        //     $file_upload_path = $this->payee_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'payee_images');
        //     $payee->fill(['banner_image' => $file_upload_path])->save();
        // }
        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->payee_repository->uploadFile($request->file('file'), /*'file'*/null, 'payee_files');
        //     $payee->fill(['file' => $file_upload_path])->save();
        // }


        if (!isset($input['is_modal'])) {
            return redirect()->route('admin.payees.index')->with('flash_message', [
                'title' => '',
                'message' => 'Payee ' . $payee->payee_name . ' successfully added.',
                'type' => 'success'
            ]);

        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Payee ' . $payee->payee_name . ' successfully added.'
            ]);
        }
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
        if (!auth()->user()->hasPermissionTo('Read Payee')) {
            abort('401', '401');
        }

        $payee = $this->payee_model->findOrFail($id);

        return view('admin.pages.payee.show', compact('payee'));
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
        if (!auth()->user()->hasPermissionTo('Update Payee')) {
            abort('401', '401');
        }

        $payee = Payee::where('payee_id',$id)->first();

        return view('admin.pages.payee.edit', compact('payee'));
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
        if (!auth()->user()->hasPermissionTo('Update Payee')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'payee_name'    =>  'required',
            'payee_last_name'   =>  'required',
            'email' => 'required|unique:payees,email,' . $id . ',payee_id,deleted_at,NULL',
        ]);

        $payee = Payee::where('payee_id',$id)->first();
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;

        // if ($request->hasFile('banner_image')) {
        //     $file_upload_path = $this->payee_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'payee_images');
        //     $input['banner_image'] = $file_upload_path;
        // }
        // if ($request->has('remove_banner_image') && $request->get('remove_banner_image')) {
        //     $input['banner_image'] = '';
        // }

        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->payee_repository->uploadFile($request->file('file'), /*'file'*/null, 'payee_files');
        //     $input['file'] = $file_upload_path;
        // }
        // if ($request->has('remove_file') && $request->get('remove_file')) {
        //     $input['file'] = '';
        // }

        $payee->fill($input)->save();

        return redirect()->route('admin.payees.index')->with('flash_message', [
            'title' => '',
            'message' => 'Payee ' . $payee->payee_name . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Payee')) {
            abort('401', '401');
        }

        $payee = $this->payee_model->findOrFail($id);
        $payee->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Payee successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
