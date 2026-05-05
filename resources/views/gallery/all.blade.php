@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('app.gallery_all_works') }}</h1>
        <p class="text-gray-600 dark:text-gray-300">{{ __('app.gallery_all_description') }}</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-1/4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('app.cat_filters') }}</h2>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">{{ __('app.gallery_categories') }}</h3>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input id="all-categories" type="radio" name="category" value="all" checked
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                            <label for="all-categories" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ __('app.cat_all') }}
                            </label>
                        </div>
                        @foreach($categories as $category)
                            <div class="flex items-center">
                                <input id="category-{{ $category->id }}" type="radio" name="category" value="{{ $category->slug }}"
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                <label for="category-{{ $category->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $category->name }} ({{ $category->artworks_count }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">{{ __('app.cat_sort_newest') }}</h3>
                    <select id="sort-by" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="newest">{{ __('app.cat_sort_newest') }}</option>
                        <option value="oldest">{{ __('app.cat_sort_oldest') }}</option>
                        <option value="likes">{{ __('app.cat_sort_popular') }}</option>
                    </select>
                </div>

                <button type="button" id="reset-filters" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('app.cat_reset_filters') }}
                </button>
            </div>
        </div>

        <div class="lg:w-3/4">
            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($artworks as $artwork)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('gallery.show', $artwork->slug) }}" class="block">
                                <div class="bg-gray-100 dark:bg-gray-700">
                                    @if($artwork->main_image_url)
                                        <img src="{{ $artwork->main_image_url }}"
                                             alt="{{ $artwork->title }}"
                                             class="w-full h-64 object-cover">
                                    @else
                                        <div class="w-full h-64 flex items-center justify-center">
                                            <i class="fas fa-image text-2xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-1">{{ $artwork->title }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        {{ $artwork->user->name }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $artwork->created_at->diffForHumans() }}
                                        </span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                            <i class="fas fa-heart text-red-500"></i> {{ $artwork->likes_count ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $artworks->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-palette text-4xl text-gray-400 mb-3"></i>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('app.gallery_not_found') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('app.gallery_try_other_filters') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryRadios = document.querySelectorAll('input[name="category"]');
        categoryRadios.forEach(function(radio) {
            radio.addEventListener('change', applyFilters);
        });

        const sortBySelect = document.getElementById('sort-by');
        if (sortBySelect) {
            sortBySelect.addEventListener('change', applyFilters);
        }

        var resetButton = document.getElementById('reset-filters');
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                document.getElementById('all-categories').checked = true;
                if (sortBySelect) sortBySelect.value = 'newest';
                applyFilters();
            });
        }

        function applyFilters() {
            var selectedCategory = document.querySelector('input[name="category"]:checked').value;
            var sortBy = sortBySelect ? sortBySelect.value : 'newest';

            var url = '{{ route("gallery.all") }}?sort=' + sortBy;
            if (selectedCategory !== 'all') {
                url += '&category=' + selectedCategory;
            }
            window.location.href = url;
        }
    });
</script>
@endpush
@endsection
