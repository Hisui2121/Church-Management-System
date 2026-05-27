<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans">

    <nav class="p-6">
        <a href="/" class="text-xl font-bold text-[#2A6B56]">Heroes Church</a>
    </nav>

    <main class="flex-grow flex items-center justify-center p-4">
        
        <div class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] flex flex-col md:flex-row w-full max-w-[900px] overflow-hidden min-h-[500px]">
           
            <div class="md:w-[45%] relative bg-[#2A6B56] text-white px-10 pt-6 pb-10 flex flex-col justify-start">
                <div class="absolute inset-0 z-0">
                    <img 
                        src="{{ asset('assets/auth/Login_Pic1.png') }}" 
                        alt="Heroes Church Kids" 
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

            <div class="md:w-[55%] py-10 px-12 flex flex-col justify-center">
                <h2 class="text-[32px] font-semibold text-gray-900 mb-1">Welcome</h2>
                <p class="text-gray-500 text-sm mb-8">Enter your credentials to access the management system</p>

                <form action="/login" method="POST" class="space-y-5">
                    @csrf <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.53 4.3a2 2 0 001.94 0L20 8M3 8v8a2 2 0 002 2h14a2 2 0 002-2V8m-18 0a2 2 0 012-2h14a2 2 0 012 2"></path></svg>
                            </span>
                            <input type="email" name="email" placeholder="name@example.com" class="w-full bg-[#f3f4f6] text-sm text-gray-900 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input type="password" name="password" placeholder="••••••••••••" class="w-full bg-[#f3f4f6] text-sm text-gray-900 rounded-lg pl-10 pr-10 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none" required>
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 cursor-pointer hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <label class="flex items-center text-gray-500 cursor-pointer">
                            <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-[#468770] focus:ring-[#468770]">
                            Keep me logged in
                        </label>
                        <a href="#" class="text-red-500 hover:text-red-700">Forgot Password</a>
                    </div>

                    <button type="submit" class="w-full bg-[#468770] hover:bg-[#386F5C] text-white text-sm font-medium py-3 px-4 rounded-lg transition-colors mt-2">
                        Sign in
                    </button>
                </form>

                <p class="text-center text-[11px] text-gray-500 mt-10">
                    Don't have an account? <a href="{{ route('register.account') }}" class="text-[#468770] hover:underline font-semibold">Create one</a>
                </p>
            </div>
        </div>
    </main>

    <footer class="p-6 flex justify-center md:justify-between items-center max-w-7xl mx-auto w-full text-sm text-gray-500">
        <div class="hidden md:block w-32"></div>
        
        <div class="space-x-6 text-xs font-medium">
            <a href="#" class="hover:text-gray-800 transition-colors">Privacy</a>
            <a href="#" class="hover:text-gray-800 transition-colors">Terms</a>
            <a href="#" class="hover:text-gray-800 transition-colors">Contact</a>
        </div>

        <div class="hidden md:flex space-x-3 w-32 justify-end">
            <a href="#" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
            </a>
            <a href="#" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2C1 8.18 1 12 1 12s0 3.82.46 5.58a2.78 2.78 0 001.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.42a2.78 2.78 0 001.94-2C23 15.82 23 12 23 12s0-3.82-.46-5.58zM9.5 15.5v-7l6.5 3.5-6.5 3.5z"></path></svg>
            </a>
            <a href="#" class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                <svg class="w-3 h-3 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 1.802c-2.67 0-2.987.01-4.042.059-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.048 1.055-.058 1.37-.058 4.041 0 2.67.01 2.987.058 4.042.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058 2.67 0 2.987-.01 4.042-.058.975-.045 1.504-.207 1.857-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041 0-2.67-.01-2.987-.058-4.042-.045-.975-.207-1.504-.344-1.857a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.055-.048-1.37-.058-4.042-.058zm0 3.065a5.132 5.132 0 110 10.264 5.132 5.132 0 010-10.264zm0 8.462a3.33 3.33 0 100-6.66 3.33 3.33 0 000 6.66zm5.338-9.87a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"></path></svg>
            </a>
        </div>
    </footer>

</body>
</html>