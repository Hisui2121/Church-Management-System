<x-layout>

    <x-slot:title>
        Login
    </x-slot:title>

    <div class="auth-page">

        {{-- LEFT SIDE --}}
        <div class="auth-left">

            <div class="overlay"></div>

            <div class="left-content">
                <h1>Heroes Church</h1>

                <p>
                    Welcome back to your church management system.
                </p>

                <div class="church-icons">
                    ⛪ ✨ 🙏 💒
                </div>
            </div>

        </div>

        {{-- RIGHT SIDE --}}
        <div class="auth-right">

            <div class="login-card">

                <h2>Welcome Back</h2>

                <p class="subtitle">
                    Login to continue
                </p>

                {{-- SUCCESS --}}
                @if(session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/login" method="POST">

                    @csrf

                    <div class="form-group">
                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="form-group">
                        <label>Password</label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                        >
                    </div>

                    <button type="submit" class="login-btn">
                        Login
                    </button>

                </form>

                <div class="register-link">
                    Don't have an account?
                    <a href="register/account">
                        Create Account
                    </a>
                </div>

            </div>

        </div>

    </div>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins', sans-serif;
            background:#f4f6f9;
        }

        .auth-page{
            min-height:100vh;
            display:grid;
            grid-template-columns:1fr 1fr;
        }

        /* LEFT */

        .auth-left{
            position:relative;

            background:
                linear-gradient(
                    rgba(0,0,0,0.45),
                    rgba(0,0,0,0.45)
                ),
                url('https://images.unsplash.com/photo-1515169067868-5387ec356754?q=80&w=1200');

            background-size:cover;
            background-position:center;

            display:flex;
            align-items:center;
            justify-content:center;

            overflow:hidden;
        }

        .left-content{
            position:relative;
            z-index:2;
            color:white;
            text-align:center;
            padding:40px;
        }

        .left-content h1{
            font-size:60px;
            margin-bottom:15px;
            font-weight:700;
        }

        .left-content p{
            font-size:18px;
            opacity:.9;
            max-width:450px;
            line-height:1.6;
            margin:auto;
        }

        .church-icons{
            margin-top:30px;
            font-size:30px;
            letter-spacing:10px;
        }

        /* RIGHT */

        .auth-right{
            display:flex;
            align-items:center;
            justify-content:center;
            padding:40px;
            background:#f7f8fa;
        }

        .login-card{
            width:100%;
            max-width:450px;
            background:white;
            padding:50px;
            border-radius:28px;
            box-shadow:0 10px 40px rgba(0,0,0,0.08);
        }

        .login-card h2{
            font-size:36px;
            margin-bottom:10px;
            color:#222;
        }

        .subtitle{
            color:#888;
            margin-bottom:35px;
        }

        /* FORM */

        .form-group{
            margin-bottom:22px;
        }

        .form-group label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#444;
        }

        .form-group input{
            width:100%;
            padding:16px;
            border:none;
            border-radius:16px;
            background:#f1f3f6;
            font-size:15px;
            transition:.3s;
        }

        .form-group input:focus{
            outline:none;
            background:white;
            border:2px solid #67b69e;
        }

        /* BUTTON */

        .login-btn{
            width:100%;
            padding:16px;
            border:none;
            border-radius:16px;
            background:#67b69e;
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:.3s;
            margin-top:10px;
        }

        .login-btn:hover{
            transform:translateY(-2px);
            background:#589f89;
        }

        /* ALERTS */

        .success-message{
            background:#dff6e8;
            color:#267a4d;
            padding:14px;
            border-radius:14px;
            margin-bottom:20px;
        }

        .error-message{
            background:#ffe4e4;
            color:#b42323;
            padding:14px;
            border-radius:14px;
            margin-bottom:20px;
        }

        .error-message ul{
            list-style:none;
        }

        /* LINK */

        .register-link{
            margin-top:25px;
            text-align:center;
            color:#666;
        }

        .register-link a{
            color:#67b69e;
            text-decoration:none;
            font-weight:600;
        }

        /* RESPONSIVE */

        @media(max-width:900px){

            .auth-page{
                grid-template-columns:1fr;
            }

            .auth-left{
                min-height:300px;
            }

            .left-content h1{
                font-size:42px;
            }

        }

    </style>

</x-layout>