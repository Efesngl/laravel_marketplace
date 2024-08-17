<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AccountController extends Controller
{
    //
    public function index()
    {
        return Inertia::render("Account/AccountDetails");
    }
    public function products(Request $request, string $status)
    {
        if ($status != "active" && $status != "inactive") {
            abort(404);
        }
        $products = auth()->user()->products()->where("is_active", "=", ($status == "active") ? true : false)->get();
        return Inertia::render("Account/Products", [
            "products" => $products
        ]);
    }
    public function updateProfile(Request $request)
    {
        $today = new DateTime();
        $today->sub(new \DateInterval("P18Y"));
        $profile = $request->validate([
            "name" => ["required"],
            "birthDate" => ["required", "date", "before_or_equal:{$today->format('Y-m-d')}"],
            "gender" => ["required"],
            "iban"=>["required",Rule::unique("users","iban")->ignore(auth()->user()->id)],
            "address"=>["required"]
        ]);
        $date = Carbon::parse($request->birthDate)->setTimezone(config("app.timezone"));
        $user = auth()->user();
        $user->name = $profile["name"];
        $user->gender = $profile["gender"];
        $user->birth_date = $date->toDateString();
        if($user->isDirty()){
            $user->save();
        }
        return response("", 200);
    }

    public function updateEmail(Request $request)
    {
        $email = $request->validate([
            "email" => ["required", "email", Rule::unique("users")->ignore($request->user()->id)],
        ]);
        $user = User::find($request->user()->id);
        if ($user->email != $email["email"]) {
            $user->email = $email["email"];
            $user->save();
        }
        return response("", 200);
    }
    public function updatePhone(Request $request)
    {
        $request->validate([
            "phoneNumber" => ["required", "size:10", Rule::unique("users", "phone_number")->ignore($request->user()->id)],
        ]);
        $user = auth()->user();
        $user->phone_number=$request->phoneNumber;
        if($user->isDirty()) $user->save();
        return response("", 200);
    }

    public function updatePassword(Request $request)
    {
        $password = $request->validate([
            "oldPassword" => ["required","current_password"],
            "newPassword" => ["required", "confirmed"]
        ]);
        $user = auth()->user();
        $user->password = $password["newPassword"];
        if($user->isDirty()) $user->save();
        return response("", 200);
    }


}
