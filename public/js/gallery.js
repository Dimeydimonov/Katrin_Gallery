/* ============================================================
   KATARTS — Gallery JS v2.0
   Custom Cursor | Parallax | Split Text | Scroll Reveal | Masonry
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

    /* --------------------------------------------------------
       1. CUSTOM CURSOR
    -------------------------------------------------------- */
    const dot  = document.querySelector('.cursor-dot');
    const ring = document.querySelector('.cursor-ring');

    if (dot && ring) {
        let mouseX = 0, mouseY = 0;
        let ringX  = 0, ringY  = 0;

        document.addEventListener('mousemove', function (e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            dot.style.left = mouseX + 'px';
            dot.style.top  = mouseY + 'px';
        });

        // Ring follows with slight lag
        (function animateRing() {
            ringX += (mouseX - ringX) * 0.14;
            ringY += (mouseY - ringY) * 0.14;
            ring.style.left = ringX + 'px';
            ring.style.top  = ringY + 'px';
            requestAnimationFrame(animateRing);
        })();

        // Hover effect on interactive elements
        const hoverEls = document.querySelectorAll('a, button, .artwork-card, .masonry-item, .featured-card, .service-card, .category-card');
        hoverEls.forEach(function (el) {
            el.addEventListener('mouseenter', function () { ring.classList.add('is-hovering'); });
            el.addEventListener('mouseleave', function () { ring.classList.remove('is-hovering'); });
        });
    }

    /* --------------------------------------------------------
       2. NAVBAR SCROLL
    -------------------------------------------------------- */
    var navbar = document.getElementById('navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    /* --------------------------------------------------------
       3. HERO PARALLAX
    -------------------------------------------------------- */
    var heroBg = document.querySelector('.hero-bg');
    if (heroBg) {
        window.addEventListener('scroll', function () {
            var scrollY = window.scrollY;
            heroBg.style.transform = 'translateY(' + (scrollY * 0.4) + 'px)';
        }, { passive: true });
    }

    /* --------------------------------------------------------
       4. SPLIT TEXT ANIMATION (Hero Title)
    -------------------------------------------------------- */
    var heroTitle = document.querySelector('.hero-title[data-split]');
    if (heroTitle) {
        var text    = heroTitle.getAttribute('data-split');
        var words   = text.split(' ');
        var html    = '';
        var charIdx = 0;
        var delay   = 0.6;

        words.forEach(function (word, wi) {
            html += '<span style="display:inline-block;white-space:nowrap">';
            word.split('').forEach(function (char) {
                var d = delay + charIdx * 0.042;
                html += '<span class="char" style="animation-delay:' + d + 's">' + char + '</span>';
                charIdx++;
            });
            html += '</span>';
            if (wi < words.length - 1) {
                html += ' ';
            }
        });
        heroTitle.innerHTML = html;
    }

    /* --------------------------------------------------------
       5. SCROLL REVEAL (Intersection Observer)
    -------------------------------------------------------- */
    var revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(function (el) { observer.observe(el); });
    } else {
        // Fallback for old browsers
        revealEls.forEach(function (el) { el.classList.add('revealed'); });
    }

    /* --------------------------------------------------------
       6. SMOOTH SCROLL for anchor links
    -------------------------------------------------------- */
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                var offset = 80;
                var top = target.getBoundingClientRect().top + window.scrollY - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    });

    /* --------------------------------------------------------
       7. LAZY LOAD IMAGES
    -------------------------------------------------------- */
    var lazyImgs = document.querySelectorAll('img[data-src]');
    if (lazyImgs.length && 'IntersectionObserver' in window) {
        var imgObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.getAttribute('data-src');
                    img.removeAttribute('data-src');
                    imgObserver.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });
        lazyImgs.forEach(function (img) { imgObserver.observe(img); });
    }

    /* --------------------------------------------------------
       8. BURGER MENU
    -------------------------------------------------------- */
    var burger  = document.querySelector('.burger-menu');
    var navMenu = document.getElementById('navMenu');

    if (burger && navMenu) {
        burger.addEventListener('click', function () {
            navMenu.classList.toggle('open');
        });

        // Close on nav link click
        navMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('open');
            });
        });

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (!burger.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('open');
            }
        });
    }

    /* --------------------------------------------------------
       9. ALERT AUTO-DISMISS
    -------------------------------------------------------- */
    var alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity    = '0';
            setTimeout(function () { alert.remove(); }, 500);
        }, 4000);
    });

});
