<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use App\Modules\Tenant\Models\Institute\InstituteDocument;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Institute\SuperAgentInstitute;
use Flash;
use DB;

use Illuminate\Http\Request;

class InstituteController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'short_name' => 'required|min:2|max:55',
        'phone' => 'required',
        
    ];

    function __construct(Institute $institute, Request $request, InstituteDocument $document, SuperAgentInstitute $superagent, Agent $agent)
    {
        $this->institute = $institute;
        $this->request = $request;
        $this->document = $document;
        $this->superagent = $superagent;
        $this->agent = $agent;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Tenant::Institute/index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData()
    {
        $institutes = Institute::leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            ->select(['institutes.institution_id', 'institutes.short_name', 'institutes.created_at', 'companies.name', 'companies.phone_id', 'companies.website','companies.invoice_to_name', 'phones.number'])
            ->orderBy('institution_id', 'desc');

        $datatable = \Datatables::of($institutes)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Institute" class="btn btn-action-box" href ="{{ route( \'tenant.institute.show\', $institution_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Institute Documents" class="btn btn-action-box" href ="{{ route( \'tenant.institute.document\', $institution_id) }}"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Institute" class="btn btn-action-box" href ="{{ route( \'tenant.institute.edit\', $institution_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Institute" class="delete-user btn btn-action-box" href="{{ route( \'tenant.institute.destroy\', $institution_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('institution_id', function ($data) {
                return format_id($data->institution_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the courses through ajax request.
     *
     * @return JSON response
     */
    function getCoursesData($institute_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->leftJoin('course_commissions', 'course_commissions.course_id', '=', 'courses.course_id')
            ->leftJoin('commissions', 'commissions.commission_id', '=', 'course_commissions.commissions_id')
            ->where('institute_courses.institute_id', $institute_id)
            ->select(['institute_courses.description', 'courses.course_id', 'courses.name', 'courses.level', 'fees.total_tuition_fee', 'commissions.commission_percent'])
            ->orderBy('course_id', 'desc');

        $datatable = \Datatables::of($courses)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Course" class="btn btn-action-box" href ="{{ route( \'tenant.course.show\', $course_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Course" class="btn btn-action-box" href ="{{ route( \'tenant.course.edit\', $course_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Course" class="delete-user btn btn-action-box" href="{{ route( \'tenant.course.destroy\', $course_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('course_id', function ($data) {
                return format_id($data->course_id, 'Cou');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the intakes through ajax request.
     *
     * @return JSON response
     */
    function getIntakesData($institute_id)
    {
        $intakes = Institute::join('institute_intakes', 'institute_intakes.institute_id', '=', 'institutes.institution_id')
            ->join('intakes', 'intakes.intake_id', '=', 'institute_intakes.intake_id')
            ->where('institute_intakes.institute_id', $institute_id)
            ->select(['intakes.*'])
            ->orderBy('intake_id', 'desc');

        $datatable = \Datatables::of($intakes)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Intake" class="btn btn-action-box" href ="{{ route( \'tenant.intake.show\', $intake_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Intake" class="btn btn-action-box" href ="{{ route( \'tenant.intake.edit\', $intake_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Intake" class="delete-user btn btn-action-box" href="{{ route( \'tenant.intake.destroy\', $intake_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('intake_id', function ($data) {
                return format_id($data->intake_id, 'Int');
            });
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Institute/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Additional validations for creating institution */
        $this->rules['name'] = 'required|min:2|max:255|unique:companies';

        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->institute->add($this->request->all());
        if ($created)
            Flash::success('Institute has been created successfully.');
        return redirect()->route('tenant.institute.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function show($institution_id)
    {
        $data['super_agents'] = $this->superagent->getDetails($institution_id);
        $data['agents'] = $this->agent->getRemaining($institution_id);
        $data['institute'] = $this->institute->getDetails($institution_id);
        return view("Tenant::Institute/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($institution_id)
    {
        /* Getting the institute details*/
        $data['institute'] = $this->institute->getDetails($institution_id);
        //dd($data['institute']->toArray());
        if ($data['institute'] != null) {
            //dd($data['institute']->dob);
            $data['institute']->dob = format_date($data['institute']->dob);
            return view('Tenant::Institute/edit', $data);
        } else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function update($institution_id)
    {
        $user_id = $this->request->get('user_id');
        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id . ',user_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->institute->edit($this->request->all(), $institution_id);
        if ($updated)
            Flash::success('Institute has been updated successfully.');
        return redirect()->route('tenant.institute.index');
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


    /**
     * Attach document to the institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function document($institution_id)
    {
        $data['documents'] = $this->document->getInstituteDocuments($institution_id);
        return view("Tenant::Institute/document", $data);
    }

    function uploadDocument($institution_id)
    {
        $upload_rules = ['document' => 'required|mimes:jpeg,bmp,png,doc,docx,pdf,txt,xls,xlsx',
            'description' => 'required',
            'type' => 'required',
        ];
        $this->validate($this->request, $upload_rules);

        $folder = 'document';
        $file = $this->request->input('document');
        $file = ($file == '') ? 'document' : $file;

        if ($file_info = tenant()->folder($folder, true)->upload($file)) {
            $this->document->uploadDocument($institution_id, $file_info, $this->request->all());
            \Flash::success('File uploaded successfully!');
            return redirect()->route('tenant.institute.document', $institution_id);
        }

        \Flash::danger('Uploaded file is not valid!');
        return redirect()->back();
    }

    function downloadDocument($id)
    {
        $document = Document::find($id);
        if (empty($document))
            abort(404);

        tenant()->folder('document')->download($document->name);
    }

    /**
     * Add contact persons to institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function storeContact($institution_id)
    {
        $contact_id = $this->institute->addContact($institution_id, $this->request->all());
        if ($contact_id) {
            \Flash::success('Contact added successfully!');
            return redirect()->route('tenant.institute.show', $institution_id);
        }
    }

    /**
     * Add contact persons to institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function storeAddress($institution_id)
    {
        $contact_id = $this->institute->addAddress($institution_id, $this->request->all());
        if ($contact_id) {
            \Flash::success('Address added successfully!');
            return redirect()->route('tenant.institute.show', $institution_id);
        }
    }

}
