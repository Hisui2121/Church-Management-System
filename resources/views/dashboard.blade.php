<x-layout>
    <x-slot:title>
        Dashboard
    </x-slot:title>

    <div class="church-dashboard">

        {{-- MAIN CONTENT --}}
        <main class="dashboard-content">

            {{-- MAIN GRID --}}
            <div class="dashboard-grid">

                {{-- LEFT CONTENT --}}
                <section class="main-section">

                    {{-- HERO / VIDEO --}}
                    <div class="hero-card">

                        {{-- EASY VIDEO PLACEHOLDER --}}
                        <div class="video-placeholder">

                            {{--
                                Replace this div with:
                                
                                <video controls>
                                    <source src="{{ asset('videos/church.mp4') }}" type="video/mp4">
                                </video>

                                OR

                                <iframe src="youtube-link"></iframe>
                            --}}

                            <div class="play-button">▶</div>

                            <div class="hero-overlay">
                                <h2>Welcome to Heroes Church</h2>
                                <p>Pastor Placeholder Name</p>
                            </div>

                        </div>

                    </div>

                    {{-- ANNOUNCEMENTS --}}
                    <div class="section-title">
                        <h3>Announcements</h3>
                    </div>

                    <div class="announcement-grid">

                        <div class="announcement-card blue-card">
                            <span>PLACEHOLDER</span>
                        </div>

                        <div class="announcement-card green-card">
                            <span>PLACEHOLDER</span>
                        </div>

                        <div class="announcement-card purple-card">
                            <span>PLACEHOLDER</span>
                        </div>

                    </div>

                </section>

                {{-- RIGHT SIDEBAR CONTENT --}}
                <aside class="right-panel">

                    {{-- CALENDAR --}}
                    <div class="widget-card calendar-card">

                        <div class="widget-header">
                            Church Calendar
                        </div>

                        <div class="calendar-placeholder">
                            <div class="month">
                                January 2026
                            </div>

                            <div class="calendar-grid">
                                <span>Su</span>
                                <span>Mo</span>
                                <span>Tu</span>
                                <span>We</span>
                                <span>Th</span>
                                <span>Fr</span>
                                <span>Sa</span>

                                @for ($i = 1; $i <= 31; $i++)
                                    <span>{{ $i }}</span>
                                @endfor
                            </div>
                        </div>

                    </div>

                    {{-- SERVICE CARD --}}
                    <div class="service-card">
                        <div class="service-date">
                            <span>MAR</span>
                            <h2>01</h2>
                        </div>

                        <div class="service-info">
                            <small>SUNDAY SERVICE</small>
                            <h3>ATTENDANCE</h3>
                        </div>
                    </div>

                    {{-- EXTRA WIDGET --}}
                    <div class="widget-card purple-widget">
                        <span>PLACEHOLDER</span>
                    </div>

                </aside>

            </div>
        </main>
    </div>

</x-layout>