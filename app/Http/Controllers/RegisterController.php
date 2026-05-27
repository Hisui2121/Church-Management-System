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
        // In-align natin sa UI input names (first_name, last_name)
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
        ]);

        // Pagsasamahin natin ang First at Last Name para maging "name" sa Users table
        $fullName = $request->first_name . ' ' . $request->last_name;

        session([
            'register.name'     => $fullName,
            'register.email'    => $request->email,
            'register.password' => bcrypt($request->password),
        ]);

        // Gagamit tayo ng Named Route para sa lipat-pahina (Best Practice)
        return redirect()->route('register.personal');
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

        return redirect()->route('register.review');
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

        // Burahin ang registration session cache dahil save na sa DB
        session()->forget('register');

        return redirect('/login')
            ->with('success', 'Account created successfully!');
    }
}