
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
                <div class="step"></div>
                <div class="step active"></div>
                <div class="step"></div>
            </div>

            <h2>Create Account</h2>

            <p class="subtitle">
                Step 2 of 3
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

            <form action="/register/personal" method="POST">

                @csrf

                <div class="form-group">
                    <h3>Address</h3>
                    <label>City</label>
                    <input type="text" name="city" value="{{old('city')}}">
                   
                    <label>Barangay</label>
                    <input type="text" name="barangay" value="{{old('barangay')}}"> <br>

                    <label>Street</label>
                    <input type="text" name="street" value="{{old('street')}}">

                    <label>House Number</label>
                    <input type="text" name="houseNo" value="{{old('houseNo')}}">
                </div>

                <div class="form-group">
                    <label>Birthday</label>
                    <input type="date" name="birthday" value="{{old('birthday')}}"><br><br>

                </div>

                <div class="form-group">
                <label>Sex</label>
                    <select name="sex">
                        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{old('sex') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="form-group">

                    <label>Phone Number</label>
                    <input type="tel" name="phone" value="{{old('phone')}}">
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