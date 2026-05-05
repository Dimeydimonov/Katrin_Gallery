<footer class="footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-about">
                <h3 class="footer-heading">KatArts</h3>
                <p class="footer-text">{{ __('app.footer_about_text') }}</p>
                <div class="footer-social-links">
                    <a href="https://www.instagram.com/katerina_lightart/" target="_blank" class="footer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="footer-social-link" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                    <a href="#" class="footer-social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="footer-social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <div class="footer-nav">
                <h3 class="footer-heading">{{ __('app.footer_nav') }}</h3>
                <ul class="footer-links">
                    <li><a href="/" class="footer-link">{{ __('app.nav_home') }}</a></li>
                    <li><a href="{{ route('gallery.all') }}" class="footer-link">{{ __('app.nav_gallery') }}</a></li>
                    <li><a href="/#about" class="footer-link">{{ __('app.nav_about') }}</a></li>
                    <li><a href="/#services" class="footer-link">{{ __('app.footer_services') }}</a></li>
                    <li><a href="/#contact" class="footer-link">{{ __('app.nav_contacts') }}</a></li>
                </ul>
            </div>

            <div class="footer-support">
                <h3 class="footer-heading">{{ __('app.footer_contacts') }}</h3>
                <ul class="footer-links">
                    <li><a href="mailto:lavkatvorchestva@gmail.com" class="footer-link"><i class="far fa-envelope"></i> Email</a></li>
                    <li><a href="tel:+380505585438" class="footer-link"><i class="fas fa-phone"></i> +38 050 558 5438</a></li>
                    <li><span class="footer-link footer-location"><i class="fas fa-map-marker-alt"></i> Odesa, Ukraine</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>{!! __('app.footer_rights', ['year' => date('Y')]) !!}</p>
            <p class="footer-made-with">{{ __('app.footer_made_with') }} <i class="fas fa-heart"></i></p>
        </div>
    </div>
</footer>
