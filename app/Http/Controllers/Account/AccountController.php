<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index() {
        return view('pages.accounts.index');
    }

    public function update_data_user(Request $request) {
        User::where('id', Auth::user()->id)->update([
            'name' => $request->fullname,
            'email' => $request->email,
        ]);

        return redirect()->route('accounts');
    }

    public function update_password(Request $request) {

    }
}
