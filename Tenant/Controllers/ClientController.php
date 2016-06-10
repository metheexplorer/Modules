<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientDocument;
use App\Modules\Tenant\Models\Document;
use Flash;
use DB;

use Illuminate\Http\Request;

class ClientController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'first_name' => 'required|min:2|max:55',
        'last_name' => 'required|alpha|min:2|max:55',
        'middle_name' => 'alpha|min:2|max:55',
        'dob' => 'required',
        'passport_no' => 'required',
        'phone' => 'required'
    ];

    function __construct(Client $client, Request $request, ClientDocument $document)
    {
        $this->client = $client;
        $this->request = $request;
        $this->document = $document;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Tenant::Client/index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData()
    {
        $clients = Client::leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('users', 'clients.user_id', '=', 'users.user_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->select(['clients.client_id', 'clients.added_by', 'users.email', 'users.status', 'phones.number as phone', 'clients.created_at', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname')]);

        $datatable = \Datatables::of($clients)
            ->addColumn('action', '<a data-toggle="tooltip" title="View Client" class="btn btn-action-box" href ="{{ route( \'tenant.client.show\', $client_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Client Documents" class="btn btn-action-box" href ="{{ route( \'tenant.client.document\', $client_id) }}"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Edit Client" class="btn btn-action-box" href ="{{ route( \'tenant.client.edit\', $client_id) }}"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Client" class="delete-user btn btn-action-box" href="{{ route( \'tenant.client.destroy\', $client_id) }}"><i class="fa fa-trash"></i></a>')
            ->editColumn('status', '@if($status == 0)
                                <span class="label label-warning">Pending</span>
                            @elseif($status == 1)
                                <span class="label label-success">Activated</span>
                            @elseif($status == 2)
                                <span class="label label-info">Suspended</span>
                            @else
                                <span class="label label-danger">Trashed</span>
                            @endif')
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            });
        //->editColumn('referred_by', function($data){return get_user_name($data->referred_by); })
        // Global search function
        if ($keyword = $this->request->get('search')['value']) {
            $datatable->filterColumn('fullname', 'whereRaw', "CONCAT(persons.first_name, ' ', persons.last_name) like ?", ["%$keyword%"]);
        }
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Client/add');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Additional validations for creating user */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->client->add($this->request->all());
        if ($created)
            Flash::success('Client has been created successfully.');
        return redirect()->route('tenant.client.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $client_id
     * @return Response
     */
    public function show($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/show", $data);
    }

    public function personal_details($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/personal_details", $data);
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


    /**
     * Attach document to the client.
     *
     * @param  int $client_id
     * @return Response
     */
    function document($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        $data['documents'] = $this->document->getClientDocuments($client_id);
        return view("Tenant::Client/document", $data);
    }

    function uploadDocument($client_id)
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
            $this->document->uploadDocument($client_id, $file_info, $this->request->all());
            \Flash::success('File uploaded successfully!');
            return redirect()->route('tenant.client.document', $client_id);
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

    function notes($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/notes", $data);
    }

    function payment_dashboard($client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/payments", $data);
    }

}
