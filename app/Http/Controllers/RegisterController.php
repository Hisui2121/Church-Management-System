<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
use Carbon\Carbon;

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
            'register' => [
                'name'     => $fullName,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]
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
        if (!session()->has('register')) {
            return redirect()->route('register.account');
        }
        return view('auth.register.personal');
    }

    public function savePersonal(Request $request)
    {
        $request->validate([
            'city'      => ['required'],
            'barangay'  => ['required'],
            'street'    => ['nullable'],
            'houseNo'   => ['nullable'],
            'birthday'  => ['required', 'date'],
            'sex'       => ['required'],
            'phone'     => ['nullable'],
        ]);

        $registerData = session('register', []);

        $registerData['city']       = $request->city;
        $registerData['barangay']   = $request->barangay;
        $registerData['street']     = $request->street;
        $registerData['houseNo']    = $request->houseNo;
        $registerData['birthday']   = $request->birthday;
        $registerData['sex']        = $request->sex;
        $registerData['phone']      = $request->phone;

        session(['register' => $registerData]);

        return redirect()->route('register.review');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 3 - CHURCH FORMS
    |--------------------------------------------------------------------------
    */

    public function churchForm()
    {
        if (!session('register.name')) {
            return redirect('/register/account');
        }
        return view('auth.register.church');
    }

    public function saveChurch(Request $request)
    {
        $request->validate([
            'member_type'       => ['required'],
            'baptism_status'    => ['required'],
            'baptism_date'      => ['nullable', 'date'],
            'ministry_interest' => ['required'],
        ]);

        $registerData = session('register', []);
        $registerData['member_type']        = $request->member_type;
        $registerData['baptism_status']     = $request->baptism_status;
        $registerData['baptism_date']       = $request->baptism_date;
        $registerData['ministry_interest']  = $request->ministry_interest;

        session(['register' => $registerData]);

        return redirect()->route('register.review');
    }

    /*
    |--------------------------------------------------------------------------
    | STEP 4 - REVIEW
    |--------------------------------------------------------------------------
    */

    public function review()
    {
        $data = session('register');

        if (!$data) {
            return redirect()->route('register.account');
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

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
        
            'city'      => $data['city'],
            'barangay'  => $data['barangay'],
            'street'    => $data['street'],
            'houseNo'   => $data['houseNo'] ?? null,
            'birthday'  => $data['birthday'] ?? null,
            'sex'       => $data['sex'] ?? null,
            'phone'     => $data['phone'] ?? null,
        ]);

        $user->assignRole('Guest');

            AuditLog::record(
                action:         'Created',
                tableName:      'users',
                recordId:       $user->id,
                description:    "New user registered: {$user->name}",
                page:           'Auth'
            );

        // Burahin ang registration session cache dahil save na sa DB
        session()->forget('register');

        return redirect('/login')
            ->with('success', 'Account created successfully!');
    }
}