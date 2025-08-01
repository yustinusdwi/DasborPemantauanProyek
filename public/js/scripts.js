/*!
    * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    (function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
    // Tutup sidebar jika klik di luar pada layar kecil atau klik overlay
    $(document).on('click', function(e) {
        if ($(window).width() < 992) {
            if (!$(e.target).closest('#layoutSidenav_nav, #sidebarToggle').length && $("body").hasClass("sb-sidenav-toggled")) {
                $("body").removeClass("sb-sidenav-toggled");
            }
        }
    });
    // Tutup sidebar jika klik overlay
    $(document).on('click', '.sb-sidenav-overlay', function() {
        $("body").removeClass("sb-sidenav-toggled");
    });
})(jQuery);
