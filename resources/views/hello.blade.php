<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfdfc] min-h-screen flex flex-col text-gray-800">

    <nav class="px-8 py-6 max-w-[1400px] w-full mx-auto">
        <a href="{{ route('landing') }}" class="text-[15px] font-bold text-[#468770] tracking-wide">Heroes Church</a>
    </nav>

    <header class="flex-grow flex items-center justify-center px-8 py-12 max-w-[1200px] w-full mx-auto">
        <div class="flex flex-col-reverse md:flex-row items-center gap-16 w-full">
            
            <div class="md:w-1/2 flex flex-col justify-center">
                <div class="mb-6 inline-block">
                    <span class="bg-[#d1efe3] text-[#2A6B56] text-[11px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">
                        Welcome to Heroes Church!
                    </span>
                </div>
                
                <h1 class="text-6xl md:text-[80px] font-bold leading-[1.1] mb-6 text-gray-900 tracking-tight">
                    Together in <br> 
                    <span class="text-[#468770] italic">Faith.</span>
                </h1>
                
                <p class="text-gray-600 text-[17px] leading-relaxed max-w-[400px] mb-10 font-medium">
                    Heroes Church is all about building Christ-centered communities of imperfect people who love our city to life.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register.account') }}" class="bg-[#468770] hover:bg-[#386F5C] text-white text-[15px] font-medium px-8 py-3.5 rounded-xl transition-colors text-center shadow-sm">
                        Create Account
                    </a>
                    <a href="{{ route('login') }}" class="bg-white border border-[#468770] text-[#468770] hover:bg-[#f4f9f6] text-[15px] font-medium px-8 py-3.5 rounded-xl transition-colors text-center shadow-sm">
                        Member Login
                    </a>
                    <a href="#" class="bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 text-[15px] font-medium px-8 py-3.5 rounded-xl transition-colors text-center shadow-sm mt-1 w-fit">
                        Continue as Guest
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-end">
                <div class="w-full max-w-[500px] h-[600px] overflow-hidden rounded-tl-[2rem] rounded-tr-[3rem] rounded-bl-[4rem] rounded-br-xl shadow-2xl">
                    <img 
                        src="{{ asset('assets/landing/LandingPage_Hero1.png') }}" 
                        alt="Heroes Church Community" 
                        class="w-full h-full object-cover"
                    >
                </div>
            </div>
        </div>
    </header>

    <section class="px-8 py-16 max-w-[1300px] w-full mx-auto">
        <div class="relative bg-[#2A6B56] rounded-[2.5rem] overflow-hidden min-h-[450px] flex items-center shadow-lg">
            <div class="absolute inset-0 z-0">
                <img 
                    src="{{ asset('assets/landing/LandingPage_LightHouse1.png') }}" 
                    alt="Lighthouse" 
                    class="w-full h-full object-cover opacity-60 mix-blend-overlay"
                >
            </div>
            
            <div class="relative z-10 px-12 md:px-20 text-white max-w-3xl">
                <p class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-4 opacity-90">Heroes Lighthouse</p>
                <h2 class="text-4xl md:text-[52px] font-medium mb-6 tracking-tight">Gospel Community Groups</h2>
                <p class="text-white/80 text-lg leading-relaxed max-w-[600px] mb-10 font-light">
                    Our gospel community groups (Lighthouses) serve as a means of care, evangelism, discipleship, and sanctification.
                </p>
                <a href="#" class="inline-block border border-white/60 hover:bg-white/10 text-white text-[14px] px-6 py-3 rounded-xl transition-colors backdrop-blur-sm">
                    Explore Heroes Lighthouse >
                </a>
            </div>
        </div>
    </section>

    <section class="bg-[#f6faf8] py-24 px-8 text-center mt-10">
        <h2 class="text-4xl md:text-5xl font-bold text-[#1f4d3d] mb-4 tracking-tight">Curious about our community?</h2>
        <p class="text-gray-600 text-lg mb-10 font-medium">You're not just a guest — you're part of the story God is writing here.</p>
        <a href="#" class="inline-block bg-[#468770] hover:bg-[#386F5C] text-white text-[15px] font-medium px-10 py-3.5 rounded-xl transition-colors shadow-md">
            Discover More
        </a>
    </section>

    <footer class="bg-[#fcfdfc] py-10 px-8 flex flex-col md:flex-row justify-between items-center max-w-[1400px] mx-auto w-full border-t border-gray-100">
        <div class="text-[15px] font-bold text-[#468770] tracking-wide mb-4 md:mb-0">
            Heroes Church
        </div>
        
        <div class="flex space-x-8 text-[13px] font-semibold text-gray-500 mb-4 md:mb-0">
            <a href="#" class="hover:text-gray-800 transition-colors">Privacy</a>
            <a href="#" class="hover:text-gray-800 transition-colors">Terms</a>
            <a href="#" class="hover:text-gray-800 transition-colors">Contact</a>
        </div>

        <div class="flex space-x-3">
            <a href="#" class="w-8 h-8 bg-[#e9f2ee] rounded-full flex items-center justify-center hover:bg-[#d1efe3] transition-colors">
                <svg class="w-4 h-4 text-[#468770]" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
            </a>
            <a href="#" class="w-8 h-8 bg-[#e9f2ee] rounded-full flex items-center justify-center hover:bg-[#d1efe3] transition-colors">
                <svg class="w-4 h-4 text-[#468770]" fill="currentColor" viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.42a2.78 2.78 0 00-1.94 2C1 8.18 1 12 1 12s0 3.82.46 5.58a2.78 2.78 0 001.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.42a2.78 2.78 0 001.94-2C23 15.82 23 12 23 12s0-3.82-.46-5.58zM9.5 15.5v-7l6.5 3.5-6.5 3.5z"></path></svg>
            </a>
        </div>
    </footer>

</body>
</html>