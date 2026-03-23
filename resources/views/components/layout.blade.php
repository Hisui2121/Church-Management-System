<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{isset($title) ? $title . ' - Fira' : 'Fira' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">

    <link rel="stylesheet" href="/css/register.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-start">
            <a href="/" class="brand"> 👔 Fira</a>
        </div>
        <div class="nav-actions">
            <span class="text-sm"></span>

        <a href="/login" class="btn">Sign In</a>
        <a href="/register/account" class="btn">Sign Up</a>
        </div>
    </nav>
    
    <main class="container">
        {{$slot}}
    </main>

    <footer class="footer">
        <p>© 2026 Fira - Your Fashion Inventory Resource Assistant</p>
    </footer>
</body>
</html>