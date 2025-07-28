// Dashboard Data JavaScript
(function($) {
    "use strict";

    // Simulate loading dashboard data
    $(document).ready(function() {
        // Simulate API call delay
        setTimeout(function() {
            updateDashboardStats();
        }, 1000);
    });

    function updateDashboardStats() {
        // Data akan diambil dari API backend
        // Tidak ada data dummy - semua data berasal dari database
    }

    function animateCounter(elementId, targetValue, isCurrency = false) {
        var $element = $(elementId);
        var startValue = 0;
        var duration = 2000;
        var startTime = null;

        function animate(currentTime) {
            if (!startTime) startTime = currentTime;
            var progress = Math.min((currentTime - startTime) / duration, 1);
            
            // Easing function
            var easeOutQuart = 1 - Math.pow(1 - progress, 4);
            var currentValue = Math.floor(startValue + (targetValue - startValue) * easeOutQuart);
            
            if (isCurrency) {
                $element.text('Rp ' + formatNumber(currentValue));
            } else {
                $element.text(formatNumber(currentValue));
            }
            
            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        }
        
        requestAnimationFrame(animate);
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Add hover effects to cards
    $('.card').hover(
        function() {
            $(this).addClass('card-hover');
        },
        function() {
            $(this).removeClass('card-hover');
        }
    );

    // Add click effects to navigation links
    $('.nav-link').click(function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    // Real-time updates akan diambil dari API backend
    // Tidak ada data dummy - semua data berasal dari database

})(jQuery); 