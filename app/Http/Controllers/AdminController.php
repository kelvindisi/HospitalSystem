<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\RoleUser;
use App\PaymentMode;

class AdminController extends Controller
{
    /*
    * Returns admin dashboad with summary data
    */
    public function index()
    {
        $data['staffs'] = User::limit(10)->latest()->get();
        $data['deactivated'] = User::where(['account_status' => false])->count();
        $data['staff_count'] = User::all()->count();
        $data['admin_count'] = Role::where(['name'=> 'admin'])->first()->users()->count();
        return view('admin.dashboard')->with($data);
    }

    /*
    * Returns the create form
    */
    public function create()
    {
        return view('admin.create_staff');
    }

    /*
    *  Store new staff details
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_number' => ['required', 'numeric', 'unique:users'],
            'gender' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $data['password'] = Hash::make($data['password']);

        $saveUser = User::create($data);

        return redirect(url("/admin/{$saveUser->id}/"));
    }

    /*
    * Returns details of single staff
    * args(user_id) -> auto fetches the user using the id
    */
    public function details(Request $request, User $user)
    {
        $roles = Role::all();
        $user['name'] = Str::title($user['name']);
        return view('admin.staff_details')->with(['staff' => $user, 'roles' => $roles]);
    }

    /*
    * Adds role to a user
    * Removes any role assigned before assigning other
    */
    public function addRole(Request $request)
    {
        $details = $request->validate([
            'staff_id' => 'required|numeric',
            'role_id' => 'required|numeric'
        ]);

        if (Auth::user()->id == $details['staff_id'])
            return redirect(url("admin/{$details['staff_id']}/"))->with('error', 'You cannot change your own role, another administrator should do it');
        
        if (!Role::find($details['role_id']))
            return redirect(url("admin/{$details['staff_id']}/"))->with('error', 'There is no such role');
        
        if (!User::find($details['staff_id']))
            return redirect(url("admin/{$details['staff_id']}/"))->with('error', 'The staff is not in our records');
        
        RoleUser::where(['user_id'=>$details['staff_id']])->delete();
        DB::table('role_user')->insert(['user_id' => $details['staff_id'], 'role_id' => $details['role_id']]);

        RoleUser::where(['user_id' => $details['staff_id']])->get();

        return redirect(url("admin/{$details['staff_id']}"))->with('message', 'Role was added to user successfully');
    }

    /*
    * Return list of all staffs
    */
    public function staffList()
    {
        $staffs = User::all();
        return view('admin.manage_staff')->with(['staffs' => $staffs]);
    }

    /*
    * Update user account status from active to deactivated and vice versa
    */
    public function statusChanger(Request $request, User $user)
    {
        if (Auth::user()->id == $user->id)
            return redirect(route('staff_list'))->with('warning', 'You cannot change status of your own account');
        
        $status = !$user->account_status;
        $user->account_status = $status;
        $user->save();
        $status_message = $status? "activated, can now login" : "deactivated, cannot access account";

        return redirect(route('staff_list'))->with('success', "Staff was {$status_message}");
    }

    /*
    * User update form rendering
    */
    public function edit(Request $request, User $user)
    {
        return view('admin.staff_edit')->with(['staff' => $user]);
    }

    /*
    * Store update information
    */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'id_number' => ['required', 'numeric'],
            'gender' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email']
        ]);

        if ($request->post('password'))
        {
            $pass_data =  $request->validate([
                'password' => 'required|min:8|confirmed'
            ]);
            $data['password'] = Hash::make($pass_data['password']);
        }
        $filterBy = ['id_number', 'email'];

        foreach($filterBy as $filter)
        {
            $filteredUsers = User::where($filter, $data[$filter])->get();
            foreach($filteredUsers as $singleUser)
            {
                if ($singleUser->id != $user->id)
                {
                    $messages = [
                        'id_number' => 'The ID Number belongs to another user',
                        'email' => 'The Email address belongs to another user'
                    ];
                    $message = $messages[$filter];
                    return redirect(route('edit_staff',['user'=>$user->id]))->with('error', $message);
                }
            }
        }
        
        // passed the validation of the credentials
        $user->update($data);

        return redirect(route('details_staff', ['user' => $user->id]))->with('success', 'User account updated successfully.');
    }
    /**
     * List Payment Mode
     */
    public function paymentModes()
    {
        $modes = PaymentMode::all();
        return view('admin.payment_modes')->with(['modes' => $modes]);
    }
    public function addPaymentMode()
    {
        return view('admin.add_payment_mode');
    }
    public function saveMode(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:payment_modes',
            'consultation_fee' => 'required|numeric'
        ]);
        
        PaymentMode::create($data);
        return redirect(route('payment_modes'))
            ->with('success', 'Successfully saved');
    }
    public function editMode(Request $request, PaymentMode $mode)
    {
        return view('admin.edit_mode')->with(['mode' =>$mode]);
    }
    
    public function updateMode(Request $request, PaymentMode $mode)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'consultation_fee' => 'required|numeric'
        ]);

        $searchedMode = PaymentMode::where(['name' => $data['name']])->first();
        if ($searchedMode)
        {
            if ($searchedMode->id != $mode->id)
            {
                return redirect(route('payment_mode_edit', ['mode' => $mode->id]))
                    ->with('error', "Payment Mode called {$data['name']} already exists");
            }
        }
        // Passed validation and not in database -- UPDATE
        $mode->update($data);
        return redirect(route('payment_modes'))
            ->with('success', 'Payment mode details updated successfully.');
    }
}
