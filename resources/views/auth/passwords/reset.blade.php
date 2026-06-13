@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-12">
        <h2 class="text-2xl font-bold mb-4">Set New Password</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">New Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded" />
            </div>

            <div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Reset Password</button>
            </div>
        </form>
    </div>
@endsection
