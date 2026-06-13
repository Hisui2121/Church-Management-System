@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-12">
        <h2 class="text-2xl font-bold mb-4">Reset Password</h2>

        @if(session('status'))
            <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded" />
            </div>
            <div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Send Reset Link</button>
            </div>
        </form>
    </div>
@endsection
