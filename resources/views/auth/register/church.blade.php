<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Information - Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <main class="bg-white rounded-[2rem] shadow-[0_10px_40px_rgba(0,0,0,0.08)] flex flex-col md:flex-row w-full max-w-[950px] overflow-hidden min-h-[550px]">
        
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
                <p class="text-[10px] font-bold text-[#468770] uppercase tracking-wider mb-2">Step 3 of 4</p>
                <div class="flex gap-2">
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                </div>
            </div>

            <h2 class="text-[28px] font-semibold text-gray-900 mb-1">Church Information</h2>
            <p class="text-gray-500 text-[13px] mb-8 max-w-[380px]">
                Please provide your Church Information to begin your registration
            </p>

            <form action="{{ route('register.church') }}" method="POST" class="flex-grow flex flex-col">
                @csrf <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1.5">Member Type</label>
                        <select name="member_type" class="w-full bg-[#f3f4f6] text-[13px] text-gray-500 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none appearance-none cursor-pointer" required>
                            <option value="" disabled selected>Select member type</option>
                            <option value="Regular Member">Regular Member</option>
                            <option value="Attendee">Attendee</option>
                            <option value="Visitor">Visitor</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-800 mb-1.5">Ministry Interest</label>
                        <select name="ministry_interest" class="w-full bg-[#f3f4f6] text-[13px] text-gray-500 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none appearance-none cursor-pointer" required>
                            <option value="" disabled selected>Which ministries are you interested in? (Select that apply)</option>
                            <option value="Music / Worship">Music / Worship</option>
                            <option value="Media / Production">Media / Production (Obra't Kulay Style!)</option>
                            <option value="Kids Ministry">Kids Ministry</option>
                            <option value="Ushering / Concierge">Ushering / Concierge</option>
                        </select>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">Baptism Status</label>
                            <select name="baptism_status" class="w-full bg-[#f3f4f6] text-[13px] text-gray-500 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none appearance-none cursor-pointer" required>
                                <option value="" disabled selected>Select status</option>
                                <option value="Baptized">Baptized</option>
                                <option value="Not Baptized">Not Baptized</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">Date of Baptism</label>
                            <input type="date" name="baptism_date" class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770] border-none">
                        </div>
                    </div>
                </div>

                <div class="mt-auto pt-8 flex gap-4">
                    <a href="{{ route('register.personal') }}" class="flex-none bg-[#e9eceb] hover:bg-gray-200 text-[#4a5551] text-[13px] font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                    <button type="submit" class="flex-1 bg-[#468770] hover:bg-[#386F5C] text-white text-[13px] font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center shadow-sm">
                        Review Now
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>