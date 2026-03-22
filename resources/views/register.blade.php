<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Create Account</h2>

    @if(session('sucess'))
        <p style="color: green;"> {{session('sucess')}} </p>
    @endif
    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li> {{$error}} </li>
            @endforeach
        </ul>
    @endif

    <form action="/register" method="POST">
        @csrf
        <label>Name: </label> <br>
        <input type="text" name="name" value=" {{old('name') }} "><br><br>

        <label>Email: </label>
        <input type="text" name="email" value="{{old('email')}}"><br><br>

        <label>Password: </label>
        <input type="password" name="password"><br><br>

        <label>Confirm Password: </label>
        <input type="password" name="password_confirmation"><br><br>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="/login">Login Here</a></p>
</body>
</html>