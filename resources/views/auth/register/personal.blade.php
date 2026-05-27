<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information - Heroes Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Custom styling for radio buttons to match mockup */
        input[type="radio"] {
            accent-color: #468770;
        }
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
                <p class="text-[10px] font-bold text-[#468770] uppercase tracking-wider mb-2">Step 2 of 4</p>
                <div class="flex gap-2">
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-[#468770] rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                    <div class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                </div>
            </div>

            <h2 class="text-[28px] font-semibold text-gray-900 mb-1">Personal Information</h2>
            <p class="text-gray-500 text-[13px] mb-8 max-w-[380px]">
                Please provide your Personal Information to begin your registration
            </p>

            <form
                action="{{ route('register.personal') }}"
                method="POST"
                class="flex-grow flex flex-col"
            >
                @csrf

                {{-- ERRORS --}}
                @if($errors->any())
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-5">

                    {{-- CITY + BARANGAY --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                value="{{ old('city') }}"
                                placeholder="Taguig"
                                class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">
                                Barangay
                            </label>

                            <input
                                type="text"
                                name="barangay"
                                value="{{ old('barangay') }}"
                                placeholder="Bicutan"
                                class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                                required
                            >
                        </div>

                    </div>

                    {{-- STREET + HOUSE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">
                                Street
                            </label>

                            <input
                                type="text"
                                name="street"
                                value="{{ old('street') }}"
                                placeholder="Main Street"
                                class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">
                                House Number
                            </label>

                            <input
                                type="text"
                                name="houseNo"
                                value="{{ old('houseNo') }}"
                                placeholder="123"
                                class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                            >
                        </div>

                    </div>

                    {{--  --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-1.5">
                                Birthday
                            </label>

                            <input
                                type="date"
                                name="birthday"
                                value="{{ old('birthday') }}"
                                class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 mb-2">
                                Sex
                            </label>

                            <div class="flex items-center gap-6 mt-3">

                                <label class="flex items-center text-[13px] text-gray-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="sex"
                                        value="Male"
                                        class="w-4 h-4 mr-2"
                                        {{ old('sex') == 'Male' ? 'checked' : '' }}
                                        required
                                    >

                                    Male

                                </label>

                                <label class="flex items-center text-[13px] text-gray-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="sex"
                                        value="Female"
                                        class="w-4 h-4 mr-2"
                                        {{ old('sex') == 'Female' ? 'checked' : '' }}
                                    >

                                    Female

                                </label>

                            </div>

                        </div>

                    </div>

                    {{-- PHONE --}}
                    <div>

                        <label class="block text-xs font-bold text-gray-800 mb-1.5">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="09123456789"
                            class="w-full bg-[#f3f4f6] text-[13px] text-gray-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-[#468770]"
                        >

                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="mt-auto pt-8 flex gap-4">

                    <a
                        href="{{ route('register.account') }}"
                        class="flex-none bg-[#e9eceb] hover:bg-gray-200 text-[#4a5551] text-[13px] font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18">
                            </path>
                        </svg>

                        Back

                    </a>

                    <button
                        type="submit"
                        class="flex-1 bg-[#468770] hover:bg-[#386F5C] text-white text-[13px] font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center shadow-sm"
                    >
                        Next Step

                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3">
                            </path>
                        </svg>

                    </button>

                </div>

            </form>

        </div>
    </main>

</body>
</html>