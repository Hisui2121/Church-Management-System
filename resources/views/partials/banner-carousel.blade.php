<div class="banner-carousel-container">
    <div class="carousel-wrapper">
        <div class="carousel" id="bannerCarousel">
            @forelse ($banners as $banner)
            <div class="carousel-slide" style="background-image: url({{ asset('storage/' . $banner->image_path) }})"></div>
            @empty
            <div class="carousel-slide carousel-empty">
                <div class="carousel-overlay">
                    <h2 class="carousel-title">Welcome to {{ config('app.name', 'Church') }}</h2>
                    <p class="carousel-description">Stay connected with your community</p>
                </div>
            </div>
            @endforelse
        </div>

        <button class="carousel-control carousel-prev" id="carouselPrev" title="Previous">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button class="carousel-control carousel-next" id="carouselNext" title="Next">
            <i class="bi bi-chevron-right"></i>
        </button>

        <div class="carousel-indicators">
            @forelse ($banners as $index => $banner)
            <button class="indicator {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" title="Go to slide {{ $index + 1 }}"></button>
            @empty
            <button class="indicator active" data-index="0"></button>
            @endforelse
        </div>
    </div>
</div>