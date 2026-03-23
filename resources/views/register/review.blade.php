<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
</head>
<body>
    <h2>Review Information</h2>

    <h3>Account Details</h3>
    <p>Name: {{$data['name']}}</p>
    <p>Email: {{$data['email']}} </p>
    <p>Password: {{$data['password']}}</p> <br>
    <h3>Personal Information</h3>
    <h4>Address</h4>
    <p>City: {{$data['city']}}</p>
    <p>Barangay: {{$data['barangay']}}</p>
    <p>Street: {{$data['street']}}</p>
    <p>House Number: {{$data['houseNo'] ?? ''}} </p><br>
    <h4>Other Details</h4>
    <p>Birthday: {{$data['birthday'] ?? ''}}</p>
    <p>Sex: {{$data['sex'] ?? ''}}</p>
    <p>Phone Number: {{$data['phone'] ?? ''}} </p>

    <form action="/register/submit" method="post">
        @csrf
        <button type="submit">Confirm Registration</button>
    </form>
</body>
</html>