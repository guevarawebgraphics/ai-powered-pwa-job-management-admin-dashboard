<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;
use App\Repositories\MachineRepository;
use App\Models\OpenAIFiles;
use Illuminate\Support\Facades\Http;

/**
 * Class MachineController
 * @package App\Http\Controllers
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class MachineController extends Controller
{
    /**
     * Machine model instance.
     *
     * @var Machine
     */
    private $machine_model;

    /**
     * MachineRepository repository instance.
     *
     * @var MachineRepository
     */
    private $machine_repository;

    /**
     * Create a new controller instance.
     *
     * @param Machine $machine_model
     * @param MachineRepository $machine_repository
     */
    public function __construct(Machine $machine_model, MachineRepository $machine_repository)
    {
        /*
         * Model namespace
         * using $this->machine_model can also access $this->machine_model->where('id', 1)->get();
         * */
        $this->machine_model = $machine_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of machines with other data (related tables).
         * */
        $this->machine_repository = $machine_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Machine')) {
            abort('401', '401');
        }

        $machines = $this->machine_model->get();

        return view('admin.pages.machine.index', compact('machines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Machine')) {
            abort('401', '401');
        }

        return view('admin.pages.machine.create');
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
        if (!auth()->user()->hasPermissionTo('Create Machine')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'model_number' => 'required|unique:machines,model_number,NULL,machine_id,deleted_at,NULL',
            'brand_name'  =>  'required',
            'machine_type'  =>  'required',
            'machine_photo' => 'mimes:jpg,jpeg,png',
        ]);

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['brand_name'] =   $request->brand_name == "other" ? $request->custom_brand_name : $request->brand_name;
        $input['machine_type'] =   $request->machine_type == "other" ? $request->custom_machine_type : $request->machine_type;
        $input['display_type'] =   $request->machine_type == "washers" || $request->machine_type == "stoves"   ? $request->display_type : NULL;
        $input['common_repairs'] = $this->youtubeApi($request->all);
        $machine = $this->machine_model->create($input);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->machine_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'machine_images');
            $url = url($file_upload_path);
            $machine->fill(['machine_photo' => $url])->save();
        }
        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->machine_repository->uploadFile($request->file('file'), /*'file'*/null, 'machine_files');
        //     $machine->fill(['file' => $file_upload_path])->save();
        // }

        if (!isset($input['is_modal'])) {
            return redirect()->back()->with('flash_message', [
                'title' => '',
                'page_module'   =>  'GIG',
                'message' => 'Machine ' . $machine->model_number . ' successfully added.',
                'type' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Machine ' . $machine->model_number . ' successfully added.'
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
        if (!auth()->user()->hasPermissionTo('Read Machine')) {
            abort('401', '401');
        }

        $machine = $this->machine_model->findOrFail($id);

        return view('admin.pages.machine.show', compact('machine'));
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
        if (!auth()->user()->hasPermissionTo('Update Machine')) {
            abort('401', '401');
        }

        $machine = Machine::where('machine_id', $id)->first();

        return view('admin.pages.machine.edit', compact('machine'));
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
        if (!auth()->user()->hasPermissionTo('Update Machine')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'model_number' => 'required|unique:machines,model_number,' . $id . ',machine_id,deleted_at,NULL',
            'brand_name'  =>  'required',
            'machine_type'  =>  'required',
            'banner_image' => 'required_if:remove_banner_image,==,1|mimes:jpg,jpeg,png',
        ]);

        $machine = Machine::where('machine_id', $id)->first();

        $input = $request->all();
        
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['brand_name'] =   $request->brand_name == "other" ? $request->custom_brand_name : $request->brand_name;
        $input['machine_type'] =   $request->machine_type == "other" ? $request->custom_machine_type : $request->machine_type;
        $input['display_type'] =   $request->machine_type == "washers" || $request->machine_type == "stoves"   ? $request->display_type : NULL;
        $input['common_repairs'] = $this->youtubeApi($request->all);

        if ($request->hasFile('banner_image')) {
            $file_upload_path = $this->machine_repository->uploadFile($request->file('banner_image'), /*'banner_image'*/null, 'machine_images');
            $url = url($file_upload_path);
            $input['machine_photo'] = $url;
        }
        if ($request->has('remove_banner_image') && $request->get('remove_banner_image')) {
            $input['machine_photo'] = '';
        }

        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->machine_repository->uploadFile($request->file('file'), /*'file'*/null, 'machine_files');
        //     $input['file'] = $file_upload_path;
        // }
        // if ($request->has('remove_file') && $request->get('remove_file')) {
        //     $input['file'] = '';
        // }

        $machine->fill($input)->save();

        return redirect()->back()->with('flash_message', [
            'title' => '',
            'message' => 'Machine ' . $machine->model_number . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Machine')) {
            abort('401', '401');
        }

        $machine = $this->machine_model->findOrFail($id);
        $machine->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Machine successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }

    public function indexMachineFilesOpenAI() {
        if (!auth()->user()->hasPermissionTo('Read Machine')) {
            abort('401', '401');
        }

        return view('admin.pages.sync_openai_files.index');
    }

    public function storeMachineFilesOpenAI(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'model_number' => 'required',
            'file'         => 'required|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx', // size in kilobytes (102400 KB = 100 MB)
        ]);

        // Retrieve the machine model number from the request
        $modelNumber = $request->input('model_number');

        // Retrieve the file from the request. Dropzone uses the parameter name "file" by default.
        $file = $request->file('file');

        // Define the destination path (ensure this folder exists)
        $destinationPath = public_path('images/openai-files');

        // Generate a unique file name
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move the file to the destination folder
        $file->move($destinationPath, $filename);

        // Create a URL for the file (assumes publicly accessible files under /images/openai-files)
        $fileURL = '/images/openai-files/' . $filename;


        

        $openaiResponse = Http::withToken(config('services.openai.key'))
        ->attach('file', file_get_contents($destinationPath . '/' . $filename), $filename)
        ->post('https://api.openai.com/v1/files', [
            'purpose' => 'assistants'
        ]);

        // Check for upload success
        if (!$openaiResponse->successful()) {
            return response()->json([
                'message' => 'Failed to upload to OpenAI.',
                'error'   => $openaiResponse->json(),
            ], 500);
        }

        $openaiFile = $openaiResponse->json();

        $fileId = $openaiFile['id'];

        // ✅ Step 3: Attach file to vector store (We will only use 1 vector)
        $vectorStoreId = 'vs_67fa7f0abec48191adc1594c4e2641dc'; // Your actual vector store ID
        // {
        //     "object": "list",
        //     "data": [
        //         {
        //         "id": "vs_67fa7f0abec48191adc1594c4e2641dc",
        //         "object": "vector_store",
        //         "created_at": 1744469770,
        //         "name": "Machines Vector",
        //         "usage_bytes": 0,
        //         "file_counts": {
        //             "in_progress": 0,
        //             "completed": 0,
        //             "failed": 0,
        //             "cancelled": 0,
        //             "total": 0
        //         },
        //         "status": "completed",
        //         "expires_after": null,
        //         "expires_at": null,
        //         "last_active_at": 1744549737,
        //         "metadata": {}
        //         }
        //     ],
        //     "first_id": "vs_67fa7f0abec48191adc1594c4e2641dc",
        //     "last_id": "vs_67fa7f0abec48191adc1594c4e2641dc",
        //     "has_more": false
        // }

        $attachResponse = Http::withToken(config('services.openai.key'))
            ->post("https://api.openai.com/v1/vector_stores/{$vectorStoreId}/file_batches", [
                'file_ids' => [$fileId]
            ]);

        if (!$attachResponse->successful()) {
            return response()->json([
                'message' => 'Failed to attach file to vector store.',
                'error' => $attachResponse->json(),
            ], 500);
        }

        $openaiVector = $attachResponse->json();

        $json = [
            'file' =>   $openaiFile,
            'assigned_vector'   => $openaiVector
        ];


        // Save to database using your model (for example, OpenAIFiles)
        $modelFile = new OpenAIFiles();
        $modelFile->model_number = $modelNumber;
        $modelFile->file_id = $openaiFile['id'];
        $modelFile->json_response = json_encode($json);
        $modelFile->image = $fileURL;
        $modelFile->save();

        return response()->json([
            'file_url' => $fileURL,
            'message'  => 'File uploaded successfully'
        ]);
    }


    private function youtubeApi($data) 
    {
        $json = '[
            {
                "id": 1,
                "repairName": "Replace Fuse",
                "symptoms": "Appliance won\'t power on or shows no signs of life.",
                "solution": "Check the fuse with a multimeter and replace it if blown.",
                "partsNeeded": ["Thermal fuse"],
                "youtubeLinks": [
                    "https://www.youtube.com/watch?v=abc123",
                    "https://www.youtube.com/watch?v=def456"
                ]
            },
            {
                "id": 2,
                "repairName": "Fix Leaking Hose",
                "symptoms": "Water pooling under appliance or visible hose damage.",
                "solution": "Inspect hoses for cracks or loose connections and replace as necessary.",
                "partsNeeded": ["Replacement water hose", "Hose clamps"],
                "youtubeLinks": [
                    "https://www.youtube.com/watch?v=ghi789"
                ]
            },
            {
                "id": 3,
                "repairName": "Clean Condenser Coils",
                "symptoms": "Fridge not cooling efficiently or running constantly.",
                "solution": "Unplug the unit and vacuum or brush off dust from condenser coils.",
                "partsNeeded": ["Coil brush (optional)"],
                "youtubeLinks": []
            },
            {
                "id": 4,
                "repairName": "Replace Door Seal",
                "symptoms": "Warm air leaking into appliance or visible mold/cracks on gasket.",
                "solution": "Remove the old gasket and press in the new seal evenly around the door.",
                "partsNeeded": ["Door gasket/seal"],
                "youtubeLinks": [
                    "https://www.youtube.com/watch?v=jkl012",
                    "https://www.youtube.com/watch?v=mno345"
                ]
            },
            {
                "id": 5,
                "repairName": "Unclog Drain Pump",
                "symptoms": "Washer not draining or water left at the bottom after cycle.",
                "solution": "Access the drain pump, remove debris or buildup, and test operation.",
                "partsNeeded": ["None (unless pump is faulty)"],
                "youtubeLinks": [
                    "https://www.youtube.com/watch?v=stu901"
                ]
            }
        ]';

        return $json;
    }

}
