<x-member-layout>
    <x-slot:title>Search Results</x-slot:title>

    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Search</h1>
            
            {{-- Search Form --}}
            <form action="{{ route('search.index') }}" method="GET" class="mb-6">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $query }}" 
                        placeholder="Search announcements, events, ministries, and members..." 
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>

            {{-- No Query Message --}}
            @if(empty($query))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                    <p class="text-gray-600">Enter a search term to find announcements, events, ministries, and members.</p>
                </div>
            {{-- No Results Message --}}
            @elseif($query && collect($results)->sum(fn($arr) => count($arr)) === 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <p class="text-gray-600">No results found for "<strong>{{ htmlspecialchars($query) }}</strong>"</p>
                </div>
            {{-- Results --}}
            @else
                <div class="grid gap-8">
                    {{-- Announcements --}}
                    @if($results['announcements']->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="bi bi-megaphone-fill text-blue-600"></i> Announcements
                            </h2>
                            <div class="space-y-3">
                                @foreach($results['announcements'] as $announcement)
                                    <a href="{{ route('announcements.index') }}#{{ $announcement->id }}" class="block bg-white p-4 border border-gray-200 rounded-lg hover:shadow-md transition">
                                        <h3 class="font-semibold text-gray-800">{{ $announcement->title }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($announcement->description, 100) }}</p>
                                        <p class="text-gray-500 text-xs mt-2">{{ $announcement->created_at->diffForHumans() }}</p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Events --}}
                    @if($results['events']->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="bi bi-calendar-event text-purple-600"></i> Events
                            </h2>
                            <div class="space-y-3">
                                @foreach($results['events'] as $event)
                                    <a href="{{ route('events.index') }}#{{ $event->id }}" class="block bg-white p-4 border border-gray-200 rounded-lg hover:shadow-md transition">
                                        <h3 class="font-semibold text-gray-800">{{ $event->title }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                                        <p class="text-gray-500 text-xs mt-2">
                                            <i class="bi bi-calendar"></i> {{ $event->event_date->format('M d, Y') }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Ministries --}}
                    @if($results['ministries']->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="bi bi-people-fill text-green-600"></i> Ministries
                            </h2>
                            <div class="space-y-3">
                                @foreach($results['ministries'] as $ministry)
                                    <a href="{{ route('ministries.index') }}#{{ $ministry->id }}" class="block bg-white p-4 border border-gray-200 rounded-lg hover:shadow-md transition">
                                        <h3 class="font-semibold text-gray-800">{{ $ministry->name }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($ministry->description, 100) }}</p>
                                        <p class="text-gray-500 text-xs mt-2">
                                            <i class="bi bi-person-fill"></i> {{ $ministry->members_count ?? 0 }} members
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Members --}}
                    @if($results['members']->count() > 0)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                <i class="bi bi-person-badge-fill text-orange-600"></i> Members
                            </h2>
                            <div class="space-y-3">
                                @foreach($results['members'] as $member)
                                    <a href="{{ route('members.show', $member->id) }}" class="block bg-white p-4 border border-gray-200 rounded-lg hover:shadow-md transition">
                                        <h3 class="font-semibold text-gray-800">{{ $member->full_name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $member->memberType?->name ?? 'Member' }}</p>
                                        <p class="text-gray-500 text-xs mt-2">
                                            <i class="bi bi-telephone-fill"></i> {{ $member->contact_number ?? 'N/A' }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-member-layout>
