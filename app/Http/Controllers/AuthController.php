<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Invalid login');
        }

        $passwordIsBcrypt = preg_match('/^\$2[ayb]\$.{56}$/', $user->password);
        $validPassword = false;

        if ($passwordIsBcrypt) {
            $validPassword = Hash::check($request->password, $user->password);
        } else {
            $validPassword = hash_equals($user->password, $request->password);
        }

        if (!$validPassword) {
            return back()->with('error', 'Invalid login');
        }

        if (!$passwordIsBcrypt) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => Hash::make($request->password)]);
        }

        session([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        if ($user->role == 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/employee/dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}