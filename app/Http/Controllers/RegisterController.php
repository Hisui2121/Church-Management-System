<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STEP 1 - ACCOUNT
    |--------------------------------------------------------------------------
    */

    public function accountForm()
    {
        return view('auth.register.account');
    }

    public function saveAccount(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $registerData = session('register', []);

        $registerData['name'] = $request->name;
        $registerData['email'] = $request->email;
        $registerData['password'] = bcrypt($request->password);

        session(['register' => $registerData]);

        return redirect('/register/personal');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 2 - PERSONAL
    |--------------------------------------------------------------------------
    */

    public function personalForm()
    {
        if (!session('register.name')) {
            return redirect('/register/account');
        }
        return view('auth.register.personal');
    }

    public function savePersonal(Request $request)
    {
        $request->validate([
            'city' => ['required'],
            'barangay' => ['required'],
            'street' => ['nullable'],
            'houseNo' => ['nullable'],
            'birthday' => ['required', 'date'],
            'sex' => ['required'],
            'phone' => ['nullable'],
        ]);

        $registerData = session('register', []);

        $registerData['city'] = $request->city;
        $registerData['barangay'] = $request->barangay;
        $registerData['street'] = $request->street;
        $registerData['houseNo'] = $request->houseNo;
        $registerData['birthday'] = $request->birthday;
        $registerData['sex'] = $request->sex;
        $registerData['phone'] = $request->phone;

        session(['register' => $registerData]);

        return redirect('/register/review');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 - REVIEW
    |--------------------------------------------------------------------------
    */

    public function review()
    {
        $data = session('register');

        if (!$data) {
            return redirect('/register/account');
        }

        if (!session('register.name')) {
            return redirect('/register/account');
        }

        return view('auth.register.review', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | FINAL SUBMIT
    |--------------------------------------------------------------------------
    */

    public function submit()
    {
        $data = session('register');

        if (!$data) {
            return redirect('/register/account');
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'city' => $data['city'],
            'barangay' => $data['barangay'],
            'street' => $data['street'],
            'houseNo' => $data['houseNo'] ?? '',
            'birthday' => $data['birthday'] ?? '',
            'sex' => $data['sex'] ?? '',
            'phone' => $data['phone'] ?? '',
        ]);

        session()->forget('register');

        return redirect('/login')
            ->with('success', 'Account created successfully!');
    }
}