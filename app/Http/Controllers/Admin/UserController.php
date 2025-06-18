<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Group;
use App\Models\Config;
use App\Models\QrCode;
use App\Models\Barcode;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // All Users
    public function index()
    {
        // Queries
        $users = User::orderBy('created_at', 'desc')->get();
        $settings = Setting::where('status', 1)->first();
        $config = Config::get();

        return view('admin.pages.users.index', compact('users', 'settings', 'config'));
    }

    // View User
    public function viewUser(Request $request, $id)
    {
        // Get user details
        $user_details = User::where('id', $id)->first();

        // Check user
        if ($user_details == null) {
            return view('errors.404');
        } else {
            // Queries
            $bar_codes = Barcode::where('user_id', $user_details->id)->orderBy('id', 'desc')->get();
            $qr_codes = QrCode::where('user_id', $user_details->id)->orderBy('id', 'desc')->get();
            $settings = Setting::where('status', 1)->first();

            return view('admin.pages.users.view', compact('user_details', 'settings', 'bar_codes', 'qr_codes'));
        }
    }

    // Edit User
    public function editUser(Request $request, $id)
    {
        // Get user details
        $user_details = User::where('id', $id)->first();
        $settings = Setting::where('status', 1)->first();

        // Check user
        if ($user_details == null) {
            return view('errors.404');
        } else {
            return view('admin.pages.users.edit', compact('user_details', 'settings'));
        }
    }

    // Update User
    public function updateUser(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'full_name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        // Update user details
        if ($request->password == null) {
            // Update
            User::where('id', $request->user_id)->update([
                'name' => $request->full_name,
                'email' => $request->email
            ]);
        } else {
            // Update
            User::where('id', $request->user_id)->update([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }

        // Page redirect
        return redirect()->back()->with('success', trans('User Updated Successfully!'));
    }

    // Update status
    public function updateStatus(Request $request)
    {
        // Get user details
        $user_details = User::where('id', $request->query('id'))->first();
        // Check status
        if ($user_details->status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        // Update status
        User::where('id', $request->query('id'))->update(['status' => $status]);
        // Page redirect
        return redirect()->back()->with('success', trans('User Status Updated Successfully!'));
    }

    // Delete User
    public function deleteUser(Request $request)
    {
        $user = User::where('id', $request->query('id'))->first();

        $alert = 'failed';
        $message = trans('You are unable to remove the admin user');

        if ($user->role_id != 1) {
            QrCode::where('user_id', $user->id)->delete();
            Barcode::where('user_id', $user->id)->delete();
            Group::where('user_id', $user->id)->delete();

            // Delete user
            User::where('id', $request->query('id'))->delete();

            $alert = 'success';
            $message = trans('User deleted Successfully!');
        }

        // Page redirect
        return redirect()->back()->with($alert, $message);
    }

    // Login As User
    public function authAs($id)
    {
        // Check user details
        $user_details = User::where('id', $id)->where('status', 1)->first();

        // Check user
        if (isset($user_details)) {
            // Login user
            Auth::loginUsingId($user_details->id);
            // Page redirect
            return redirect()->route('admin.dashboard');
        } else {
            // User not found and page redirect
            return redirect()->route('admin.users')->with('info', 'User account was not found!');
        }
    }
}
