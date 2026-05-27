<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <main class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] flex flex-col md:flex-row w-full max-w-[950px] overflow-hidden min-h-[550px]">
         @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="md:w-[40%] relative bg-[#2A6B56] text-white px-10 pt-10 pb-10 flex flex-col justify-start">
            <div class="absolute inset-0 z-0">
                <img 
                    src="{{ asset('assets/auth/Registration_Pic1.png') }}" 
                    alt="Heroes Church Band" 
                    class="w-full h-full object-cover opacity-40 mix-blend-screen"
                >
            </div>
            <div class="relative z-10">
                <div class="flex items-center space-x-2 mb-8 text-sm">
                    <span class="border border-white/60 px-1.5 py-0.5 rounded text-xs font-light">he</span>
                    <span class="font-light tracking-wide text-white/90">Heroes Church</span>
                </div>
                <h1 class="text-3xl font-semibold mb-3">Together in Faith</h1>
                <p class="text-white/80 text-sm max-w-[250px] leading-relaxed">
                    Start your journey with a community that grows together.
                </p>
            </div>
        </div>

        <div class="md:w-[60%] py-10 px-12 flex flex-col">
            
            <div class="mb-8">
                <p class="text-[10px] font-bold text-[#468770] uppercase tracking-wider mb-2">Step 1 of 4</p>
                <div class="flex gap-2">
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                </div>
            </div>

            <h2 class="text-[28px] font-semibold text-gray-900 mb-1">Account Creation</h2>
            <p class="text-gray-500 text-[13px] mb-8 max-w-[350px]">
                Please provide your account information to begin your registration
            </p>

            <form action="{{ route('register.account') }}" method="POST" class="flex-grow flex flex-col">
                @csrf <div class="space-y-5">
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">First Name</label>
                            <input type="text" name="first_name" placeholder="Juan Pedro" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">Last Name</label>
                            <input type="text" name="last_name" placeholder="Juan Pedro" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1.5">Email Address</label>
                        <input type="email" name="email" placeholder="name@example.com" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-1 relative">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">Password</label>
                            <input type="password" name="password" placeholder="Min. 8 Characters" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg pl-4 pr-10 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                            <span class="absolute inset-y-0 right-0 top-6 flex items-center pr-3.5 text-gray-400 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </span>
                        </div>
                        <div class="flex-1 relative">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">Confirm Password</label>
                            <input type="password" name="password_confirmation" placeholder="Min. 8 Characters" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg pl-4 pr-10 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                            <span class="absolute inset-y-0 right-0 top-6 flex items-center pr-3.5 text-gray-400 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start pt-2">
                        <div class="flex items-center h-5">
                            <input type="checkbox" required class="w-4 h-4 rounded border-gray-300 text-[#468770] focus:ring-[#468770] bg-[#f3f4f6] border-none cursor-pointer">
                        </div>
                        <div class="ml-2 text-[11px] text-gray-500">
                            <label>I have read and agreed to the <a href="#" class="font-bold text-gray-700 hover:underline">terms and conditions</a></label>
                        </div>
                    </div>
                </div>

                <div class="mt-auto pt-8 flex gap-4">
                    <a href="{{ route('login') }}" class="flex-none bg-[#e9eceb] hover:bg-gray-200 text-[#4a5551] text-[13px] font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Login Instead
                    </a>
                    <button type="submit" class="flex-1 bg-[#468770] hover:bg-[#386F5C] text-white text-[13px] font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center shadow-sm">
                        Next Step
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>