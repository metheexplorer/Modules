<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use Flash;
use DB;

use Illuminate\Http\Request;

class ApplicationController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, Institute $institute, Agent $agent,CollegePayment $payment)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->institute = $institute;
        $this->agent = $agent;
        $this->payment = $payment;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/Application/index", $data);
    }

    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getApplicationsData($client_id)
    {
        $clients = CourseApplication::leftJoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftJoin('intakes', 'course_application.intake_id', '=', 'intakes.intake_id')
            ->where('course_application.client_id', $client_id)
            ->select(['companies.name', 'courses.name as course_name', 'course_application.end_date', 'intakes.orientation_date', 'course_application.student_id', 'course_application.course_application_id as application_id', 'course_application.tuition_fee', 'course_application.user_id as added_by']);

        $datatable = \Datatables::of($clients)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Application" class="btn btn-action-box" href ="{{ route( \'tenant.application.show\', $application_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Application Documents" class="btn btn-action-box" href ="{{ route( \'tenant.application.document\', $application_id) }}"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Application" class="btn btn-action-box" href ="{{ route( \'tenant.application.edit\', $application_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Application" class="delete-user btn btn-action-box" href="{{ route( \'tenant.application.destroy\', $application_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('application_id', function ($data) {
                return format_id($data->application_id, 'App');
            })
            ->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            })
            ->addColumn('status', 'COE Processing'); //change this later
        // Global search function
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($client_id)
    {
        $data['institutes'] = $this->institute->getList();
        $data['courses'] = ['' => 'Select Course'];
        $data['intakes'] = ['' => 'Select Intake'];
        $data['client'] = $this->client->getDetails($client_id);
        return view('Tenant::Client/Application/add', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($client_id)
    {
        /* Additional validations for creating user */
        /*$this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($this->request, $this->rules);*/
        // if validates
        $created = $this->application->add($this->request->all(), $client_id);
        if ($created)
            Flash::success('Application has been created successfully.');
        return redirect()->route('tenant.client.application', $client_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_id
     * @return Response
     */
    public function show($application_id)
    {
        $data['agents'] = $this->agent->getAll();
        $data['application'] = $application = $this->application->getDetails($application_id); //dd($data['application']->toArray());
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::Client/Application/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($client_id)
    {
        /* Getting the client details*/
        $data['client'] = $this->client->getDetails($client_id);
        if ($data['client'] != null) {
            $data['client']->dob = format_date($data['client']->dob);
            return view('Tenant::Client/edit', $data);
        } else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $client_id
     * @return Response
     */
    public function update($client_id)
    {
        $user_id = $this->request->get('user_id');
        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id . ',user_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->client->edit($this->request->all(), $client_id);
        if ($updated)
            Flash::success('Client has been updated successfully.');
        return redirect()->route('tenant.client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function createSubAgent($application_id, Request $request)
    {
        $application = CourseApplication::find($application_id);
        $application->sub_agent_id = $request->agent_id;
        $application->save();

        Flash::success('Sub Agent has been added successfully.');
        return redirect()->route('tenant.application.show', $application_id);
    }

    public function applicationStatus($client_id){
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::ApplicationStatus/enquiry", $data);
    }

}
