<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index() {
        return view('pages.accounts.index');
    }

    public function update_data_user(Request $request) {
        try {
            User::where('id', Auth::user()->id)->update([
                'name' => $request->fullname,
                'email' => $request->email,
            ]);
    
            return redirect()->route('accounts')->with('success', 'Updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('accounts')->with('failed', 'Updated failed.');
        }
    }

    public function update_password(Request $request) {
        try {
            if(Hash::check($request->current_password, Auth::user()->password)) {
                if ($request->new_password == $request->confirm_password) {
                    User::where('id', Auth::user()->id)->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                    return redirect()->route('accounts')->with('success', 'Change password successfully.');
                }
                return redirect()->route('accounts')->with('failed', 'New password and confirm password are different.');
            }
            return redirect()->route('accounts')->with('failed', 'Current password is wrong.');
        } catch (\Throwable $th) {
            return redirect()->route('accounts')->with('failed', 'Change password failed.');
        }
    }
}
