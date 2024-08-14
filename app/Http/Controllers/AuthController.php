<?php

namespace App\Http\Controllers;

use App\Helpers\Iyzico;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Exception;
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
        $request->validate([
            "name" => ["required"],
            "email" => ["email", "required", "unique:users,email"],
            "gender"=>["required"],
            "birthDate"=>["required","date","before_or_equal:{$today->format('Y-m-d')}"],
            "password" => ["required", "confirmed"],
            "tcno"=>["required","digits:11","unique:users,tc_no"],
            "address"=>["required"],
            "iban"=>["required","max:33"]
        ]);
        $birthDate=Carbon::parse($request->birthDate);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->gender=$request->gender;
        $user->birth_date=$birthDate->toDateString();
        $user->tc_no=$request->tcno;
        $user->address=$request->address;
        $user->iban=str_replace(" ","",$request->iban);
        if($user->save()){
            try{
                $iyzico=new Iyzico();
                $submerchant=$iyzico->createSubMerchant($user);
                $user->sub_merchant_key=$submerchant->getSubMerchantKey();
                $user->save();
            }catch(Exception $e){
                return redirect()->back()->withErrors([
                    "subMerchantError"=>$e->getMessage()
                ]);
            }
        }
        if (Auth::attempt(["email"=>$user->email,"password"=> $request->password])) {
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
