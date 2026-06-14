<x-admin-layout>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="admin-dashboard-container">
        
        {{-- ANNOUNCEMENT CAROUSEL --}}
        <div class="mb-8 rounded-2xl overflow-hidden relative shadow-sm border border-gray-100" style="height: 250px;" id="promoCarousel">
            <div class="relative w-full h-full" id="carouselTracks">
                @forelse($carouselAnnouncements as $index => $banner)
                    @php $bannerImage = $banner->image_path ?? $banner->image; @endphp
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                        @if($bannerImage)
                            <img src="{{ Storage::url($bannerImage) }}" class="w-full h-full object-cover" alt="Banner">
                        @else
                            <div class="w-full h-full bg-[#e5e7eb]"></div>
                        @endif

                        @if(!$bannerImage)
                        <div class="absolute inset-0 bg-gradient-to-r from-[#205142]/80 to-transparent flex flex-col justify-center p-10">
                            <span class="bg-[#67b69e] text-white text-[10px] font-bold px-2 py-1 rounded w-max mb-3 uppercase tracking-wider">Announcement</span>
                            <h2 class="text-white text-3xl font-bold mb-2">{{ $banner->title }}</h2>
                            <p class="text-white text-sm opacity-90 max-w-xl line-clamp-2">{{ $banner->body }}</p>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="carousel-slide absolute inset-0 opacity-100 z-10">
                        <img src="{{ asset('images/lighthouse.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1438283173091-5dbf5c5a3206?q=80&w=1000&auto=format&fit=crop'" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#205142]/90 to-transparent flex flex-col justify-center p-10">
                            <h2 class="text-white text-3xl font-bold mb-3">Welcome to Dashboard</h2>
                            <p class="text-white text-sm opacity-90 max-w-xl mb-5">Upload images to your Announcements to see them loop here!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Permanent Carousel Controls --}}
            @if($carouselAnnouncements->count() > 1)
                <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white text-[#205142] w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-md shadow-md transition z-20">
                    <i class="bi bi-chevron-left font-extrabold"></i>
                </button>
                <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/50 hover:bg-white text-[#205142] w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-md shadow-md transition z-20">
                    <i class="bi bi-chevron-right font-extrabold"></i>
                </button>

                {{-- Carousel Dots --}}
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    @foreach($carouselAnnouncements as $index => $banner)
                        <button type="button" data-slide="{{ $index }}" class="carousel-dot w-2.5 h-2.5 rounded-full transition-all bg-white/50"></button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- STAT CARDS ROW --}}
        <div class="dashboard-stats">
            <div class="stat-card-heroes">
                <div class="stat-card-content">
                    <div class="stat-card-title">Total Members</div>
                    <div class="stat-card-value text-[#67b69e]">{{ $totalMembers }} <span class="text-gray-400 text-sm font-normal">heroes members</span></div>
                </div>
                <div class="stat-card-icon"><i class="bi bi-clipboard-check"></i></div>
            </div>
            <div class="stat-card-heroes">
                <div class="stat-card-content">
                    <div class="stat-card-title">Total Ministries</div>
                    <div class="stat-card-value text-[#67b69e]">{{ $totalMinistries }} <span class="text-gray-400 text-sm font-normal">heroes ministry</span></div>
                </div>
                <div class="stat-card-icon"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="stat-card-heroes">
                <div class="stat-card-content">
                    <div class="stat-card-title">Active Announcements</div>
                    <div class="stat-card-value text-[#67b69e]">{{ $activeAnnouncements }} <span class="text-gray-400 text-sm font-normal">heroes announcements</span></div>
                </div>
                <div class="stat-card-icon"><i class="bi bi-chat-square-text-fill"></i></div>
            </div>
        </div>

        {{-- SERVICE SESSION WIDGET --}}
        @php
            $activeSession = \App\Models\ServiceSession::where('is_active', true)->first();
        @endphp
        <div class="service-session-widget mt-6 mb-6">
            @if($activeSession)
                <div class="session-status active">
                    <div class="session-status-content">
                        <div class="session-status-icon active">
                            <i class="bi bi-clock-check"></i>
                        </div>
                        <div class="session-status-info">
                            <h4 class="session-status-title">Service Session Active</h4>
                            <p class="session-status-details">
                                <span><strong>{{ $activeSession->service_title ?? 'Service' }}</strong></span>
                                @if($activeSession->pastor)
                                    <span class="detail-separator">•</span>
                                    <span>{{ $activeSession->pastor->name }}</span>
                                @endif
                            </p>
                            <p class="session-start-time">
                                <i class="bi bi-calendar3"></i>
                                {{ $activeSession->session_date ? $activeSession->session_date->format('M d, Y \a\t h:i A') : 'No date set' }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('admin.session.toggle') }}" method="POST" style="margin-left: auto;">
                        @csrf
                        <button type="submit" class="btn-session-control end">
                            <i class="bi bi-stop-circle"></i>
                            End Service
                        </button>
                    </form>
                </div>
            @else
                <div class="session-status inactive">
                    <div class="session-status-content">
                        <div class="session-status-icon">
                            <i class="bi bi-play-circle"></i>
                        </div>
                        <div class="session-status-info">
                            <h4 class="session-status-title">No Active Service Session</h4>
                            <p class="session-status-details">Start a new service session to enable member check-ins</p>
                        </div>
                    </div>
                    <button type="button" class="btn-session-control start" onclick="openServiceSessionModal()">
                        <i class="bi bi-plus-circle"></i>
                        Start Service
                    </button>
                </div>
            @endif
        </div>

        <div class="dashboard-content-grid mt-6">
            <div class="dashboard-left-section">
                {{-- CHART --}}
                @include('admin.partials.attendance-chart')

                {{-- HEROES MEMBERS TABLE --}}
                <div class="card card-heroes">
                    <div class="card-header-heroes flex justify-between items-center">
                        <div>
                            <h3 class="card-title-heroes">Heroes' Members</h3>
                            <p class="card-subtitle-heroes">Quick view of registered members</p>
                        </div>
                        <a href="{{ route('admin.members.index') }}" class="link-view-all text-[#67b69e] text-xs font-semibold">View all</a>
                    </div>
                    <div class="table-wrapper-heroes">
                        <table class="table-heroes">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>ROLE</th>
                                    <th>MINISTRY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($heroesMembers as $member)
                                <tr>
                                    <td>{{ $member->full_name }}</td>
                                    <td>
                                        @php
                                            $roles = $member->ministries->pluck('pivot.role')->filter()->unique();
                                        @endphp
                                        @if($roles->count() > 0)
                                            <span class="role-badge">{{ $roles->first() }}</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $ministryNames = $member->ministries->pluck('name');
                                        @endphp
                                        @if($ministryNames->count() > 0)
                                            <span class="text-sm">{{ $ministryNames->join(', ') }}</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT SECTION - SIDEBAR --}}
            <div class="dashboard-right-section">
                <div class="card card-sidebar">
                    <div class="sidebar-header">
                        <div>
                            <h3>Announcements</h3>
                            <p class="sidebar-subtitle">Browse all active announcements</p>
                        </div>
                        <a href="{{ route('admin.announcements.index') }}" class="link-view-all text-[#67b69e] text-xs font-semibold hover:underline">View all</a>
                    </div>
                    <div class="sidebar-content">
                        @forelse ($announcements as $announcement)
                        <div class="announcement-item border border-gray-100 p-4 bg-gray-50 hover:bg-gray-100 transition rounded-lg mb-3">
                            <div class="flex justify-between items-start mb-1">
                                <div class="announcement-title text-sm font-bold text-gray-800">{{ $announcement->title }}</div>
                            </div>
                            <div class="text-xs text-gray-500 mb-2">{{ Str::limit($announcement->body ?? 'No details provided.', 60) }}</div>
                            <div class="text-[10px] text-gray-400 font-medium flex items-center gap-1">
                                <i class="bi bi-clock"></i> {{ $announcement->created_at?->diffForHumans() ?? 'Recently' }}
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4">No announcements</p>
                        @endforelse
                    </div>
                </div>

                <div class="card card-sidebar">
                    <div class="sidebar-header">
                        <div>
                            <h3>Activity Log</h3>
                        </div>
                        <a href="{{ route('audit_logs.index') }}" class="link-view-all text-[#67b69e] text-xs font-semibold hover:underline">View all</a>
                    </div>
                    <div class="sidebar-content">
                        @forelse ($activityLog as $log)
                        <div class="activity-item border border-gray-100 p-4 bg-gray-50 hover:bg-gray-100 transition rounded-lg mb-3">
                            <div class="flex justify-between items-start mb-1">
                                <div class="activity-action text-sm font-bold text-gray-800 capitalize">{{ $log->action }}</div>
                            </div>
                            <div class="text-xs text-gray-500 mb-2">{{ Str::limit($log->description ?? 'System action recorded.', 60) }}</div>
                            <div class="text-[10px] text-gray-400 font-medium flex items-center gap-1">
                                <i class="bi bi-clock"></i> {{ $log->created_at?->diffForHumans() ?? 'Recently' }}
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-4">No logs</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CAROUSEL LOGIC WITH DOTS
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.carousel-dot');

        function showSlide(index) {
            if (slides.length === 0) return;

            slides.forEach(slide => { slide.classList.remove('opacity-100', 'z-10'); slide.classList.add('opacity-0', 'z-0'); });
            dots.forEach(dot => { dot.classList.remove('bg-white', 'w-6'); dot.classList.add('bg-white/50', 'w-2.5'); });

            slides[index].classList.remove('opacity-0', 'z-0');
            slides[index].classList.add('opacity-100', 'z-10');
            if (dots[index]) {
                dots[index].classList.remove('bg-white/50', 'w-2.5');
                dots[index].classList.add('bg-white', 'w-6');
            }
            currentSlide = index;
        }

        function nextSlide() { showSlide((currentSlide + 1) % slides.length); }
        function prevSlide() { showSlide((currentSlide - 1 + slides.length) % slides.length); }

        // Dots navigation
        document.querySelectorAll('.carousel-dot').forEach(dot => {
            dot.addEventListener('click', function () {
                const target = parseInt(this.dataset.slide, 10);
                if (!isNaN(target)) showSlide(target);
            });
        });

        // Auto play every 5 seconds
        if (slides.length > 1) { setInterval(nextSlide, 5000); }

        // Initialize first slide state
        if (slides.length > 0) { showSlide(0); }
    </script>
    <style>
        .dashboard-stats { display: flex; gap: 16px; align-items: stretch; width: 100%; }
        .stat-card-heroes { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02); flex: 1 1 0; min-width: 0; }
        .stat-card-title { font-size: 14px; font-weight: 700; color: #333; margin-bottom: 4px; }
        .stat-card-value { font-size: 18px; font-weight: 700; }
        .stat-card-icon { width: 40px; height: 40px; background: #e8f4f0; color: #67b69e; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .dashboard-content-grid { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: stretch; height: 100%; }
        .dashboard-left-section { display: grid; grid-template-rows: 1fr 1fr; gap: 24px; }
        .dashboard-right-section { display: grid; grid-template-rows: 1fr 1fr; gap: 24px; align-items: stretch; }
        .card-heroes { background: white; border: 1px solid var(--border); border-radius: 12px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.02); height: 100%; display: flex; flex-direction: column; }
        .card-header-heroes { padding: 20px 24px; border-bottom: 1px solid var(--border); }
        .card-title-heroes { font-size: 18px; font-weight: 700; color: #222; }
        .card-subtitle-heroes { font-size: 13px; color: #888; }
        .btn-export { background: #67b69e; color: white; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .card-sidebar { background: white; border: 1px solid var(--border); border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; }
        .sidebar-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .sidebar-header h3 { font-size: 15px; font-weight: 700; margin: 0; }
        .sidebar-subtitle { font-size: 11px; color: #888; }
        .sidebar-content { padding: 16px; overflow-y: auto; flex: 1; }
        .table-heroes { width: 100%; border-collapse: collapse; }
        .table-heroes th { padding: 12px 24px; text-align: left; font-size: 11px; color: #888; text-transform: uppercase; }
        .table-wrapper-heroes { overflow-y: auto; flex-grow: 1; }
        .table-heroes td { padding: 14px 24px; font-size: 13px; color: #333; border-top: 1px solid #f0f0f0; }
        .role-badge { background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 500; }
        @media (max-width: 1024px) { .dashboard-content-grid { grid-template-columns: 1fr; } .dashboard-stats { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .dashboard-stats { grid-template-columns: 1fr; } }

        /* SERVICE SESSION WIDGET */
        .service-session-widget {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .session-status {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .session-status.active {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(79, 70, 229, 0.02) 100%);
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 8px;
        }

        .session-status.inactive {
            background: linear-gradient(135deg, rgba(107, 114, 128, 0.05) 0%, rgba(107, 114, 128, 0.02) 100%);
            border-left: 4px solid #6b7280;
            padding: 20px;
            border-radius: 8px;
        }

        .session-status-content {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .session-status-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .session-status-icon.active {
            background: linear-gradient(135deg, var(--primary-light) 0%, rgba(79, 70, 229, 0.15) 100%);
            color: var(--primary);
        }

        .session-status.inactive .session-status-icon {
            background: rgba(107, 114, 128, 0.15);
            color: #6b7280;
        }

        .session-status-info {
            flex: 1;
        }

        .session-status-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .session-status-details {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0 0 6px 0;
        }

        .detail-separator {
            margin: 0 6px;
        }

        .session-start-time {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-session-control {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-session-control.start {
            background: var(--primary);
            color: white;
        }

        .btn-session-control.start:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        .btn-session-control.end {
            background: #ef4444;
            color: white;
        }

        .btn-session-control.end:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        @media (max-width: 768px) {
            .session-status {
                flex-direction: column;
            }

            .session-status-content {
                width: 100%;
            }

            .btn-session-control {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    @include('admin.partials.service-session-modal')

</x-admin-layout>
