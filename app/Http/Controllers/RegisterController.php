<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    //Step 1 Account Details
    public function accountForm(){
        return view('register.account');
    }

    public function saveAccount(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        session([
            'register.name' => $request->name,
            'register.email' => $request->email,
            'register.password' => bcrypt($request->password),
        ]);

        return redirect('/register/personal');
    }
    //Step 2 Personal Details
    public function personalForm(){
        return view('register.personal');
    }

    public function savePersonal(Request $request){
        $request->validate([
            'city' => 'required',
            'barangay' => 'required',
            'street' => 'nullable',
            'houseNo' => 'nullable',
            'birthday' => 'required',
            'sex'=> 'required',
            'phone' => 'nullable',
        ]);
        session([
            'register.city' => $request->city,
            'register.barangay' => $request->barangay,
            'register.street'=> $request->street,
            'regiter.houseNo'=>$request->houseNo,
            'register.birthday'=>$request->birthday,
            'register.sex'=>$request->sex,
            'register.phone' => $request->phone,
        ]);

        return redirect('/register/review');
    }

    public function review(){
        $data = session('register');
        return view('register.review', compact('data'));
    }

    public function submit(){
        $data = session('register');

        User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password'=>$data['password'],
            'city'=>$data['city'],
            'barangay'=>$data['barangay'],
            'street'=>$data['street'],
            'houseNo'=>$data['houseNo'] ?? '',
            'birthday'=>$data['birthday'] ?? '',
            'sex'=>$data['sex'] ?? '',
            'phone'=>$data['phone'] ?? '',
        ]);

        session()->forget('register');

        return redirect('/login')->with('success', 'Account created successfully!');
    }
}
