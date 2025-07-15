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
        // Simulate data from API
        var dashboardData = {
            totalProducts: 1250,
            totalSales: 3420,
            totalOrders: 1890,
            totalRevenue: 15420000
        };

        // Update dashboard cards with animation
        animateCounter('#totalProducts', dashboardData.totalProducts);
        animateCounter('#totalSales', dashboardData.totalSales);
        animateCounter('#totalOrders', dashboardData.totalOrders);
        animateCounter('#totalRevenue', dashboardData.totalRevenue, true);
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

    // Simulate real-time updates
    setInterval(function() {
        // Random small updates to make it feel dynamic
        var randomChange = Math.floor(Math.random() * 10) - 5;
        var currentSales = parseInt($('#totalSales').text().replace(/[^\d]/g, ''));
        var newSales = Math.max(0, currentSales + randomChange);
        $('#totalSales').text(formatNumber(newSales));
    }, 5000);

})(jQuery); 