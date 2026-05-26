<x-layout>

<x-slot:title>
    Register - Account
</x-slot:title>

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

<div class="auth-page">

    <div class="auth-left">

        <div class="left-content">
            <h1>Heroes Church</h1>

            <p>
                Begin your journey with our church management platform.
            </p>

            <div class="auth-icons">
                ⛪ ✨ 🙏
            </div>
        </div>

    </div>

    <div class="auth-right">

        <div class="auth-card">

            <div class="step-indicator">
                <div class="step active"></div>
                <div class="step"></div>
                <div class="step"></div>
            </div>

            <h2>Create Account</h2>

            <p class="subtitle">
                Step 1 of 3
            </p>

            @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register/account" method="POST">

                @csrf

                <div class="form-group">
                    <label>Name</label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="form-group">
                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                    >
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>

                    <input
                        type="password"
                        name="password_confirmation"
                    >
                </div>

                <button class="auth-btn" type="submit">
                    Continue
                </button>

            </form>

            <div class="auth-footer">
                Already have an account?
                <a href="/login">Login Here</a>
            </div>

        </div>

    </div>

</div>

</x-layout>