@extends('layouts.gallery')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ url()->previous() === url()->current() ? route('gallery.index') : url()->previous() }}"
           class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> {{ __('app.gallery_back') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-2/3 relative">
                <div class="relative w-full artwork-aspect-ratio">
                    @php($img = $artwork->main_image_url)
                    @if($img)
                        <img src="{{ $img }}"
                             alt="{{ $artwork->title }}"
                             class="absolute inset-0 w-full h-full object-contain p-4">
                    @else
                        <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-gray-100">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                    @endif
                </div>

                <div class="absolute top-4 right-4">
                    <button type="button"
                            class="like-button {{ $artwork->isLikedBy(auth()->id()) ? 'liked' : '' }}"
                            data-artwork-id="{{ $artwork->id }}"
                            data-liked="{{ $artwork->isLikedBy(auth()->id()) ? 'true' : 'false' }}"
                            onclick="toggleLike({{ $artwork->id }})">
                        @if($artwork->isLikedBy(auth()->id()))
                            <i class="fas fa-heart text-red-500"></i>
                        @else
                            <i class="far fa-heart"></i>
                        @endif
                        <span class="like-count ml-1">{{ $artwork->likes_count ?? 0 }}</span>
                    </button>
                </div>
            </div>

            <div class="p-6 md:w-1/3 border-l border-gray-100">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $artwork->title }}</h1>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $artwork->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $artwork->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($artwork->price > 0)
                        <div class="bg-indigo-50 p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-500 mb-1">{{ __('app.gallery_price') }}</p>
                            <p class="text-2xl font-bold text-indigo-700">{{ number_format($artwork->price, 0, ',', ' ') }} ₴</p>
                            @auth
                                <button class="w-full mt-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    {{ __('app.gallery_buy') }}
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="block mt-3 text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    {{ __('app.gallery_login_buy') }}
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>

                @if($artwork->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('app.gallery_description') }}</h3>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($artwork->description)) !!}
                        </div>
                    </div>
                @endif

                @if($artwork->categories->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('app.gallery_categories') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($artwork->categories as $category)
                                <a href="{{ route('gallery.category', $category) }}"
                                   class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">{{ __('app.gallery_share') }}</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-pink-500 text-white flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500 transition-colors">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">{{ __('app.gallery_details') }}</h4>
                        <dl class="space-y-3">
                            @if($artwork->size)
                            <div class="flex">
                                <dt class="w-1/3 text-sm text-gray-500">{{ __('app.gallery_size') }}</dt>
                                <dd class="text-sm text-gray-900">{{ $artwork->size }}</dd>
                            </div>
                            @endif
                            @if($artwork->materials)
                            <div class="flex">
                                <dt class="w-1/3 text-sm text-gray-500">{{ __('app.gallery_materials') }}</dt>
                                <dd class="text-sm text-gray-900">{{ $artwork->materials }}</dd>
                            </div>
                            @endif
                            @if($artwork->year)
                            <div class="flex">
                                <dt class="w-1/3 text-sm text-gray-500">{{ __('app.gallery_year') }}</dt>
                                <dd class="text-sm text-gray-900">{{ $artwork->year }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">{{ __('app.gallery_about_artist') }}</h4>
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-indigo-600 text-xl"></i>
                            </div>
                            <div>
                                <h5 class="font-medium text-gray-900">{{ $artwork->user->name }}</h5>
                                <p class="text-sm text-gray-500">{{ __('app.gallery_joined', ['date' => $artwork->user->created_at->format('d.m.Y')]) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">{{ __('app.gallery_reviews_tab', ['count' => $artwork->comments->count()]) }}</h2>

            @auth
                <div class="mb-6">
                    <div class="mb-4">
                        <label for="comment" class="sr-only">{{ __('app.gallery_your_review') }}</label>
                        <textarea id="comment-text" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                  placeholder="{{ __('app.gallery_leave_review') }}..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="submitComment({{ $artwork->id }})" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('app.gallery_send') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('app.nav_login') }}</a>,
                        {{ __('app.gallery_login_review') }}.
                    </p>
                </div>
            @endauth

            @if($artwork->comments->count() > 0)
                <div class="space-y-6">
                    @foreach($artwork->comments as $comment)
                        <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">{{ __('app.gallery_no_reviews') }}</p>
            @endif
        </div>
    </div>

    @if($relatedArtworks->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('app.gallery_related') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedArtworks as $relatedArtwork)
                    @include('gallery.partials.artwork-card', ['artwork' => $relatedArtwork])
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleLike(artworkId) {
        const button = document.querySelector(`.like-button[data-artwork-id="${artworkId}"]`);
        const isLiked = button.getAttribute('data-liked') === 'true';
        const url = isLiked ? `/api/artworks/${artworkId}/like` : `/api/artworks/${artworkId}/like`;
        const method = isLiked ? 'DELETE' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const likeCount = button.querySelector('.like-count');
                const heartIcon = button.querySelector('i');

                if (isLiked) {
                    button.classList.remove('liked');
                    button.setAttribute('data-liked', 'false');
                    heartIcon.classList.remove('fas');
                    heartIcon.classList.add('far');
                    heartIcon.classList.remove('text-red-500');
                } else {
                    button.classList.add('liked');
                    button.setAttribute('data-liked', 'true');
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                    heartIcon.classList.add('text-red-500');
                }

                if (likeCount && data.likes_count !== undefined) {
                    likeCount.textContent = data.likes_count;
                }
            }
        });
    }

    // отправка комментария через api
    function submitComment(artworkId) {
        var text = document.getElementById('comment-text');
        if (!text.value.trim()) return;

        fetch('/api/comments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                artwork_id: artworkId,
                content: text.value.trim()
            })
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.status === 'success') {
                window.location.reload();
            }
        });
    }
</script>
@endpush
@endsection
