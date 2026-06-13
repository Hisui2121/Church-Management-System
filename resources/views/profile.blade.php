<x-admin-layout>
    <x-slot:title>User Profile</x-slot:title>

    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">View your account information</p>
    </div>

    @php
        $user = auth()->user();
        $member = $user->member;
    @endphp

    <div class="grid grid-cols-3 gap-6">
        {{-- LEFT: PROFILE CARD --}}
        <div class="col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto bg-gray-200 rounded-full flex items-center justify-center text-4xl text-gray-400 mb-4">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                    @if($user->getRoleNames()->count() > 0)
                        <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    @endif
                </div>
                <div class="border-t pt-4">
                    <p class="text-gray-600"><strong>Email:</strong></p>
                    <p class="text-gray-800 mb-3">{{ $user->email }}</p>
                    <p class="text-gray-600"><strong>Account Status:</strong></p>
                    <p class="text-green-600 font-medium">Active</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: DETAILS --}}
        <div class="col-span-2">
            {{-- USER DETAILS --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Account Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 text-sm">Full Name</p>
                        <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Email Address</p>
                        <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Role</p>
                        <p class="text-gray-800 font-medium">
                            {{ $user->getRoleNames()->count() > 0 ? $user->getRoleNames()->first() : 'Guest' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Member Since</p>
                        <p class="text-gray-800 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- MEMBER DETAILS (if available) --}}
            @if($member)
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Member Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Full Name</p>
                            <p class="text-gray-800 font-medium">{{ $member->full_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Member Type</p>
                            <p class="text-gray-800 font-medium">{{ $member->memberType?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Member Status</p>
                            <p class="text-gray-800 font-medium">{{ $member->memberStatus?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Contact Number</p>
                            <p class="text-gray-800 font-medium">{{ $member->contact_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Date of Birth</p>
                            <p class="text-gray-800 font-medium">{{ $member->date_of_birth ? $member->date_of_birth->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Address</p>
                            <p class="text-gray-800 font-medium">{{ Str::limit($member->address ?? 'N/A', 30) }}</p>
                        </div>
                    </div>
                    @if($member->ministries->count() > 0)
                        <div class="mt-4 pt-4 border-t">
                            <p class="text-gray-600 text-sm mb-2">Ministries</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($member->ministries as $ministry)
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded text-sm">{{ $ministry->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- PERMISSIONS --}}
            @if($user->getAllPermissions()->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Permissions</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->getAllPermissions() as $permission)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                {{ str_replace('_', ' ', $permission->name) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>