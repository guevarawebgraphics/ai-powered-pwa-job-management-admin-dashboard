<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\User;
use App\Models\SchedulePerUser;
use App\Models\Client;
use App\Models\Machine;
use App\Repositories\GigRepository;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
            // 'gig_cryptic' => 'required|unique:gigs,gig_cryptic,NULL,gig_id,deleted_at,NULL',
            'model_number_main'  =>  'required',
            'gig_price'          => 'required',
            'client_id' =>  'required',
            'start_date'    =>  'required',
            'start_time'    =>  'required',
            'initial_issue' => 'required',
            'assigned_tech_id'  =>  'required|exists:users,id',
            'trainee_included' => 'nullable|array', // Optional but must be an array if provided
            'trainee_included.*' => 'exists:users,id', // Validate each value if array exists
        ]);

        $input = $request->except('gig_id');
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['gig_type'] = isset($input['gig_type']) ? 1 : 0;
        $input['model_number'] =   $request->model_number_main;
        $input['trainee_included'] = $request->trainee_included ? implode(',', $request->trainee_included) : null; 
        $input['gig_price']  =  $this->calculatePrice($request->gig_price, $request->custom_gig_price); 

        // Remove Gig Cryptic input on form, this is auto generated by technician first and last initial, the # of jobs the tech has been on in his lifetime (+1 for this job), and a 3 letter acronym for the type of repair based on symptoms. Dryer No Heat. Washer No Spin.
        // - Jacob
        $input['gig_cryptic']   =   $this->generateGigCryptic($request->assigned_tech_id);

        // Combine start_date and start_time into a single datetime format
        if (!empty($request->start_date) && !empty($request->start_time)) {
            $input['start_datetime'] = Carbon::parse($request->start_date . ' ' . $request->start_time)
                ->toIso8601String();
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

        $input['top_recommended_repairs'] = $this->youtubeApi([ 'model_number'  =>  $request->model_number_main , 'initial_issue'  =>  $request->initial_issue  ]);

        // if (isset($input['top_recommended_repairs']) && is_array($input['top_recommended_repairs'])) {
        //     $formattedRepairs = [];
        //     foreach ($input['top_recommended_repairs'] as $index => $repair) {
        //         $formattedRepairs["repair" . ($index + 1)] = trim($repair);
        //     }

        //     // Check if it’s already a JSON string before encoding
        //     if (!is_string($input['top_recommended_repairs'])) {
        //         $input['top_recommended_repairs'] = json_encode($formattedRepairs, JSON_THROW_ON_ERROR);
        //     }   
        // }

        $gig = $this->gig_model->create($input);

        $gig_query = $this->gig_model->with(['machine','client','technician'])->where('gig_id', $gig->gig_id)->first();

        // if ($request->hasFile('banner_image')) {
        //     $file_upload_path = $this->gig_repository->uploadFile($request->file('banner_image')] = /*'banner_image'*/null, 'gig_images');
        //     $gig->fill(['banner_image' => $file_upload_path])->save();
        // }
        // if ($request->hasFile('file')) {
        //     $file_upload_path = $this->gig_repository->uploadFile($request->file('file'), /*'file'*/null, 'gig_files');
        //     $gig->fill(['file' => $file_upload_path])->save();
        // }



        $notification_response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config('app.frontend_url').'/api/notify/store', [
            'name' => 'New Job Added!',
            'content' => 'A new job has been added to schedule: Gig #' . $gig->gig_cryptic. ' - ' . strtoupper($gig_query->machine->brand_name) . ' ' . strtoupper($gig_query->machine->model_number) . ' ' . strtoupper($gig_query->machine->machine_type) . '. Check it out!',
            'user_id' => $gig->assigned_tech_id,
            'type' => 1, // 1 = GENERAL; 2=GUILD; 3=OTHER
            'icon_type' => 'fa-solid fa-briefcase',
            'url'   =>  config('app.frontend_url')."/gig/".$gig->gig_id,
            'is_urgent' =>  1,
            'featured_content'  =>  json_encode(
                [
                    'initial_issue' =>  $gig->initial_issue ?? '',
                    'gig_price' =>  $gig->gig_price  ?? ''
                ]
            )
        ]);

        // Get the response data
        $notif_json = $notification_response->json();




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

        $gig = $this->gig_model->with(['machine'])->findOrFail($id);

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
            // 'gig_cryptic' => 'required|unique:gigs,gig_cryptic,' . $id . ',gig_id,deleted_at,NULL',    
            'model_number_main'  =>  'required',
            'gig_price' =>  'required',
            'client_id' =>  'required',
            'start_date'    =>  'required',
            'start_time'    =>  'required',
            'initial_issue' => 'required',
            'trainee_included' => 'nullable|array', // Optional but must be an array if provided
            'trainee_included.*' => 'exists:users,id', // Validate each value if array exists
        ]);

        $gig = Gig::where('gig_id',$id)->first();
        $input = $request->except(['gig_id','start_date','start_time','gig_cryptic']);
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['gig_type'] = isset($input['gig_type']) ? 1 : 0;
        $input['model_number'] =   $request->model_number_main;
        $input['gig_price']  =  $this->calculatePrice($request->gig_price, $request->custom_gig_price); 
        
        $input['trainee_included'] = $request->trainee_included ? implode(',', $request->trainee_included) : null; 

        // Combine start_date and start_time into a single datetime format
        if (!empty($request->start_date) && !empty($request->start_time)) {
            $input['start_datetime'] = Carbon::parse($request->start_date . ' ' . $request->start_time)
                ->toIso8601String();
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

        if ( $request->initial_issue != $gig->initial_issue ) {
            $input['top_recommended_repairs'] = $this->youtubeApi([ 'model_number'  =>  $request->model_number_main , 'initial_issue'  =>  $request->initial_issue  ]);
        }
        // if (isset($input['top_recommended_repairs']) && is_array($input['top_recommended_repairs'])) {
        //     $formattedRepairs = [];
        //     foreach ($input['top_recommended_repairs'] as $index => $repair) {
        //         $formattedRepairs["repair" . ($index + 1)] = trim($repair);
        //     }

        //     // Check if it’s already a JSON string before encoding
        //     if (!is_string($input['top_recommended_repairs'])) {
        //         $input['top_recommended_repairs'] = json_encode($formattedRepairs, JSON_THROW_ON_ERROR);
        //     }   else {
        //         $input['top_recommended_repairs'] = null;
        //     }
        // } else {
        //      $input['top_recommended_repairs'] = null;
        // }


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


    private function generateGigCryptic($techID)
    {
        // Get the technician
        $technician = User::find($techID);
        if (!$technician) {
            return null; // Return null if technician not found
        }

        // Get Technician's First and Last Initials
        $initials = strtoupper(substr($technician->first_name, 0, 1) . substr($technician->last_name, 0, 1));

        // Get the total number of jobs the technician has completed
        $jobCount = Gig::where('assigned_tech_id', $techID)->count() + 1;

        // Get the latest record to extract repair symptoms
        $last_record = Gig::where('assigned_tech_id', $techID)
                        ->orderBy('created_at', 'DESC')
                        ->first();

        $repairType = "UNK"; // Default unknown repair type

        // if ($last_record && $last_record->machine) {
        //     $symptoms = strtolower($last_record->machine->symptoms); // Assuming symptoms is a text field
            
        //     // Extract first 3 consonants as the repair code
        //     $repairType = strtoupper($this->generateAcronym($symptoms));
        // }

        // Concatenate to create the Gig Cryptic string
        return "{$initials}{$jobCount}-{$repairType}";
    }

    /**
     * Generate a 3-letter acronym from a given text.
     */
    private function generateAcronym($text)
    {
        // Remove non-alphabetic characters
        $text = preg_replace('/[^a-zA-Z]/', '', $text);

        // Extract consonants
        $consonants = preg_replace('/[aeiou]/i', '', $text);

        // Take the first 3 consonants or fill with 'X' if not enough
        return strtoupper(substr($consonants, 0, 3) ?: 'UNK');
    }

    private function calculatePrice($price_name, $custom_price)
    {
        $priceMap = [
            ['name' => 'Diagnostic', 'amount' => 125.00],
            ['name' => 'Return for Repair', 'amount' => 125.00],
            ['name' => 'Stacked Diagnostic', 'amount' => 150.00],
            ['name' => 'Stacked Return for Repair', 'amount' => 150.00],
            ['name' => 'Full Repair', 'amount' => 250.00],
            ['name' => 'Stacked Full Repair', 'amount' => 300.00],
            ['name' => 'Other', 'amount' => 0.00], 
        ];

        foreach ($priceMap as $item) {
            if ($item['name'] === $price_name) {
                return ($price_name === 'Other') ? $custom_price : $item['amount'];
            }
        }

        return 0; // Default return value if no match is found
    }

    public function indexCalendar($techID) {
        if (!auth()->user()->hasPermissionTo('Read Gig')) {
            abort('401', '401');
        }

        $gigs = Gig::with(['machine','client','technician'])->where('assigned_tech_id', $techID)->whereNull('deleted_at')->get();
        $tech = User::find($techID);
        return view('admin.pages.gig.calendar', compact(['gigs','tech']));
    }

    public function getTechSchedules($techID) {

        $user = User::find($techID);
        $array = [
            'schedules' =>  SchedulePerUser::where('user_id', $techID)->whereNull('deleted_at')->orderBy('day','ASC')->get(),
            'black_out_date'    =>  [
                'from'   =>  $user->black_out_from,
                'to'   =>  $user->black_out_to,
                'is_blackout'   =>  $user->is_blackout,
                'black_out_dates'   =>  $user->black_out_dates,
            ]
        ];
        
        return response()->json([
            'message' => 'Schedule retrieved successfully',
            'data' => $array,
        ], 201);

    }


    private function youtubeApi($data) 
    {

        $machine = Machine::where('model_number', $data['model_number'])->first();
        
        $api = config('services.youtube.url');

        // $query = $machine->brand_name. ' ' . $machine->machine_type . ' model ' . $data['model_number'] . ' ' . $data['initial_issue'];

        $query = 'Im having issues with my ' . $machine->brand_name . ' ' . $machine->machine_type . ' ' . $data['model_number'] . ', ' . $data['initial_issue'] . ', What is the causes and what are the solutions?';

        $response = Http::asJson()  // <-- ensures the payload is sent as JSON
        ->post($api, [
            'query' => $query
        ]);

        $json = json_decode($response, true);

        // Loop through the repairs array and add an 'id' field
        foreach ($json['repairs'] as $index => $repair) {
            // Assign a unique ID (here using the index plus one)
            $json['repairs'][$index]['id'] = $index + 1;
        }


        return json_encode($json['repairs']);
    }            
}
