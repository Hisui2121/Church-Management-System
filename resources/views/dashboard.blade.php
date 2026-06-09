<x-member-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="dashboard-container">
        {{-- BANNER CAROUSEL --}}
        <div class="banner-carousel-container">
            <div class="carousel-wrapper">
                <div class="carousel" id="bannerCarousel">
                    {{-- Carousel slides will be populated here --}}
                    @forelse ($banners as $banner)
                    <div class="carousel-slide" style="background-image: url('{{ asset('storage/' . $banner->image_path) }}')">
                    </div>
                    @empty
                    <div class="carousel-slide carousel-empty">
                        <div class="carousel-overlay">
                            <h2 class="carousel-title">Welcome to {{ config('app.name', 'Church') }}</h2>
                            <p class="carousel-description">Stay connected with your community</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- Carousel Controls --}}
                <button class="carousel-control carousel-prev" id="carouselPrev" title="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-control carousel-next" id="carouselNext" title="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>

                {{-- Carousel Indicators --}}
                <div class="carousel-indicators">
                    @forelse ($banners as $index => $banner)
                    <button class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" title="Go to slide {{ $index + 1 }}"></button>
                    @empty
                    <button class="indicator active" data-index="0"></button>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT GRID --}}
        <div class="dashboard-grid">
            {{-- LEFT SECTION: Announcements & Events --}}
            <section class="main-section">
                {{-- ANNOUNCEMENTS --}}
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="bi bi-megaphone-fill"></i> Announcements
                        </h3>
                        <a href="{{ route('announcements.index') }}" class="view-all-link">View All</a>
                    </div>

                    <div class="announcements-grid">
                        @forelse ($announcements as $announcement)
                        <div class="announcement-card">
                            @if ($announcement->image_path)
                            <div class="announcement-image">
                                <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->title }}">
                            </div>
                            @endif
                            <div class="announcement-content">
                                <h4 class="announcement-title">{{ $announcement->title }}</h4>
                                <p class="announcement-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}
                                </p>
                                <p class="announcement-excerpt">{{ Str::limit(strip_tags($announcement->body), 100) }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="bi bi-megaphone-fill"></i>
                            <p>No announcements yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- EVENTS --}}
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">
                            <i class="bi bi-calendar-event-fill"></i> Upcoming Events
                        </h3>
                        <a href="{{ route('events.index') }}" class="view-all-link">View All</a>
                    </div>

                    <div class="events-list">
                        @forelse ($events as $event)
                        <div class="event-item">
                            @if ($event->image_path)
                            <div class="event-image">
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}">
                            </div>
                            @else
                            <div class="event-image-placeholder">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            @endif
                            <div class="event-details">
                                <h4 class="event-title">{{ $event->name }}</h4>
                                @if ($event->event_date)
                                <p class="event-date">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $event->event_date->format('M d, Y') }}
                                    @if ($event->event_time)
                                    <span class="event-time">
                                        <i class="bi bi-clock"></i>
                                        {{ $event->event_time }}
                                    </span>
                                    @endif
                                </p>
                                @endif
                                @if ($event->description)
                                <p class="event-description">{{ Str::limit($event->description, 80) }}</p>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="bi bi-calendar-event-fill"></i>
                            <p>No upcoming events</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- RIGHT SECTION: Calendar --}}
            <aside class="sidebar-section">
                <div class="section-card calendar-card">
                    <div class="calendar-header">
                        <h3 class="calendar-title">
                            <i class="bi bi-calendar-fill"></i> Church Calendar
                        </h3>
                        <div class="calendar-nav">
                            <button id="calendarPrev" class="calendar-btn" title="Previous Month">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <span id="calendarMonth" class="calendar-month"></span>
                            <button id="calendarNext" class="calendar-btn" title="Next Month">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div id="calendar" class="calendar"></div>
                </div>

                {{-- UPCOMING EVENTS WIDGET --}}
                <div class="section-card">
                    <h4 class="section-subtitle">Upcoming This Week</h4>
                    <div class="upcoming-events">
                        @forelse ($eventsThisWeek as $event)
                        <div class="upcoming-event-item">
                            <span class="event-indicator"></span>
                            <div>
                                <p class="event-name">{{ $event->name }}</p>
                                <p class="event-small-date">{{ $event->event_date?->format('M d') }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="no-events-text">No events this week</p>
                        @endforelse
                    </div>
                </div>
    </div>

    <style>
        .dashboard-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            padding: 0;
        }

        {{-- BANNER CAROUSEL --}}
        .banner-carousel-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .carousel-wrapper {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 16px;
            overflow: hidden;
            background: #f3f4f6;
        }

        .carousel {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-empty {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .carousel-overlay {
            background: rgba(0, 0, 0, 0.3);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
            color: white;
        }

        .carousel-title {
            font-size: 32px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .carousel-description {
            font-size: 16px;
            margin: 0;
            opacity: 0.9;
        }

        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .carousel-control:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .carousel-prev {
            left: 20px;
        }

        .carousel-next {
            right: 20px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: white;
            width: 32px;
            border-radius: 6px;
        }

        {{-- DASHBOARD GRID --}}
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 24px;
        }

        .main-section {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .sidebar-section {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .section-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            font-size: 20px;
            color: var(--primary);
        }

        .section-subtitle {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 16px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .view-all-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .view-all-link:hover {
            color: var(--primary-dark);
        }

        {{-- ANNOUNCEMENTS --}}
        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
        }

        .announcement-card {
            background: #f9fafb;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .announcement-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .announcement-image {
            width: 100%;
            height: 160px;
            overflow: hidden;
        }

        .announcement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .announcement-content {
            padding: 16px;
        }

        .announcement-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
            line-height: 1.4;
        }

        .announcement-date {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .announcement-excerpt {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
            line-height: 1.4;
        }

        {{-- EVENTS --}}
        .events-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .event-item {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .event-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .event-image {
            width: 100px;
            height: 100px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-image-placeholder {
            width: 100px;
            height: 100px;
            background: var(--primary-light);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 32px;
            color: var(--primary);
        }

        .event-details {
            flex: 1;
        }

        .event-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 8px 0;
        }

        .event-date {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0 0 4px 0;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .event-time {
            margin-left: 12px;
        }

        .event-description {
            font-size: 13px;
            color: #6b7280;
            margin: 4px 0 0 0;
        }

        {{-- EMPTY STATE --}}
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
        }

        {{-- CALENDAR --}}
        .calendar-card {
            position: relative;
        }

        .calendar-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .calendar-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 12px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .calendar-month {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            min-width: 150px;
            text-align: center;
        }

        .calendar-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .calendar-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary);
        }

        #calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            padding: 8px 4px;
            text-transform: uppercase;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .calendar-day.other-month {
            color: #d1d5db;
        }

        .calendar-day.today {
            background: var(--primary);
            color: white;
            font-weight: 600;
        }

        .calendar-day.has-event {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
            border-color: var(--primary);
        }

        .calendar-day:hover {
            background: #f3f4f6;
        }

        {{-- UPCOMING EVENTS WIDGET --}}
        .upcoming-events {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .upcoming-event-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .event-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            flex-shrink: 0;
            margin-top: 6px;
        }

        .event-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 4px 0;
        }

        .event-small-date {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        .no-events-text {
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
            margin: 12px 0;
        }

        {{-- RESPONSIVE --}}
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .carousel-wrapper {
                height: 250px;
            }

            .carousel-title {
                font-size: 24px;
            }

            .carousel-description {
                font-size: 14px;
            }

            .announcements-grid {
                grid-template-columns: 1fr;
            }

            .calendar-nav {
                flex-direction: column;
                gap: 12px;
            }

            .calendar-month {
                min-width: auto;
                width: 100%;
            }

            .calendar-btn {
                width: 100%;
            }
        }
    </style>

    <script>
        {{-- Carousel functionality --}}
        const carousel = document.getElementById('bannerCarousel');
        const slides = carousel?.querySelectorAll('.carousel-slide') || [];
        const indicators = document.querySelectorAll('.indicator');
        let currentSlide = 0;

        function showSlide(index) {
            if (slides.length === 0) return;
            
            currentSlide = (index + slides.length) % slides.length;
            
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === currentSlide);
            });
            
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === currentSlide);
            });
        }

        document.getElementById('carouselPrev')?.addEventListener('click', () => showSlide(currentSlide - 1));
        document.getElementById('carouselNext')?.addEventListener('click', () => showSlide(currentSlide + 1));
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => showSlide(index));
        });

        showSlide(0);

        {{-- Auto-rotate carousel every 5 seconds --}}
        setInterval(() => {
            if (slides.length > 1) showSlide(currentSlide + 1);
        }, 5000);

        {{-- Calendar functionality --}}
        let calendarDate = new Date();

        function renderCalendar() {
            const year = calendarDate.getFullYear();
            const month = calendarDate.getMonth();
            const today = new Date();
            
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            
            document.getElementById('calendarMonth').textContent = 
                monthNames[month] + ' ' + year;

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();

            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const header = document.createElement('div');
                header.className = 'calendar-day-header';
                header.textContent = day;
                calendar.appendChild(header);
            });

            for (let i = 0; i < startingDayOfWeek; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                emptyDay.textContent = '';
                calendar.appendChild(emptyDay);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day';
                dayDiv.textContent = day;

                const currentDate = new Date(year, month, day);
                if (currentDate.toDateString() === today.toDateString()) {
                    dayDiv.classList.add('today');
                }

                {{-- Check if there are events/announcements on this day --}}
                const hasEvent = @json($eventDates ?? []).includes(
                    year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0')
                );
                
                if (hasEvent) {
                    dayDiv.classList.add('has-event');
                }

                calendar.appendChild(dayDiv);
            }
        }

        document.getElementById('calendarPrev')?.addEventListener('click', () => {
            calendarDate.setMonth(calendarDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('calendarNext')?.addEventListener('click', () => {
            calendarDate.setMonth(calendarDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    </script>
</x-member-layout>