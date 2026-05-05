@extends('layouts.gallery')

@section('content')

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <section class="hero-section">
        <div class="hero-bg" style="background-image:url('{{ asset('images/artworks/artwork_07.jpg') }}')"></div>
        <div class="hero-content">
            <span class="hero-eyebrow">{{ __('app.hero_eyebrow') }}</span>

            <h1 class="hero-title" data-split="Kateryna Pohrebenna">
                Kateryna Pohrebenna
            </h1>

            <p class="hero-subtitle">{{ __('app.hero_subtitle') }}</p>

            <div class="hero-divider"></div>

            <p class="hero-text">
                {!! nl2br(e(__('app.hero_poem'))) !!}
            </p>

            <div class="hero-buttons">
                <a href="#featured" class="btn-primary">
                    <i class="fas fa-paint-brush"></i>
                    <span>{{ __('app.hero_btn_gallery') }}</span>
                </a>
                <a href="#about" class="btn-secondary">
                    <i class="fas fa-user"></i>
                    {{ __('app.hero_btn_about') }}
                </a>
            </div>
        </div>

        <div class="scroll-hint">
            <svg viewBox="0 0 30 50">
                <rect x="1" y="1" width="28" height="48" rx="14" ry="14"/>
                <circle cx="15" cy="15" r="3" fill="#c9a96e">
                    <animate attributeName="cy" from="12" to="28" dur="1.5s" repeatCount="indefinite"/>
                    <animate attributeName="opacity" from="1" to="0" dur="1.5s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>
    </section>


    {{-- =====================================================
         FEATURED — 3 великі роботи
    ====================================================== --}}
    <section id="featured" class="section section-dark">
        <div class="container">
            <div class="section-header reveal">
                <div>
                    <span class="section-label">{{ __('app.section_featured_label') }}</span>
                    <h2 class="section-title-main">{{ __('app.section_featured_title') }} <em>{{ __('app.section_featured_em') }}</em></h2>
                </div>
                <a href="/gallery" class="link-inline">
                    {{ __('app.section_all_gallery') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="featured-grid reveal">
                <div class="featured-card">
                    <img class="featured-card-img"
                         src="{{ asset('images/artworks/artwork_06.jpg') }}"
                         alt="Схід сонця над морем">
                    <div class="featured-card-overlay">
                        <h3 class="featured-card-title">{{ __('app.featured_1_title') }}</h3>
                        <span class="featured-card-sub">{!! __('app.featured_1_sub') !!}</span>
                        <p class="featured-card-desc">{{ __('app.featured_1_desc') }}</p>
                    </div>
                </div>
                <div class="featured-card">
                    <img class="featured-card-img"
                         src="{{ asset('images/artworks/artwork_12.jpg') }}"
                         alt="Колібрі на золотому фоні">
                    <div class="featured-card-overlay">
                        <h3 class="featured-card-title">{{ __('app.featured_2_title') }}</h3>
                        <span class="featured-card-sub">{!! __('app.featured_2_sub') !!}</span>
                        <p class="featured-card-desc">{{ __('app.featured_2_desc') }}</p>
                    </div>
                </div>
                <div class="featured-card">
                    <img class="featured-card-img"
                         src="{{ asset('images/artworks/artwork_03.jpg') }}"
                         alt="Кругла картина — руки і світло">
                    <div class="featured-card-overlay">
                        <h3 class="featured-card-title">{{ __('app.featured_3_title') }}</h3>
                        <span class="featured-card-sub">{!! __('app.featured_3_sub') !!}</span>
                        <p class="featured-card-desc">{{ __('app.featured_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- =====================================================
         MASONRY GALLERY — всі роботи з Instagram
    ====================================================== --}}
    <section class="section">
        <div class="container">
            <div class="section-title-center reveal">
                <span class="section-label">{{ __('app.section_collection_label') }}</span>
                <h2>{{ __('app.section_collection_title') }}</h2>
                <p>{{ __('app.section_collection_sub') }}</p>
                <div class="gold-line-divider"></div>
            </div>

            <div class="masonry-grid">
                <div class="masonry-item reveal delay-1">
                    <img src="{{ asset('images/artworks/artwork_01.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_1_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_1_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_1_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-2">
                    <img src="{{ asset('images/artworks/artwork_09.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_2_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_2_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_2_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-3">
                    <img src="{{ asset('images/artworks/artwork_04.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_3_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_3_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_3_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-1">
                    <img src="{{ asset('images/artworks/artwork_02.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_4_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_4_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_4_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-2">
                    <img src="{{ asset('images/artworks/artwork_05.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_5_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_5_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_5_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-3">
                    <img src="{{ asset('images/artworks/artwork_10.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_6_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_6_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_6_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-2">
                    <img src="{{ asset('images/artworks/artwork_11.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_7_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_7_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_7_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-1">
                    <img src="{{ asset('images/artworks/artwork_08.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_8_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_8_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_8_desc') }}</p>
                    </div>
                </div>
                <div class="masonry-item reveal delay-3">
                    <img src="{{ asset('images/artworks/artwork_07.jpg') }}" loading="lazy">
                    <div class="masonry-overlay">
                        <p class="masonry-title">{{ __('app.masonry_9_title') }}</p>
                        <span class="masonry-cat">{{ __('app.masonry_9_cat') }}</span>
                        <p class="masonry-desc">{{ __('app.masonry_9_desc') }}</p>
                    </div>
                </div>
            </div>

            <div class="gallery-view-all reveal">
                <a href="/gallery" class="btn-secondary">
                    <i class="fas fa-images"></i>
                    {{ __('app.section_view_all') }}
                </a>
            </div>
        </div>
    </section>


    {{-- =====================================================
         ПРО ХУДОЖНИЦЮ
    ====================================================== --}}
    <section id="about" class="artist-section section-dark">
        <div class="container">
            <div class="artist-grid">
                <div class="artist-image-wrap reveal-left">
                    <img class="artist-image"
                         src="{{ asset('images/artist/artist_studio.jpg') }}"
                         alt="Катерина Погребенна — художниця">
                </div>
                <div class="artist-info reveal-right">
                    <span class="section-label">{{ __('app.about_label') }}</span>
                    <h2>{{ __('app.about_title') }}<br><em>{{ __('app.about_em') }}</em></h2>
                    <div class="artist-divider"></div>
                    <p>
                        {{ __('app.about_text1') }}
                    </p>
                    <p>
                        {{ __('app.about_text2') }}
                    </p>
                    <div class="artist-stats">
                        <div>
                            <span class="stat-num">{{ __('app.about_stat1_num') }}</span>
                            <span class="stat-label">{{ __('app.about_stat1_label') }}</span>
                        </div>
                        <div>
                            <span class="stat-num">{{ __('app.about_stat2_num') }}</span>
                            <span class="stat-label">{{ __('app.about_stat2_label') }}</span>
                        </div>
                        <div>
                            <span class="stat-num">{{ __('app.about_stat3_num') }}</span>
                            <span class="stat-label">{{ __('app.about_stat3_label') }}</span>
                        </div>
                    </div>
                    <a href="https://www.instagram.com/katerina_lightart/" target="_blank" class="btn-primary btn-instagram">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram</span>
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- =====================================================
         ПОСЛУГИ
    ====================================================== --}}
    <section id="services" class="section">
        <div class="container">
            <div class="section-title-center reveal">
                <span class="section-label">{{ __('app.services_label') }}</span>
                <h2>{{ __('app.services_title') }}</h2>
                <p>{{ __('app.services_sub') }}</p>
                <div class="gold-line-divider"></div>
            </div>

            <div class="services-grid">
                <div class="service-card reveal delay-1">
                    <div class="service-icon"><i class="fas fa-user-circle"></i></div>
                    <h3 class="service-title">{{ __('app.service1_title') }}</h3>
                    <p class="service-desc">{{ __('app.service1_desc') }}</p>
                </div>
                <div class="service-card reveal delay-2">
                    <div class="service-icon"><i class="fas fa-palette"></i></div>
                    <h3 class="service-title">{{ __('app.service2_title') }}</h3>
                    <p class="service-desc">{{ __('app.service2_desc') }}</p>
                </div>
                <div class="service-card reveal delay-3">
                    <div class="service-icon"><i class="fas fa-water"></i></div>
                    <h3 class="service-title">{{ __('app.service3_title') }}</h3>
                    <p class="service-desc">{{ __('app.service3_desc') }}</p>
                </div>
                <div class="service-card reveal delay-4">
                    <div class="service-icon"><i class="fas fa-lightbulb"></i></div>
                    <h3 class="service-title">{{ __('app.service4_title') }}</h3>
                    <p class="service-desc">{{ __('app.service4_desc') }}</p>
                </div>
            </div>
        </div>
    </section>


    {{-- =====================================================
         ДИНАМІЧНІ РОБОТИ З БАЗИ ДАНИХ
    ====================================================== --}}
    @if(isset($featuredArtworks) && $featuredArtworks->count() > 0)
        <section class="section section-dark">
            <div class="container">
                <div class="section-header reveal">
                    <div>
                        <span class="section-label">{{ __('app.section_from_collection') }}</span>
                        <h2 class="section-title-main">{{ __('app.section_featured_works') }} <em>{{ __('app.section_works_em') }}</em></h2>
                    </div>
                    <a href="/gallery" class="link-inline">
                        {{ __('app.section_all_works') }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="gallery-grid">
                    @foreach($featuredArtworks as $artwork)
                        @include('gallery.partials.artwork-card', ['artwork' => $artwork])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(isset($recentArtworks) && $recentArtworks->count() > 0)
        <section class="section">
            <div class="container">
                <div class="section-header reveal">
                    <div>
                        <span class="section-label">{{ __('app.section_new_label') }}</span>
                        <h2 class="section-title-main">{{ __('app.section_new_title') }} <em>{{ __('app.section_works_em') }}</em></h2>
                    </div>
                    <a href="/gallery" class="link-inline">
                        {{ __('app.section_all_works') }} <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="gallery-grid">
                    @foreach($recentArtworks as $artwork)
                        @include('gallery.partials.artwork-card', ['artwork' => $artwork])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(isset($categories) && $categories->count() > 0)
        <section class="section section-dark">
            <div class="container">
                <div class="section-title-center reveal">
                    <span class="section-label">{{ __('app.section_categories_label') }}</span>
                    <h2>{{ __('app.section_categories_title') }}</h2>
                    <p>{{ __('app.section_categories_sub') }}</p>
                    <div class="gold-line-divider"></div>
                </div>
                <div class="categories-grid">
                    @foreach($categories as $category)
                        <a href="/gallery/category/{{ $category->slug }}" class="category-card reveal">
                            <span class="category-icon">
                                @if(str_contains(strtolower($category->name), 'портрет'))
                                    <i class="fas fa-user"></i>
                                @elseif(str_contains(strtolower($category->name), 'light'))
                                    <i class="fas fa-lightbulb"></i>
                                @elseif(str_contains(strtolower($category->name), 'резин'))
                                    <i class="fas fa-water"></i>
                                @else
                                    <i class="fas fa-palette"></i>
                                @endif
                            </span>
                            <h3 class="category-name">{{ $category->name }}</h3>
                            <p class="category-sub">{{ __('app.section_works_count', ['count' => $category->artworks_count ?? 0]) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    {{-- =====================================================
         CTA / КОНТАКТИ
    ====================================================== --}}
    <section id="contact" class="cta-section">
        <div class="container">
            <h2 class="cta-title reveal">{{ __('app.cta_title') }}</h2>
            <p class="cta-sub reveal delay-1">
                {{ __('app.cta_sub') }}
            </p>
            <div class="cta-buttons reveal delay-2">
                <a href="mailto:lavkatvorchestva@gmail.com" class="btn-primary">
                    <i class="far fa-envelope"></i>
                    <span>{{ __('app.cta_email') }}</span>
                </a>
                <a href="https://www.instagram.com/katerina_lightart/" target="_blank" class="btn-secondary">
                    <i class="fab fa-instagram"></i>
                    Instagram
                </a>
            </div>
        </div>
    </section>

@endsection
