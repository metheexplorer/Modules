<?php namespace App\Modules\Tenant\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'student_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id', 'application_id'];

    public $timestamps = false;

    function add(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'client_id' => $client_id,
                'amount' => $request['amount'],
                'invoice_date' => insert_dateformat($request['invoice_date']),
                'discount' => $request['discount'],
                'invoice_amount' => $request['invoice_amount'],
                'description' => $request['description'],
                'due_date' => insert_dateformat($request['due_date']),
            ]);

            $student_invoice = StudentInvoice::create([
                'invoice_id' => $invoice->invoice_id,
                'application_id' => $request['course_application_id']
            ]);

            DB::commit();
            return $student_invoice->student_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }
}
