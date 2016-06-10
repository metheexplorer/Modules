<?php
namespace App\Modules\Tenant\Models;

use App\Modules\Tenant\Models\Institute\SuperAgentInstitute;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tenant\Models\Company\Company;

Class Agent extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'agents';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'agent_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['agent_id', 'description', 'company_id'];



    /*
     * Add agent info
     * Output agent id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {
            // Saving phone number
            $phone = new Phone();
            $phone_id = $phone->add($request['number']);

            // Saving company
            $company = Company::create([
                'name' => $request['name'],
                'phone_id' => $phone_id,
                'abn' => $request['abn'],
                'acn' => $request['acn'],
                'website' => $request['website'],
                'invoice_to_name' => $request['invoice_to_name']
            ]);

            $agent = Agent::create([
                'description' => $request['description'],
                'company_id' => $company->company_id
            ]);

            // Add address
            /*$address = Address::create([
                'street' => $request['street'],
                'suburb' => $request['suburb'],
                'postcode' => $request['postcode'],
                'state' => $request['state'],
                'country_id' => $request['country_id'],
            ]);

            PersonAddress::create([
                'address_id' => $address->address_id,
                'person_id' => $person->person_id,
                'is_current' => 1
            ]);*/

            DB::commit();
            return $agent->agent_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getRemaining($institute_id)
    {
        $agents = $this->getAll();

        foreach($agents as $key => $agent)
        {
            $existing = SuperAgentInstitute::where('institute_id', $institute_id)->where('agents_id', $key)->first();
            if($existing)
                unset($agents[$key]);
        }
        return $agents;
    }

    function getAll()
    {
        $agents = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->orderBy('agents.agent_id', 'desc')
            ->lists('companies.name', 'agents.agent_id');
        return $agents;
    }

    function getName($agent_id)
    {
        $agent = Agent::leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->select(['companies.name'])
            ->where('agents.agent_id', $agent_id)
            ->first();

        if(!empty($agent))
            return $agent->name;
        else
            return 'Undefined';
    }

}