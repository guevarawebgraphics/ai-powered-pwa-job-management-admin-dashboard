<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\Client;
use App\Repositories\GigRepository;
use \Carbon\Carbon;

/**
 * Class GigController
 * @package App\Http\Controllers
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class GigController extends Controller
{
    /**
     * Gig model instance.
     *
     * @var Gig
     */
    private $gig_model;

    /**
     * GigRepository repository instance.
     *
     * @var GigRepository
     */
    private $gig_repository;

    /**
     * Create a new controller instance.
     *
     * @param Gig $gig_model
     * @param GigRepository $gig_repository
     */
    public function __construct(Gig $gig_model, GigRepository $gig_repository)
    {
        /*
         * Model namespace
         * using $this->gig_model can also access $this->gig_model->where('id', 1)->get();
         * */
        $this->gig_model = $gig_model;

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of gigs with other data (related tables).
         * */
        $this->gig_repository = $gig_repository;

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (!auth()->user()->hasPermissionTo('Read Gig')) {
            abort('401', '401');
        }

        $gigs = $this->gig_model->with(['machine','client'])->get();

        $client = [];
        

        return view('admin.pages.gig.index', compact('gigs', 'client'));
    }

    public function indexClientHistory($clientId)
    {
        if (!auth()->user()->hasPermissionTo('Read Gig')) {
            abort('401', '401');
        }
        if (!$clientId) {
            abort('404', '404');
        }

        $gigs = $this->gig_model->with(['machine','client'])->where('client_id', $clientId)->get();

        $client = Client::where('client_id', $clientId)->first();

        return view('admin.pages.gig.index', compact('gigs','client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Gig')) {
            abort('401', '401');
        }

        return view('admin.pages.gig.create');
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
        if (!auth()->user()->hasPermissionTo('Create Gig')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'gig_cryptic' => 'required|unique:gigs,gig_cryptic,NULL,gig_id,deleted_at,NULL',
            'model_number'  =>  'required',
            'gig_price' =>  'required|numeric',
            'client_id' =>  'required',
            'start_date'    =>  'required',
            'start_time'    =>  'required',
            'initial_issue' => 'required'
        ]);

        $input = $request->except('gig_id');
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        
        // Combine start_date and start_time into a single datetime format
        if (!empty($request->start_date) && !empty($request->start_time)) {
            $input['start_datetime'] = Carbon::parse($request->start_date . ' ' . $request->start_time)->format('Y-m-d H:i:s');
        }
        if (isset($input['parts_used']) && is_array($input['parts_used'])) {
            $formattedRepairsUsed = [];
            foreach ($input['parts_used'] as $index => $repair) {
                $formattedRepairsUsed["repair" . ($index + 1)] = trim($repair);
            }

            // Check if it’s already a JSON string before encoding
            if (!is_string($input['parts_used'])) {
                $input['parts_used'] = json_encode($formattedRepairsUsed, JSON_THROW_ON_ERROR);
            }  else {
                $input['parts_used'] = null;
            }
        } else {
            $input['parts_used'] = null;
        }

        // Remove start_date and start_time from the input array if they're not needed
        unset($request->start_date, $request->start_time);

        if (isset($input['top_recommended_repairs']) && is_array($input['top_recommended_repairs'])) {
            $formattedRepairs = [];
            foreach ($input['top_recommended_repairs'] as $index => $repair) {
                $formattedRepairs["repair" . ($index + 1)] = trim($repair);
            }

            // Check if it’s already a JSON string before encoding
            if (!is_string($input['top_recommended_repairs'])) {
                $input['top_recommended_repairs'] = json_encode($formattedRepairs, JSON_THROW_ON_ERROR);
            }   
        }

        $gig = $this->gig_model->create($input);

        // if ($request->hasFile('banner_image')) {
        //     $file_upload_path = $this->gig_repository->uploadFile($request->file('banner_image')] = /*'banner_image'*/null, 'gig_images');
        //     $gig->fill(['banner_image' => $file_upload_path])->save();
        // }
        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->gig_repository->uploadFile($request->file('file'), /*'file'*/null, 'gig_files');
        //     $gig->fill(['file' => $file_upload_path])->save();
        // }

        return redirect()->route('admin.gigs.index')->with('flash_message', [
            'title' => '',
            'message' => 'Gig ' . $gig->gig_cryptic . ' successfully added.',
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
        if (!auth()->user()->hasPermissionTo('Read Gig')) {
            abort('401', '401');
        }

        $gig = $this->gig_model->findOrFail($id);

        return view('admin.pages.gig.show', compact('gig'));
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
        if (!auth()->user()->hasPermissionTo('Update Gig')) {
            abort('401', '401');
        }

        $gig = $this->gig_model->findOrFail($id);

        return view('admin.pages.gig.edit', compact('gig'));
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
        if (!auth()->user()->hasPermissionTo('Update Gig')) {
            abort('401', '401');
        }

        $this->validate($request, [
            'gig_cryptic' => 'required|unique:gigs,gig_cryptic,' . $id . ',gig_id,deleted_at,NULL',    
            'model_number'  =>  'required',
            'gig_price' =>  'required|numeric',
            'client_id' =>  'required',
            'start_date'    =>  'required',
            'start_time'    =>  'required',
            'initial_issue' => 'required'
        ]);

        $gig = Gig::where('gig_id',$id)->first();
        $input = $request->except(['gig_id','start_date','start_time']);
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        
        // Combine start_date and start_time into a single datetime format
        if (!empty($request->start_date) && !empty($request->start_time)) {
            $input['start_datetime'] = Carbon::parse($request->start_date . ' ' . $request->start_time)->format('Y-m-d H:i:s');
        }
        if (isset($input['parts_used']) && is_array($input['parts_used'])) {
            $formattedRepairsUsed = [];
            foreach ($input['parts_used'] as $index => $repair) {
                $formattedRepairsUsed["repair" . ($index + 1)] = trim($repair);
            }

            // Check if it’s already a JSON string before encoding
            if (!is_string($input['parts_used'])) {
                $input['parts_used'] = json_encode($formattedRepairsUsed, JSON_THROW_ON_ERROR);
            }  else {
                $input['parts_used'] = null;
            }
        } else {
            $input['parts_used'] = null;
        }

        // Remove start_date and start_time from the input array if they're not needed
        unset($request->start_date, $request->start_time);

        if (isset($input['top_recommended_repairs']) && is_array($input['top_recommended_repairs'])) {
            $formattedRepairs = [];
            foreach ($input['top_recommended_repairs'] as $index => $repair) {
                $formattedRepairs["repair" . ($index + 1)] = trim($repair);
            }

            // Check if it’s already a JSON string before encoding
            if (!is_string($input['top_recommended_repairs'])) {
                $input['top_recommended_repairs'] = json_encode($formattedRepairs, JSON_THROW_ON_ERROR);
            }   else {
                $input['top_recommended_repairs'] = null;
            }
        } else {
             $input['top_recommended_repairs'] = null;
        }

        $gig->fill($input)->save();

        return redirect()->route('admin.gigs.index')->with('flash_message', [
            'title' => '',
            'message' => 'Gig ' . $gig->gig_cryptic . ' successfully updated.',
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
        if (!auth()->user()->hasPermissionTo('Delete Gig')) {
            abort('401', '401');
        }

        $gig = $this->gig_model->findOrFail($id);
        $gig->delete();

        $response = array(
            'status' => FALSE,
            'data' => array(),
            'message' => array(),
        );

        $response['message'][] = 'Gig successfully deleted.';
        $response['data']['id'] = $id;
        $response['status'] = TRUE;

        return response()->json($response);
    }
}
