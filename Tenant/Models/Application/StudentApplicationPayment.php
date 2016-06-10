<?php namespace App\Modules\Tenant\Models\Application;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentApplicationPayment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_application_payments';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'student_paymens_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'client_payment_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
