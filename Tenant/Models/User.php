<?php namespace App\Modules\Tenant\Models;

use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Tenant\Profile;
use Illuminate\Support\Facades\Request as FacadeRequest;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $connection = "tenant";

    /* Change the authentication guard to tenants */
    protected $guard = "tenants";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'status', 'activation_key', 'domain', 'role', 'permissions', 'person_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    protected $role = [1 => 'Admin', 2 => 'Staff', 3 => 'Accountant'];

    public function profile()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Person\Person', 'person_id');
    }

    function redirectIfValid($user)
    {
        /*if ($user->status == 0) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has not been activated.');
        } elseif ($user->status == 2) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has been suspended.');
        } elseif ($user->status == 3) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has been permanently blocked.');
        }*/
        return redirect()->route('tenant.client.index');
    }

    function saveUser($email = '', $details = array())
    {
        $setup = User::firstOrCreate(['email' => $email]);
        $setup->fullname = $details['fullname'];
        $setup->password = bcrypt($details['password']);
        $setup->save();
        Profile::firstOrCreate(['user_id' => $setup->id]);
    }

    function role()
    {
        return isset($this->role[$this->role]) ? $this->role[$this->role] : 'Unknown';
    }


    function withGuid($guid)
    {
        return User::with('Profile')->where('guid', $guid)->first();
    }

    public function getUserDetails($guid = '')
    {
        $details = DB::table('fb_users')
            ->join('fb_profile', 'fb_users.id', '=', 'fb_profile.user_id')
            ->where('fb_users.guid', $guid)
            ->first();

        $details->permissions = ($details->permissions != '') ? @unserialize($details->permissions) : '';

        if ($details->smtp != null) {
            $personal_email_setting = @json_decode($details->smtp);
            $details->incoming_server = $personal_email_setting->incoming_server;
            $details->outgoing_server = $personal_email_setting->outgoing_server;
            $details->email_username = $personal_email_setting->email_username;
            $details->email_password = $personal_email_setting->email_password;
        }

        return $details;
    }

    public function addUserDetails($details)
    {
        if (isset($details['permissions'])) {
            $per = serialize($details['permissions']);
        } else {
            $per = '';
        }
        $user = User::create([
            'fullname' => $details['fullname'],
            'password' => \Hash::make($details['password']),
            'role' => 2, //sub-user
            'first_time' => 1,
            'email' => $details['email'],
            'status' => 0, //pending
            'activation_key' => \FB::uniqueKey(15, 'fb_users', 'activation_key'),
            'permissions' => $per
        ]);

        $user_id = $user->id;

        $fileName = null;
        if (FacadeRequest::hasFile('photo')) {
            $file = FacadeRequest::file('photo');
            $fileName = \FB::uploadFile($file);
        }

        $email_setting_details = $details->only('incoming_server', 'outgoing_server', 'email_username', 'email_password');
        $personal_email_setting = json_encode($email_setting_details);

        $profile = Profile::create([
            'user_id' => $user_id,
            'phone' => $details['phone'],
            'address' => $details['address'],
            'postcode' => $details['postcode'],
            'town' => $details['town'],
            'comment' => $details['comment'],
            'tax_card' => $details['tax_card'],
            'photo' => $fileName,
            'social_security_number' => $details['social_security_number'],
            'smtp' => $personal_email_setting
        ]);

        $this->sendConfirmationMail($user->activation_key, $details['fullname'], $details['email']);

        $added_user['data'] = $this->toFomatedData($user);
        $added_user['template'] = $this->getTemplate($user);

        return $added_user;
    }

    /**
     * Send activation code in user's email
     * @param string $activation_key
     * @param string $username
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendConfirmationMail($activation_key = '', $username = '', $email = '')
    {
        //$link = \URL::route('subuser.register.confirm', $activation_key); //change this
        $link = tenant_route('subuser.register.confirm', array('confirmationCode' => $activation_key)); //change this
        \FB::sendEmail($email, $username, 'confirmation_email', ['{{NAME}}' => $username, '{{ACTIVATION_URL}}' => $link . " "]);
        $message = 'User created successfully.';
        \Flash::success($message);
    }


    public function updateUser($details = '')
    {
        $guid = $details['guid'];
        if (isset($details['permissions'])) {
            $per = serialize($details['permissions']);
        } else {
            $per = '';
        }
        $user = User::where('guid', $guid)->first();
        $user->fullname = $details['fullname'];
        $user->role = 2;
        $user->email = $details['email'];
        $user->permissions = $per;
        $user->save();

        $user_id = $user->id;

        $fileName = null;
        if (FacadeRequest::hasFile('photo')) {
            $file = FacadeRequest::file('photo');
            $fileName = \FB::uploadFile($file);
        }

        $email_setting_details = $details->only('incoming_server', 'outgoing_server', 'email_username', 'email_password');
        $personal_email_setting = json_encode($email_setting_details);

        $profile = Profile::where('user_id', $user_id)->first();
        $profile->user_id = $user_id;
        $profile->phone = $details['phone'];
        $profile->address = $details['address'];
        $profile->postcode = $details['postcode'];
        $profile->town = $details['town'];
        $profile->comment = $details['comment'];
        if ($fileName != null) {
            $profile->photo = $fileName; //unlink images
        }
        $profile->tax_card = $details['tax_card'];
        $profile->social_security_number = $details['social_security_number'];
        $profile->smtp = $personal_email_setting;
        $profile->save();

        $updated_user['data'] = $this->toFomatedData($user);
        $updated_user['template'] = $this->getTemplate($user);

        return $updated_user;
    }

    public function getTemplate($details = '')
    {
        $details->fullname = "<a href='" . tenant()->url('user') . "/" . $details->guid . "'>" . $details->fullname . "</a>";
        if ($details->status == 1)
            $details->status = '<span class="label label-success">Active</span>';
        elseif ($details->status == 2)
            $details->status = '<span class="label label-warning">Suspended</span>';
        elseif ($details->status == 3)
            $details->status = '<span class="label label-danger">Blocked</span>';
        else
            $details->status = '<span class="label label-warning">Pending</span>';

        $details->created = $details->created_at->format('d-M-Y h:i:s A');
        $details->days = '<a href="#" title="Register vacation" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' . tenant()->url('user/registerDays/vacation') . "/" . $details->guid . '" data-target="#fb-modal">Vacation</a><a href="#" title="Register Sick days" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' . tenant()->url('user/registerDays/sick') . "/" . $details->guid . '" data-target="#fb-modal">Sick</a>';


        $template = "<td>" . $details->fullname . "</td>
                     <td>" . $details->created . "</td>
                     <td>" . $details->email . "</td>
                     <td>" . $details->status . "</td>
                     <td>" . $details->days . "</td>";

        return $template;
    }

    function toFomatedData($data)
    {
        foreach ($data as $k => &$items) {
            $this->toArray();
        }

        return $data;
    }

    function isAdmin()
    {
        return ($this->role == 1) ? true : false;
    }

    function isUser()
    {
        return ($this->role == 2) ? true : false;
    }
}
