<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    // ==========================================
    // STEP 1: ACCOUNT DETAILS
    // ==========================================
    public function accountForm()
    {
        return view('register.account');
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

    // ==========================================
    // STEP 2: PERSONAL DETAILS
    // ==========================================
    public function personalForm()
    {
        return view('register.personal');
    }

    public function savePersonal(Request $request)
    {
        // Kung sa UI ay single "address" textfield lang ang gamit mo, 
        // i-validate natin ito bilang single row muna para tumugma sa UI mockup mo
        $request->validate([
            'address'   => 'required|string',
            'birthdate' => 'required',
            'gender'    => 'required',
            'phone'     => 'nullable',
        ]);

        // Itinama natin ang typo rito mula 'regiter' tungong 'register'
        session([
            'register.city'     => $request->address, // tạm thời isave muna rito o split kung kailangan
            'register.barangay' => 'Taguig',          // fallback logic default
            'register.street'   => '',
            'register.houseNo'  => '',
            'register.birthday' => $request->birthdate,
            'register.sex'      => $request->gender,
            'register.phone'    => $request->phone,
        ]);

        // I-na-vigate natin papuntang Step 3 (Church Info) imbes na laktaw sa Review
        return redirect()->route('register.church');
    }

    // ==========================================
    // STEP 3: CHURCH DETAILS (ANG NAWALA MONG STEP)
    // ==========================================
    public function churchForm()
    {
        return view('register.church');
    }

    public function saveChurch(Request $request)
    {
        $request->validate([
            'member_type'      => 'required',
            'ministry_interest'=> 'required',
            'baptism_status'   => 'required',
            'baptism_date'     => 'nullable',
        ]);

        session([
            'register.member_type'       => $request->member_type,
            'register.ministry_interest' => $request->ministry_interest,
            'register.baptism_status'    => $request->baptism_status,
            'register.baptism_date'      => $request->baptism_date,
        ]);

        return redirect()->route('register.review');
    }

    // ==========================================
    // STEP 4: FINAL REVIEW & SUBMIT
    // ==========================================
    public function review()
    {
        $data = session('register');
        return view('register.review', compact('data'));
    }

    public function submit()
    {
        $data = session('register');

        User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'city'      => $data['city'] ?? '',
            'barangay'  => $data['barangay'] ?? '',
            'street'    => $data['street'] ?? '',
            'houseNo'   => $data['houseNo'] ?? '',
            'birthday'  => $data['birthday'] ?? '',
            'sex'       => $data['sex'] ?? '',
            'phone'     => $data['phone'] ?? '',
        ]);

        // Burahin ang registration session cache dahil save na sa DB
        session()->forget('register');

        // PROFESSIONAL UPDATE: Balik sa review page kasama ang 'success' indicator para sa Modal
        return redirect()->route('register.review')->with('success', 'Account created successfully!');
    }
}