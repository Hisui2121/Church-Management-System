<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Attendance Management</h2>
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Record Attendance
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-[#e8f5f0]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Member Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Service/Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($attendances as $record)
                <tr>
                    <td class="px-6 py-4">{{ $record->date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">{{ $record->member?->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $record->service->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $record->is_present ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $record->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="px-6 py-4 text-center text-gray-500" colspan="4">No attendance records yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $attendances->links() }}
    </div>
</x-admin-layout>
