<x-admin-layout>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Record New Attendance</h2>
        
        <form action="{{ route('admin.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="service_session_id" value="{{ $activeSession->id }}">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Service Session</label>
                <div class="mt-1 rounded-md border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                    {{ $activeSession->service_title ?? 'Service' }} — {{ $activeSession->session_date?->format('F d, Y h:i A') ?? 'No date set' }}
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Select Member</label>
                <select name="member_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>
                @error('member_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-full">
                <i class="bi bi-check-circle"></i> Save Attendance
            </button>
        </form>
    </div>
</x-admin-layout>
