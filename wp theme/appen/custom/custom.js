jQuery(function ($) {
  $("header .x-navbar").addClass("x-navbar-fixed-top");

  $("#top.site").prepend('<div class="top_notice_sec" style="display:none">' + $(".top_custtom_notice .custom-html-widget").html() + '</div>');
  $(".team_close_btn").click(function () {
    $(this).parents(".team_pop_outer").hide();
    $(".x-main").removeClass("se_zindex");
  });
  $(".team_show_bio").click(function () {
    $(this).parents(".leadership_team_inner").find(".team_pop_outer").show();
    $(".x-main").addClass("se_zindex");
  });

  /*----*/
  $(".meeting_overlay").click(function () {
    $(this).closest(".meeting_popup").hide();
    $("header, .custtom_top_menu_section, .top_custtom_notice").removeClass("overflow_hide");
    $("body").removeClass("appen_pop");
  });


  /*----*/
  function auto_ref() {
    $(".boxed_menu").each(function () {
      if ($(this).hasClass('x-active')) {
        $(this).find("ul.sub-menu").addClass("collapse in");
        $(this).find("ul.sub-menu ul.sub-menu").addClass("collapse in");
      } else {
        $(this).find(".sub-menu").removeClass("in");
        $(this).find("ul.sub-menu ul.sub-menu").addClass("collapse in");
      }
    });
  }
  setInterval(auto_ref, 50);
  auto_ref();

  /*----*/

  function func_auto_refresh() {
    $(".pt-cv-content-item").each(function () {
      if ($(this).find(".pt-cv-ctf-short_title .pt-cv-ctf-value").text() != '') {
        $(this).find(".pt-cv-title a").text($(this).find(".pt-cv-ctf-short_title .pt-cv-ctf-value").text());
      }
    });
  }
  setInterval(func_auto_refresh, "300");
  func_auto_refresh();

  /*----*/
  function func_auto_refresh_1() {
    $(".rp_m_1").each(function () {
      if ($(this).find(".pf_sd .s_t").text() != '') {
        $(this).find(".pf_sd .m_t").text($(this).find(".pf_sd .s_t").text());
      }
    });
  }
  setInterval(func_auto_refresh_1, "300");
  func_auto_refresh_1();

  function auto_refresh_div_2() {
    if (parseFloat($("span.smw-market-data-field.smw-change-indicator").first().text()) >= 0.00) {
      $(".smw-change-quote").removeClass('it_fall').addClass('it_rise');
    }
    if (parseFloat($("span.smw-market-data-field.smw-change-indicator").first().text()) < 0.00) {
      $(".smw-change-quote").removeClass('it_rise').addClass('it_fall');
    }
  }
  setInterval(auto_refresh_div_2, 1000);
  auto_refresh_div_2();

  /* ---- */
  $(".tf_top_search_from").submit(function (e) {
    e.preventDefault();
    console.log($(this).find("#frm_search").val().length == 0);

  });
  $(".top_search_btn_click").click(function () {
    $(this).parents(".custom_search_outer").toggleClass("clickedd");
    if ($(this).parents(".custom_search_outer").find("#frm_search").val().length != 0) {
      $(".tf_top_search_from").submit();
      window.location.href = "https://appen.com?s=" + $(this).parents(".custom_search_outer").find("#frm_search").val();
    }
  });

  /* -- */

  $("body").on('click', '.lang_disp', function () {
    $(".lang_dd").toggle();
  });

  /* -- */
  setTimeout(function () {
    $('.bottom_contact .hbspt_forms').hide();
  }, 500);
  $('body').on('click', '.bottom_contact .toggle_side_contact', function (e) {
    e.preventDefault();
    var thisE = $(this);
    if (thisE.hasClass('flt_active')) {} else {
      $('.bottom_contact .hbspt_forms').slideToggle();
      $(this).toggleClass('flt_active');
      $('strong.close_wrap').show();
    }
  });
  $('body').on('click', 'strong.close_wrap', function (e) {
    $('strong.close_wrap').hide();
    $('.bottom_contact .hbspt_forms').slideToggle();
    $('.bottom_contact .toggle_side_contact').toggleClass('flt_active');
  });

  $(".mobile .btn_curved1>a").click(function (e) {
    e.preventDefault();
    if ($(this).closest(".btn_curved1").find("ul").hasClass("x-collapsed")) {
      $(this).closest(".btn_curved1").find(".x-collapsed").removeClass("x-collapsed");
    } else {
      $(this).closest(".btn_curved1").find("ul").addClass("x-collapsed");
    }
  });

  $("#x-nav-wrap-mobile #menu-main-menu-1").css("visibility", "hidden");
  var ps_11 = 0;
  $("body").on("click", "a#x-btn-navbar", function () {

    if (ps_11 % 2 == 0) {
      setTimeout(function () {
        $("#x-nav-wrap-mobile #menu-main-menu-1").css("visibility", "visible");
      }, 200)
    } else {
      $("#x-nav-wrap-mobile #menu-main-menu-1").css("visibility", "hidden");
    }
    ps_11++;

  })

  mobileMenu();


});


/*
// lazy loading //
*/

document.addEventListener("DOMContentLoaded", function () {
  var lazyloadImages;

  if ("IntersectionObserver" in window) {
    lazyloadImages = document.querySelectorAll(".lazy");
    var imageObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var image = entry.target;
          image.classList.remove("lazy");
          imageObserver.unobserve(image);
        }
      });
    });

    lazyloadImages.forEach(function (image) {
      imageObserver.observe(image);
    });
  } else {
    var lazyloadThrottleTimeout;
    lazyloadImages = document.querySelectorAll(".lazy");

    function lazyload() {
      if (lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
      }

      lazyloadThrottleTimeout = setTimeout(function () {
        var scrollTop = window.pageYOffset;
        lazyloadImages.forEach(function (img) {
          if (img.offsetTop < (window.innerHeight + scrollTop)) {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
          }
        });
        if (lazyloadImages.length == 0) {
          document.removeEventListener("scroll", lazyload);
          window.removeEventListener("resize", lazyload);
          window.removeEventListener("orientationChange", lazyload);
        }
      }, 20);
    }

    document.addEventListener("scroll", lazyload);
    window.addEventListener("resize", lazyload);
    window.addEventListener("orientationChange", lazyload);
  }
})


document.addEventListener("DOMContentLoaded", function () {
  var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));

  if ("IntersectionObserver" in window) {
    var lazyVideoObserver = new IntersectionObserver(function (entries, observer) {
      entries.forEach(function (video) {
        if (video.isIntersecting) {
          for (var source in video.target.children) {
            var videoSource = video.target.children[source];
            if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
              videoSource.src = videoSource.dataset.src;
            }
          }

          video.target.load();
          video.target.classList.remove("lazy");
          lazyVideoObserver.unobserve(video.target);
        }
      });
    });

    lazyVideos.forEach(function (lazyVideo) {
      lazyVideoObserver.observe(lazyVideo);
    });
  }
});


function getUrlParameter(sParam) {
  var sPageURL = window.location.search.substring(1),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
}

jQuery(window).on('resize', function(){
    mobileMenu();
});

function mobileMenu() {
  if (jQuery(window).width() <= 992) {
    jQuery("ul#menu-main-menu-1 .btn_curved1>a").attr('href', '#');
    jQuery("ul#menu-main-menu-1 .btn_curved1>a").attr('id', 'header_button_curverd');
    jQuery("ul#menu-main-menu-1 .btn_curved1>a").insertAfter('a.x-brand.img');
    /*jQuery("ul#menu-main-menu-1 .btn_curved1").remove();*/
    /*jQuery('#x-nav-wrap-mobile>ul>li.btn_curved1').hide();*/

    var top_menu = jQuery('.custtom_top_menu_section.top_mob ul#menu-top-menu').html();
    jQuery("ul#menu-main-menu-1").append(top_menu);
    jQuery('.custtom_top_menu_section.top_mob').remove();
    var contact_sub_menu = jQuery('#x-nav-wrap-mobile').html();
    if(jQuery('.x-navbar .x-navbar-inner .x-container .menu_hidden').length == 0) {
      jQuery('.x-navbar .x-navbar-inner .x-container').append('<div class="menu_hidden x-nav-wrap mobile">' + contact_sub_menu + '</div>');
    }
  }
}

jQuery('body').on('click', 'a#header_button_curverd', function (e) {
  e.preventDefault();
  if (!jQuery('#x-nav-wrap-mobile').hasClass('x-collapsed')) {
    jQuery('a#x-btn-navbar[aria-controls="x-nav-wrap-mobile"]').trigger('click');
  }
  jQuery('.menu_hidden>ul').css('visibility', 'visible');
  jQuery('.menu_hidden>ul>li.btn_curved1').toggle();
});
jQuery('body').on('click', 'a#x-btn-navbar', function (e) {
  jQuery('.menu_hidden>ul>li.btn_curved1').hide();
});