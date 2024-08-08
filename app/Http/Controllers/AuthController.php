<?php

namespace App\Http\Controllers;

use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    //
    public function loginView()
    {
        if (!is_null(Auth::user())) {
            return redirect()->route("home");
        }
        return Inertia::render("Auth/Login");
    }
    public function login(Request $request)
    {
        $cred = $request->validate([
            "email" => ["email", "required"],
            "password" => ["required"],
        ]);
        if (Auth::attempt($cred, $request->input("remember"))) {
            $request->session()->regenerate();
            return redirect()->intended(route("account.index"));
        }
        return back()->withErrors([
            "credentials"=>"Lütfen girdiğiniz bilgileri kontrol ediniz !"
        ]);
    }

    public function registerView()
    {
        if (!is_null(Auth::user())) {
            return redirect()->route("home");
        }
        return Inertia::render("Auth/Register");
    }
    public function register(Request $request)
    {
        $today=new DateTime();
        $today->sub(new DateInterval("P18Y"));
        $cred = $request->validate([
            "name" => ["required"],
            "email" => ["email", "required", "unique:App\Models\User,email"],
            "gender"=>["required"],
            "birthDate"=>["required","date","before_or_equal:{$today->format('Y-m-d')}"],
            "password" => ["required", "confirmed"],
        ]);
        $user = new User;
        $user->name = $cred["name"];
        $user->email = $cred["email"];
        $user->password = $cred["password"];
        $user->gender=$cred["gender"];
        $user->birth_date=$cred["birthDate"];
        $user->save();
        if (Auth::attempt(["email"=>$user->email,"password"=> $cred["password"]])) {
            $request->session()->regenerate();
            return redirect()->intended(route("account.settings"));
        } 
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
