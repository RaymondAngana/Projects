import { gsap } from "gsap"
import { ScrollTrigger } from "gsap/ScrollTrigger"
gsap.registerPlugin(ScrollTrigger);

export default {
  init() {

    // Add .nav-scroll to any link you want to create a smooth scroll on
    $('.nav-scroll').click(function() {
      if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
        if (target.length) {
          if (window.matchMedia("(max-width: 1023px)").matches) {
            $('html,body').animate({scrollTop: target.offset().top - 55}, 1000);
            return false;
          } else {
            $('html,body').animate({scrollTop: target.offset().top - 80}, 1000);
          }
        }
      }
    });

    // Init For Bug
    let bug = gsap.timeline({
      scrollTrigger: {
        trigger: '#bug-trigger',
        start: 'top 5%',
        end: 'center top',
        scrub: true,
      },
    })
    bug.to('.bug', {x: -100, duration: 1, ease: 'power4.out'})

    // accessibility toggles for mega nav toggle
    // mega nav show/hide toggle
    $('.nav-tl').on('click', function(event) {
      if ($(this).attr('href') === '#') {
        event.preventDefault();
        if ($(this).next().attr('aria-hidden') === 'true') {
          $(this).next().attr('aria-hidden', 'false');
        } else {
          $(this).next().attr('aria-hidden', 'true');
        }
      }
      if ($(this).hasClass('active')) {
        $('.bug').addClass('buried');
      } else {
        $('.bug').removeClass('buried');
      }
      $('.bug').addClass('buried');
      $(this).toggleClass('active');
      $(this).next().toggleClass('open');
      $(this).parent().siblings().children().removeClass('active');
      $(this).parent().siblings().children().next().removeClass('open');
      $('.close-search').removeClass('show');
    });

    $('.wrap.container').on('click', function() {
      $('.mega-dd').removeClass('open');
      $('.nav-tl').removeClass('active');
    });

    // Mobile Nav
    $('.hamburger').on('click', function(event) {
      $('.top-bar').toggleClass('mob-open');
      $(this).toggleClass('is-active');
      $('.close-search').trigger('click');
      $('.bug').toggleClass('buried');
      $('.mega-dd').removeClass('open');
      $('.nav-tl').removeClass('active');
      if ($(window).width() < 1024) {
        $('.wrap.container').toggleClass('locked-mob');
        $('body').toggleClass('fixed');
      }

      if ($(this).hasClass('is-active')) {
        $('.faux-bg').addClass('show-faux');
      } else {
        $('.faux-bg').removeClass('show-faux');
      }

      let vh = window.innerHeight * 0.01;
      document.documentElement.style.setProperty('--vh', `${vh}px`);

      event.preventDefault();
    });
    // search box show/hide toggle
    $('.search-main').on('click', function(event) {
      event.preventDefault();
      $(this).next().toggleClass('open');
      $(this).parent().siblings().children().removeClass('active');
      $(this).parent().siblings().children().next().removeClass('open');
      $('.close-search').toggleClass('show');
      setTimeout(function() {
        $('.search-wrap-box input[type="search"]').focus();
      }, 300)
    });

    $('.close-search').on('click', function(event) {
      $('.search-drop').removeClass('open');
      $('.close-search').removeClass('show');
      $(this).next().removeClass('show');
      event.preventDefault();
    });

    // Video Carousel Slider

    $('.slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      infinite: true,
      cssEase: 'linear',
      arrows: true,
      prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fal fa-arrow-left' aria-hidden='true'></i></button>",
      nextArrow:"<button type='button' class='slick-next pull-right'><i class='far fa-arrow-right' aria-hidden='true'></i></button>" ,
      responsive: [
      {
        breakpoint: 1024,
        settings: {
          dots: true,
        }
      }
      ]
    });


    // Make video accessible with spacebar
    window.addEventListener('keydown', function(event) {
      if ($('.videoplay').is(':focus') && event.keyCode === 32) {
        event.preventDefault();
        $('.videoplay').trigger('click');
        setTimeout(function() {
          $('.videoplay').prev().focus();
        }, 200);
      }
    })

    // Envoke Youtube API

    var tag = document.createElement('script');
    var player;
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    function onYouTubeIframeAPIReady(yt_id, iframe_id) {
      player = new YT.Player(iframe_id, {
        videoId: yt_id,
        playerVars: { 'autoplay': 1, 'playsinline': 1 },
        events: {
          'onReady': onPlayerReady,
        },
      });
    }

    function onPlayerReady(event) {
      event.target.setVolume(70);
      event.target.playVideo();
      videoPlaying = true;
    }

    function stop() {
      player.pauseVideo();
    }

    // Play Video

    $('.videoplay').on('click', function(e) {
      e.preventDefault();
      var div_iframe  = $(this).prev().attr('id');
      var url  = $(this).prev().attr('src');
      var yt_id       = $('#' + div_iframe).data('yt');
      $(this).css('display', 'none');
      $(this).prev().css('display', 'block');
      // Tracking
      utag_data['eventcategory'] = 'video';
      utag_data['eventaction'] = 'play_cta';
      utag_data['eventlabel'] = url;
      utag.link(url);
      onYouTubeIframeAPIReady(yt_id, div_iframe);
    });

    let videoPlaying = false;

    $('.slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
      if (videoPlaying) {
        stop();
        let video = slick.$slides[currentSlide];
      }
    });

    // Remove native anchor for the bug
    $('.bug').on('click', function(event) {
      event.preventDefault();
    });

    // Grid Cards Animation
    let cardArray = gsap.utils.toArray('.gh-cards');
    cardArray.forEach((card, i) => {
      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: card,
          start: 'top center',
        },
      })
      tl.to(card.querySelectorAll('.card-anim'), {y: 0, opacity: 1, duration: 1.2, ease: 'power4.out', stagger: {amount: 0.55}}, '-=0.5')
    });


    // Marquee Form Animation
    ScrollTrigger.saveStyles(".marq-col-content, .column-form, #curve_overlay");
    ScrollTrigger.matchMedia({
      // desktop
      "(min-width: 1024px)": function() {
        const anim = gsap.utils.toArray('.marq-anim')
        if (anim.length > 0){
          let marq = gsap.timeline({
            scrollTrigger: {
              trigger: '.marq-anim',
              start: 'top center',
            },
          })
          marq.to('#curve_overlay', {y: 0, opacity: 1, duration: 1.5, ease: 'power4.out'})
          .to('.marq-col-content', {y: 0, opacity: 1, duration: .5, ease: 'power4.out' }, '-=0.5')
          .to('.column-form', {y: 0, opacity: 1, duration: .5, ease: 'power4.out' }, '-=0.25');
        }
      },

      "(max-width: 1023px)": function() {
        const anim = gsap.utils.toArray('.marq-anim')
        if (anim.length > 0){
          let marq = gsap.timeline({
            scrollTrigger: {
              trigger: '.marq-anim',
              start: 'top 70%',
            },
          })
          marq.to('#curve_overlay', {y: 0, opacity: 1, duration: 1.5, ease: 'power4.out'})
          .to('.marq-col-content', {y: 0, opacity: 1, duration: 1, ease: 'power4.out' }, '-=0.5')
          .to('.column-form', {y: 0, opacity: 1, duration: .5, ease: 'power4.out' }, '-=0.5');
        }
      },
    });

    let featureSplitArray = gsap.utils.toArray('.feature-split-flushed');
    let fhs_anim = gsap.utils.toArray('.feature-split-flushed .card-anim');
    if (fhs_anim.length > 0) {
      featureSplitArray.forEach((features, i) => {
        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: features,
            start: 'top center',
          },
        })
        tl.to(features.querySelectorAll('.content-wrap'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(features.querySelectorAll('.image-holder'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(features.querySelector('.button'), { scale: 1.1, duration: 1, repeat: 1,  yoyo: true }, '-=0.5');
      });
    }

    let featureArray = gsap.utils.toArray('.feature-half');
    let fh_anim = gsap.utils.toArray('.feature-half .card-anim');
    if (fh_anim.length > 0) {
      featureArray.forEach((feature, i) => {
        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: feature,
            start: 'top center',
          },
        })
        tl.to(feature.querySelectorAll('.content-wrap'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(feature.querySelectorAll('.image-holder'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(feature.querySelector('.button'), { scale: 1.1, duration: 1, repeat: 1,  yoyo: true }, '-=0.5');
      });
    }

    let featureContArray = gsap.utils.toArray('.feature-contained-half');
    let fch_anim = gsap.utils.toArray('.feature-contained-half .card-anim');
    if (fch_anim.length > 0) {
      featureContArray.forEach((featurec, i) => {
        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: featurec,
            start: 'top center',
          },
        })
        tl.to(featurec.querySelectorAll('.content-wrap'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(featurec.querySelectorAll('.image-holder'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(featurec.querySelector('.button'), { scale: 1.1, duration: 0.3, repeat: 1,  yoyo: true }, '-=0.5');
      });
    }

    let featureUniqueArray = gsap.utils.toArray('.feature-unique-card');
    let fu_anim = gsap.utils.toArray('.feature-unique-card .card-anim');
    if (fu_anim.length > 0) {
      featureUniqueArray.forEach((featurec, i) => {
        let tl = gsap.timeline({
          scrollTrigger: {
            trigger: featurec,
            start: 'top center',
          },
        })
        tl.to(featurec.querySelectorAll('.content-wrap'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(featurec.querySelectorAll('.image-holder'), {opacity: 1, duration: 1, ease: 'power4.out'}, '-=0.5')
        .to(featurec.querySelector('.button'), { scale: 1.1, duration: 0.3, repeat: 1,  yoyo: true }, '-=0.5');
      });
    }

    $('.multi-view .button-and-image > span').bind('click keypress', function () {
      var $target = $(this).parent();
      gsap.to($target, {
        opacity: 0,
        x: 1000,
        duration: 1,
      });
      $(this).trigger('blur').removeAttr('tabindex');
    });


    var $cats = $('#categories-mob');
    $($cats).on('change', function(event) {
      let selected = $(this).val();
      sessionStorage.setItem('active', selected);
      window.location = $cats.val();
    });

    // Tracking

    $('.accordion-title').on('click', function() {
      if ($(this).parent().hasClass('is-active')) {
        let val = ($(this).text());
        utag_data['eventcategory'] = 'faq';
        utag_data['eventaction'] = 'expand_cta';
        utag_data['eventlabel'] = val;
        utag.link(utag_data);
      }
    });

    $('.top-bar ul li a').on('click', function() {
      let val = ($(this).text());
      utag_data['eventcategory'] = 'header';
      utag_data['eventaction'] = 'header link_cta';
      utag_data['eventlabel'] = val;
      utag.link(utag_data);
    });
    
    $('a[target="_blank"]' && 'a:not([href*="restaurant.grubhub.com"])').on('click', function(event) {
      let val = ($(this).attr('href'));
      utag_data['eventcategory'] = 'outbound link';
      utag_data['eventaction'] = 'outbound link_cta';
      utag_data['eventlabel'] = val;
      utag.link(utag_data);
    });

    var getScrollPercent = function() {
      var winHeight = $(window).height();
      var docHeight = $(document).height();
      var scrollTop = $(window).scrollTop();
      var trackLength = docHeight - winHeight;
      var pctScrolled = Math.floor(scrollTop/trackLength * 100);
      return pctScrolled;
    }

    $(document).scroll(function() {
      if (getScrollPercent() === 25) {
        utag_data['eventcategory'] = 'page scroll';
        utag_data['eventaction'] = 'page scroll_depth';
        utag_data['eventlabel'] = 25;
        utag.link(utag_data);
      } else if (getScrollPercent() === 50) {
        utag_data['eventcategory'] = 'page scroll';
        utag_data['eventaction'] = 'page scroll_depth';
        utag_data['eventlabel'] = 50;
        utag.link(utag_data);
      } else if (getScrollPercent() === 75) {
        utag_data['eventcategory'] = 'page scroll';
        utag_data['eventaction'] = 'page scroll_depth';
        utag_data['eventlabel'] = 75;
        utag.link(utag_data);
      } else if (getScrollPercent() === 98) {
        utag_data['eventcategory'] = 'page scroll';
        utag_data['eventaction'] = 'page scroll_depth';
        utag_data['eventlabel'] = 100;
        utag.link(utag_data);
      }
    });

    // Blog Paged Scroll-To
    if ($('body').hasClass('blog') && $('body').hasClass('paged')) {
      $('html,body').animate({scrollTop: $('.blog-wrap').offset().top - 75}, 1000);
    }

    // Blog Paged Scroll-To
    if ($('body').hasClass('template-landing-page') && $('body').hasClass('paged')  || document.referrer.indexOf('/page/') > -1 && $('body').hasClass('template-landing-page')) {
      $('html,body').animate({scrollTop: $('.gh-cards').offset().top - 75}, 1000);
    }

    // Success Stories Paged Scroll-To
    if ($('body').hasClass('post-type-archive-gh_success') && $('body').hasClass('paged') || document.referrer.indexOf('/page/') > -1 && $('body').hasClass('post-type-archive-gh_success')) {
      $('html,body').animate({scrollTop: $('.blog-wrap').offset().top - 75}, 1000);
  }

    // Success Stories Paged Scroll-To
    if ($('body').hasClass('post-type-archive-gh_help_center') && $('body').hasClass('paged') || document.referrer.indexOf('/page/') > -1 && $('body').hasClass('post-type-archive-gh_help_center')) {
      $('html,body').animate({scrollTop: $('.blog-wrap').offset().top - 75}, 1000);
  }

    // Tag Template Paged Scroll-To
    if ($('body').hasClass('tag') && $('body').hasClass('paged')) {
      $('html,body').animate({scrollTop: $('.wrp').offset().top - 75}, 1000);
    }

    if (window.matchMedia("(min-width: 1024px)").matches) {
      let cardSets = $('.grid-cards').toArray();
      $(cardSets).each(function(index, el) {
        var height = 0;
        $(el).find('.even').height('auto');
        $(el).find('.even').each(function(index) {
          if ($(this).height() > height)
            height = $(this).height();
        });
        $(this).find('.even').height(height);
      });

      let sCardSets = $('.s-grid-cards').toArray();
      $(sCardSets).each(function(index, el) {
        var height = 0;
        $(el).find('.even').height('auto');
        $(el).find('.even').each(function(index) {
          if ($(this).height() > height)
            height = $(this).height();
        });
        $(this).find('.even').height(height);
      });
    }

    $('.page-numbers li a').each(function(index, el) {
      let val = $(this).text();
      $(this).attr('aria-label', 'Link, Page '+val); 
    });
    $('.left-rail table tbody tr td div a').each(function() {
      $(this).attr('href', $(this).attr('href').replace(/\s/g, "+"))
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};

