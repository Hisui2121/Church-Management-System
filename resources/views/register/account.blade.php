<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x:layout>
        <x-slot:title>Account Details</x-slot:title>
</head>
<body>

    <div class="hero">
        <div class="hero-content">
            <div class="card">
                <div class="card-body">
                    <h1 class="header1">Create Account</h1>
                                        
                        @if(session('success'))
                            <p style="color: green;"> {{session('success')}} </p>
                        @endif
                        @if($errors->any())
                            <ul style="color: red;">
                                @foreach($errors->all() as $error)
                                    <li> {{$error}} </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <form action="/register/account" method="POST">
                            @csrf
                            <label>Name: </label> <br>
                            <input type="text" name="name" value="{{ old('name') }}"><br><br>

                            <label>Email: </label>
                            <input type="email" name="email" value="{{old('email')}}"><br><br>

                            <label>Password: </label>
                            <input type="password" name="password"><br><br>

                            <label>Confirm Password: </label>
                            <input type="password" name="password_confirmation"><br><br>

                            <button type="submit">Next</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <p>Already have an account? <a href="/login">Login Here</a></p>
</body>
</x:layout>
</html>