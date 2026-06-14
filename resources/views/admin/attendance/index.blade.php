<x-admin-layout>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Attendance Management
        </h2>
    </div>

    {{-- START SERVICE SESSION CARD --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="bi bi-play-circle"></i> Start a New Service Session
        </h3>

        @if($activeSession)
    
            <div class="bg-green-50 border border-green-200 rounded p-4">
                <p class="text-green-800 font-semibold">✓ Active Session: <strong>{{ $activeSession->service_title ?? 'Service' }}</strong></p>
                <p class="text-green-700 text-sm">Started: {{ $activeSession->started_at?->format('M d, Y h:i A') ?? 'N/A' }}</p>
                <p class="text-green-600 text-sm">Present Today: {{ $todayAttendanceCount }}</p>               
                <form action="{{ route('admin.session.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">End Service Session</button>
                </form>
            </div>
            @else
            <div class="bg-white rounded-lg border p-4">
                <p class="text-sm text-gray-600">No Active Service Session</p>
                <div class="mt-3">
                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700" onclick="openServiceSessionModal()">
                        <i class="bi bi-plus-circle"></i> Start Service Session
                    </button>
                </div>
            </div>
        @endif
    
    <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Member Check-In
                </h3>

                <input
                    type="text"
                    id="memberSearch"
                    placeholder="Search member..."
                    class="w-full border rounded-lg px-4 py-3"
                >

                <div
                    id="searchResults"
                    class="mt-4 space-y-2"
                ></div>
            </div>
        
    </div>  

        <!-- Attendance Records Card -->

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

    <!-- Header -->
    <div class="px-6 py-5 border-b border-gray-100">

        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">

            <div>
                <h3 class="text-lg font-semibold text-gray-800">
                    Attendance Records
                </h3>

                <p class="text-sm text-gray-500">
                    View and manage attendance records
                </p>
            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('admin.attendance.reports.export-excel', ['month' => $month, 'year' => $year]) }}"
                    class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50"
                >
                    <i class="bi bi-file-earmark-excel"></i>
                    Excel
                </a>

                <a
                    href="{{ route('admin.attendance.reports.export-pdf', ['month' => $month, 'year' => $year]) }}"
                    class="px-4 py-2 border border-gray-200 rounded-lg text-sm hover:bg-gray-50"
                >
                    <i class="bi bi-file-earmark-pdf"></i>
                    PDF
                </a>

            </div>

        </div>

    </div>

    <!-- Filters -->
    <div class="px-6 py-4 border-b border-gray-100">

        <div class="flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">

            <form
                method="GET"
                action="{{ route('admin.attendance.index') }}"
                class="flex flex-wrap gap-2"
            >

                <select
                    name="month"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm"
                >
                    @foreach($months as $m)
                        <option value="{{ $m['value'] }}"
                            {{ $month == $m['value'] ? 'selected' : '' }}>
                            {{ $m['label'] }}
                        </option>
                    @endforeach
                </select>

                <select
                    name="year"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm"
                >
                    @foreach($years as $y)
                        <option value="{{ $y }}"
                            {{ $year == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-100 rounded-lg text-sm hover:bg-gray-200"
                >
                    Apply Filter
                </button>

            </form>

            <div class="relative w-full lg:w-80">

                <input
                    type="text"
                    id="attendanceSearch"
                    placeholder="Search attendance..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >

            </div>

        </div>

    </div>

    <!-- Record Count -->
    <div class="px-6 py-3 bg-gray-50 border-b border-gray-100">

        <span class="text-sm text-gray-500">
            {{ $attendances->total() }} attendance records
        </span>

    </div>

    <!-- Table -->
    @if($attendances->count())

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Member
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Service
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Check In
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Date
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @foreach($attendances as $a)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $a->member?->full_name ?? 'Guest' }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $a->serviceSession?->service_title ?? 'Regular Service' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $a->checked_in_at?->format('h:i A') ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $a->date?->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4">

                                @if($a->is_present)

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        Present
                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        Absent
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $attendances->links() }}
        </div>

    @else

        <div class="p-12 text-center">

            <i class="bi bi-inbox text-4xl text-gray-300"></i>

            <p class="mt-3 text-gray-500">
                No attendance records found.
            </p>

        </div>

    @endif

</div>
        </div>

        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>

<script>

        const searchInput =
        document.getElementById('memberSearch');

        if(searchInput){

        searchInput.addEventListener(
        'keyup',
        function(){

            let keyword = this.value;

            if(keyword.length < 2){
                document
                .getElementById('searchResults')
                .innerHTML = '';
                return;
            }

            fetch(
                `{{ route('admin.attendance.search-members') }}?keyword=${encodeURIComponent(keyword)}`
                )
            .then(res => res.json())
            .then(data => {

                let html = '';

                data.forEach(member => {

                    html += `
                        <div class="flex justify-between items-center bg-gray-50 hover:bg-gray-100 border rounded-lg px-4 py-3 transition">
                            <div>
                                <div class="font-semibold text-gray-800">
                                    ${member.full_name}
                                </div>
                            </div>

                            <button
                                onclick="checkIn(${member.id})"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg"
                            >
                                Check In
                            </button>
                        </div>
                        `;

                });
                if(data.length === 0){
                    html = `
                        <div class="text-center text-gray-500 py-4">
                            No members found.
                        </div>
                    `;
                }

                document
                .getElementById('searchResults')
                .innerHTML = html;

            });

        });

        }

        function checkIn(memberId){

        fetch(
        '{{ route("admin.attendance.checkin") }}',
        {
            method:'POST',

            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':
                '{{ csrf_token() }}'
            },

            body:JSON.stringify({
                member_id:memberId
            })
        }
        )
        .then(res=>res.json())
        .then(data=>{

            if(data.success){

                alert(
                    'Member checked in successfully.'
                );

                location.reload();

            }else{

                alert(data.message);

            }

        });

        }

</script>

<script>

    document
    .getElementById('attendanceSearch')
    .addEventListener('keyup', function () {

        const value = this.value.toLowerCase();

        document
        .querySelectorAll('tbody tr')
        .forEach(row => {

            const text =
            row.innerText.toLowerCase();

            row.style.display =
            text.includes(value)
            ? ''
            : 'none';

        });

    });

    </script>

@include('admin.partials.service-session-modal')

</x-admin-layout>
