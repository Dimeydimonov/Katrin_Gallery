<div class="artwork-card reveal">
    <a href="{{ route('gallery.show', $artwork) }}">
        @if($artwork->is_featured)
            <span class="featured-badge">
                <i class="fas fa-star"></i> {{ __('app.gallery_featured') }}
            </span>
        @endif

        <div class="artwork-card-img-wrap">
            @php($img = $artwork->main_image_url)
            @if($img)
                <img src="{{ $img }}" alt="{{ $artwork->title }}" class="artwork-card-img" loading="lazy">
            @else
                <div class="no-image-placeholder"><i class="fas fa-image"></i></div>
            @endif

            <div class="artwork-card-hover">
                <p class="artwork-card-hover-title">{{ $artwork->title }}</p>
                @if($artwork->description)
                    <p class="artwork-card-hover-desc">{{ Str::limit($artwork->description, 120) }}</p>
                @endif
                <span class="artwork-card-hover-link">
                    {{ __('app.card_view') }} <i class="fas fa-arrow-right"></i>
                </span>
            </div>
        </div>

        @if($artwork->price > 0)
            <div class="price-tag">{{ number_format($artwork->price, 0, ',', ' ') }} ₴</div>
        @endif
    </a>

    <div class="artwork-card-body">
        <h3 class="artwork-card-title">{{ Str::limit($artwork->title, 30) }}</h3>
        <p class="artwork-card-meta">
            @foreach($artwork->categories->take(2) as $cat)
                {{ $cat->name }}@if(!$loop->last), @endif
            @endforeach
        </p>
        @if($artwork->price > 0)
            <p class="artwork-card-price">{{ number_format($artwork->price, 0, ',', ' ') }} ₴</p>
        @endif
        <div class="artwork-card-stats">
            <span><i class="fas fa-heart artwork-card-heart"></i>{{ $artwork->likes_count ?? 0 }}</span>
            <span><i class="far fa-comment artwork-card-comment"></i>{{ $artwork->comments_count ?? 0 }}</span>
        </div>
    </div>
</div>
