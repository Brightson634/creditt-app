(function ($) {

    'use strict';

    var $body = $('body');

    function initMetisMenu() {
        $("#side-menu").metisMenu();
    }

    function activeNavbar() {
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById("page-topbar");
            if (window.scrollY > 0) {
              navbar.classList.add("scrolled");
            } else {
              navbar.classList.remove("scrolled");
            }
        });
    }

    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function () {
            $('body').toggleClass('enable-vertical-menu');
        });

        $('.menu-overlay').on('click', function () {
            $('body').removeClass('enable-vertical-menu');
            return;
        });
    }

    function initActiveMenu() {
        $("#sidebar-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().addClass("mm-active");
                $(this).parent().parent().addClass("mm-show");
                $(this).parent().parent().prev().addClass("mm-active"); 
                $(this).parent().parent().parent().addClass("mm-active");
                $(this).parent().parent().parent().parent().addClass("mm-show");
                $(this).parent().parent().parent().parent().parent().addClass("mm-active");
            }
        });
    }

   function themeDark() {
      var $dark = $('#dark_mode');
      var dark = 'theme-dark';

      if (localStorage.getItem('dark') === 'true') {
         $body.addClass(dark);
         $dark.attr('checked', true);
      }

      $dark.on('change', function(event) {
         if (event.target.checked) {
            $body.addClass(dark);
            localStorage.setItem('dark', true);
         } else {
            $body.removeClass(dark);
            localStorage.setItem('dark', false);
         }
      });
   }



    function initComponents() {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    }

    function init() {
        activeNavbar()
        initMetisMenu();
        initLeftMenuCollapse();
        initActiveMenu();
        initComponents();
        themeDark();
    }

    init();

})(jQuery)