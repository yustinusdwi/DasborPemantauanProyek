// Netflix Effects JavaScript
(function($) {
    "use strict";

    $(document).ready(function() {
        // Add Netflix-style hover effects
        addNetflixEffects();
        
        // Add smooth transitions
        addSmoothTransitions();
        
        // Add loading animations
        addLoadingAnimations();
    });

    function addNetflixEffects() {
        // Card hover effects
        $('.card').hover(
            function() {
                $(this).css({
                    'transform': 'scale(1.02)',
                    'box-shadow': '0 8px 25px rgba(229, 9, 20, 0.3)',
                    'transition': 'all 0.3s ease'
                });
            },
            function() {
                $(this).css({
                    'transform': 'scale(1)',
                    'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.3)',
                    'transition': 'all 0.3s ease'
                });
            }
        );

        // Button hover effects
        $('.btn').hover(
            function() {
                $(this).css({
                    'transform': 'translateY(-2px)',
                    'box-shadow': '0 4px 12px rgba(229, 9, 20, 0.4)',
                    'transition': 'all 0.2s ease'
                });
            },
            function() {
                $(this).css({
                    'transform': 'translateY(0)',
                    'box-shadow': 'none',
                    'transition': 'all 0.2s ease'
                });
            }
        );

        // Navigation link effects
        $('.nav-link').hover(
            function() {
                $(this).css({
                    'transform': 'translateX(5px)',
                    'transition': 'all 0.2s ease'
                });
            },
            function() {
                $(this).css({
                    'transform': 'translateX(0)',
                    'transition': 'all 0.2s ease'
                });
            }
        );
    }

    function addSmoothTransitions() {
        // Add smooth page transitions
        $('a').click(function(e) {
            if ($(this).attr('href') && $(this).attr('href').startsWith('#')) {
                e.preventDefault();
                var target = $($(this).attr('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            }
        });

        // Smooth sidebar toggle
        $('#sidebarToggle').click(function(e) {
            e.preventDefault();
            $('body').toggleClass('sb-sidenav-toggled');
            
            // Add transition effect
            $('#layoutSidenav').css({
                'transition': 'all 0.3s ease'
            });
        });
    }

    function addLoadingAnimations() {
        // Add loading animation to dashboard cards
        $('.card').each(function(index) {
            var $card = $(this);
            setTimeout(function() {
                $card.addClass('fade-in');
            }, index * 200);
        });

        // Add pulse effect to important elements
        $('.card.bg-primary, .card.bg-warning, .card.bg-success, .card.bg-danger').addClass('pulse-on-hover');

        // Add typing effect to titles
        $('h1, h2').each(function() {
            var $title = $(this);
            var text = $title.text();
            $title.text('');
            $title.addClass('typing-effect');
            
            var i = 0;
            var typeInterval = setInterval(function() {
                if (i < text.length) {
                    $title.text($title.text() + text.charAt(i));
                    i++;
                } else {
                    clearInterval(typeInterval);
                }
            }, 50);
        });
    }

    // Add CSS classes for animations
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .fade-in {
                animation: fadeIn 0.8s ease-in;
            }
            
            .pulse-on-hover:hover {
                animation: pulse 1s infinite;
            }
            
            .typing-effect {
                border-right: 2px solid #e50914;
                animation: blink 1s infinite;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            
            @keyframes blink {
                0%, 50% { border-color: transparent; }
                51%, 100% { border-color: #e50914; }
            }
            
            .card-hover {
                transform: scale(1.02) !important;
                box-shadow: 0 8px 25px rgba(229, 9, 20, 0.3) !important;
            }
        `)
        .appendTo('head');

    // Add scroll effects
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        
        // Parallax effect for cards
        $('.card').css({
            'transform': 'translateY(' + (scroll * 0.1) + 'px)'
        });
        
        // Fade in elements on scroll
        $('.card').each(function() {
            var cardTop = $(this).offset().top;
            var cardBottom = cardTop + $(this).outerHeight();
            var windowTop = $(window).scrollTop();
            var windowBottom = windowTop + $(window).height();
            
            if (cardBottom > windowTop && cardTop < windowBottom) {
                $(this).addClass('fade-in');
            }
        });
    });

})(jQuery); 