<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x:layout>
    <x-slot:title>Personal Details</x-slot:title>
</head>
<body>  
    <h2>Personal Details</h2>

    @if(session('success'))
        <p style="color: green;">{{session('success')}}</p>
    @endif

    <form action="/register/personal" method="POST">
        @csrf
        <h3>Address</h3>
        <label>City</label>
        <input type="text" name="city" value="{{old('city')}}"><br><br>
        
        <label>Barangay</label>
        <input type="text" name="barangay" value="{{old('barangay')}}"><br><br>

        <label>Street</label>
        <input type="text" name="street" value="{{old('street')}}"><br><br>

        <label>House Number</label>
        <input type="text" name="houseNo" value="{{old('houseNo')}}"><br><br>

        <h3>Other Details</h3>
        <label>Birthday</label>
        <input type="date" name="birthday" value="{{old('birthday')}}"><br><br>

        <label>Sex</label>
        <select name="sex">
            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{old('sex') == 'female' ? 'selected' : '' }}>Female</option>
        </select> <br><br>

        <label>Phone Number</label>
        <input type="tel" name="phone" value="{{old('phone')}}"><br><br>

        <button type="submit">Next</button>

    </form>
    <p>Already have an account? <a href="/login">Login Here</a></p>

</body>
</x:layout>
</html>