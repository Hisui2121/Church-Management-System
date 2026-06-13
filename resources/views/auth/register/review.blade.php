<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Review - Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 relative">

    <main class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] flex flex-col w-full max-w-[950px] p-12 min-h-[550px]">
        
        <div class="mb-8 w-full">
            <p class="text-[10px] font-bold text-[#468770] uppercase tracking-wider mb-2">Step 3 of 3</p>
            <div class="flex gap-2">
                <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
            </div>
        </div>

        <h2 class="text-[28px] font-semibold text-gray-900 mb-1">Final Review</h2>
        <p class="text-gray-500 text-[13px] mb-10">
            Take a moment to ensure your details are correct
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 text-sm flex-grow">
            
            <div class="space-y-3">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 text-[15px]">Account Creation</h3>
                <div class="grid grid-cols-2 gap-2 text-[13px]">
                    <div>
                        <p class="text-gray-400 font-medium">Full Name</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['name'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Email Address</p>
                        <p class="text-gray-700 font-semibold mt-0.5 break-all">{{ $data['email'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 text-[15px]">Personal Information</h3>
                <div class="grid grid-cols-3 gap-4 text-[13px]">
                    <div class="col-span-3">
                        <p class="text-gray-400 font-medium">Home Address</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['city'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Birthdate</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['birthday'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Gender</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['sex'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Phone Number</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['phone'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
<!-- 
            <div class="space-y-3 md:col-span-2 pt-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 text-[15px]">Church Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-[13px]">
                    <div>
                        <p class="text-gray-400 font-medium">Member Type</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['member_type'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Baptism Status</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['baptism_status'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Date of Baptism</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['baptism_date'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-medium">Ministry Interest</p>
                        <p class="text-gray-700 font-semibold mt-0.5">{{ $data['ministry_interest'] ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div> -->

        <form action="/register/submit" method="POST" class="mt-12 pt-6 border-t border-gray-100 flex gap-4">
            @csrf
            <a href="{{ route('register.personal') }}" class="bg-[#e9eceb] hover:bg-gray-200 text-[#4a5551] text-[13px] font-semibold py-3 px-8 rounded-lg transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
            <button type="submit" class="flex-1 bg-[#468770] hover:bg-[#386F5C] text-white text-[13px] font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center shadow-sm">
                Create Account
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>
    </main>

    @if(session('success'))
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-3xl p-10 max-w-[400px] w-full text-center shadow-2xl transform scale-100 transition-all duration-300">
            <div class="w-16 h-16 bg-[#eaf7f2] text-[#468770] rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-2 leading-tight">Account Created Successfully!</h3>
            <p class="text-gray-500 text-[13px] leading-relaxed mb-8 px-2">
                Welcome to the Heroes Church community. Your journey of faith and fellowship begins today.
            </p>
            
            <a href="{{ route('login') }}" class="w-full bg-[#468770] hover:bg-[#386F5C] text-white font-medium py-3 px-4 rounded-xl transition-colors flex items-center justify-center shadow-md text-sm gap-2">
                Log In Now
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l4-4m0 0l-4-4m4 4H3m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h3a3 3 0 013 3v1"></path>
                </svg>
            </a>
        </div>
    </div>
    @endif

</body>
</html>