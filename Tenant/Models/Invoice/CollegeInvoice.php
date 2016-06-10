<?php namespace App\Modules\Tenant\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use DB;

class CollegeInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'college_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'college_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'commission_percent', 'commission_amount', 'invoice_amount', 'enrollment_fee', 'material_fee', 'coe_fee', 'other_fee', 'sub_total', 'incentive', 'gst', 'total_commission', 'payable_to_college', 'due_date', 'installment_no', 'invoice_date'];

    function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $college_invoice = CollegeInvoice::create([
                'course_application_id' => $application_id,
                'commission_percent' => $request['commission_percent'],
                'commission_amount' => $request['commission_amount'],
                'invoice_amount' => $request['invoice_amount'],
                'enrollment_fee' => $request['enrollment_fee'],
                'material_fee' => $request['material_fee'],
                'coe_fee' => $request['coe_fee'],
                'other_fee' => $request['other_fee'],
                'sub_total' => $request['sub_total'],
                'incentive' => $request['incentive'],
                'gst' => $request['gst'],
                'total_commission' => $request['total_commission'],
                'payable_to_college' => $request['payable_to_college'],
                'due_date' => insert_dateformat($request['due_date']),
                'installment_no' => $request['installment_no'],
                'invoice_date' => insert_dateformat($request['invoice_date'])
            ]);

            DB::commit();
            return $college_invoice->college_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

}
