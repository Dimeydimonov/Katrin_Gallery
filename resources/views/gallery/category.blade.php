@extends('layouts.gallery')

@section('content')
<div class="container mx-auto px-4 py-8">
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    <i class="fas fa-home mr-2"></i>
                    {{ __('app.cat_home') }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <a href="{{ route('gallery.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">{{ __('app.nav_gallery') }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">{{ $category->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
                <p class="text-gray-600">
                    {{ $artworks->total() }} {{ __('app.gallery_works_count') }}
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="relative">
                    <select id="sort" class="block appearance-none w-full md:w-64 bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="newest" {{ $sortBy === 'newest' ? 'selected' : '' }}>{{ __('app.cat_sort_newest') }}</option>
                        <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>{{ __('app.cat_sort_oldest') }}</option>
                        <option value="likes" {{ $sortBy === 'likes' ? 'selected' : '' }}>{{ __('app.cat_sort_popular') }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
        </div>

        @if($category->description)
            <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                <p class="text-indigo-800">{{ $category->description }}</p>
            </div>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-1/4">
            <div class="bg-white rounded-xl shadow-sm p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('app.gallery_categories') }}</h2>
                <div class="space-y-2">
                    <a href="{{ route('gallery.index') }}"
                       class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-th-large mr-2 text-indigo-500"></i>
                        {{ __('app.cat_all') }}
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('gallery.category', $cat->slug) }}"
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ $cat->id === $category->id ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}">
                            <i class="fas fa-image mr-2 text-indigo-500"></i>
                            {{ $cat->name }}
                            <span class="ml-auto bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $cat->artworks_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:w-3/4">
            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($artworks as $artwork)
                        @include('gallery.partials.artwork-card', ['artwork' => $artwork])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $artworks->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-indigo-100">
                        <i class="fas fa-palette text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('app.gallery_not_found') }}</h3>
                    <p class="mt-1 text-gray-500">{{ __('app.gallery_try_other_filters') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('gallery.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            <i class="fas fa-arrow-left mr-2"></i>
                            {{ __('app.gallery_back') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sortSelect = document.getElementById('sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                var url = '{{ route("gallery.category", $category->slug) }}?sort=' + this.value;
                window.location.href = url;
            });
        }
    });
</script>
@endpush
@endsection
