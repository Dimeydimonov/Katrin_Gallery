<nav class="navbar" id="navbar">
    <div class="container">
        <a href="/" class="navbar-logo">KAT<span>ARTS</span></a>

        <ul class="navbar-nav" id="navMenu">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">{{ __('app.nav_home') }}</a></li>
            <li><a href="/gallery" class="{{ request()->is('gallery*') ? 'active' : '' }}">{{ __('app.nav_gallery') }}</a></li>
            <li><a href="/#about">{{ __('app.nav_about') }}</a></li>
            <li><a href="/#contact">{{ __('app.nav_contacts') }}</a></li>
            @auth
                @if(auth()->user()->isAdmin())
                    <li><a href="/admin">{{ __('app.nav_admin') }}</a></li>
                @endif
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('app.nav_logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden-form">@csrf</form>
                </li>
            @else
                <li><a href="/login" class="login-link">{{ __('app.nav_login') }}</a></li>
            @endauth
        </ul>

        {{-- Language switcher --}}
        <div class="lang-switcher">
            <a href="{{ route('locale.switch', 'uk') }}"
               class="lang-btn {{ app()->getLocale() === 'uk' ? 'lang-btn--active' : '' }}">UA</a>
            <span class="lang-divider">|</span>
            <a href="{{ route('locale.switch', 'en') }}"
               class="lang-btn {{ app()->getLocale() === 'en' ? 'lang-btn--active' : '' }}">EN</a>
        </div>

        <button class="burger-menu" aria-label="Меню">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
