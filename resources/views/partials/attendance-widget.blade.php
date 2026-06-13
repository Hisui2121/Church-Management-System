<div class="section-card border-l-4 border-[#67b69e] bg-gradient-to-br from-white to-[#f8fdfb] mb-6">
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-1 flex items-center gap-2">
                <i class="bi bi-clock-history text-[#67b69e]"></i> 
                Sunday Service Check-in
            </h3>
            
           @if($hasCheckedInToday ?? false)
                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg inline-block">
                    <p class="text-sm text-green-700 font-medium">
                        <i class="bi bi-check-circle-fill text-green-500 mr-1"></i> 
                        You are checked in for today's service!
                    </p>
                </div>
                <p class="text-xs text-gray-500 mt-2">Thank you for joining us today.</p>
            
            @elseif(($isSunday ?? false) && ($isServiceTime ?? false))
                <p class="text-sm text-gray-600 mb-4 mt-2">
                    Welcome! Please tap the button below to record your attendance.
                </p>
                <form action="{{ route('member.check_in') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 bg-[#67b69e] hover:bg-[#5a9d87] text-white px-6 py-3 rounded-lg font-semibold shadow-md transition-all transform hover:scale-105 active:scale-95">
                        <i class="bi bi-geo-alt-fill"></i> Check-in Now
                    </button>
                </form>
                
            @else
                <div class="mt-4 flex items-center gap-2 text-gray-500">
                    <i class="bi bi-info-circle"></i>
                    <p class="text-sm">
                        Self check-in is only available on Sundays between 7:00 AM and 1:00 PM.
                    </p>
                </div>
            @endif
        </div>
        
        <div class="hidden sm:block opacity-10">
            <i class="bi bi-calendar2-check text-6xl text-[#67b69e]"></i>
        </div>
    </div>
</div>