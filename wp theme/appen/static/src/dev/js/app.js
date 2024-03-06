function initSlider() {
  const resourseSlider = document.querySelectorAll('.js-resourse-slider');

  if (!resourseSlider) return undefined;

  let resourseItem = [];

  Array.from(resourseSlider).forEach(function (item, index) {
    const resourseSlides = item.querySelectorAll('.swiper-slide');
    if (resourseSlides.length < 2) return;

    resourseItem[index] = new Slider(item);
    function mediaChangeHandler(mediaQuery) {
      if (mediaQuery.matches) {
        return resourseItem[index].init();
      }
      return resourseItem[index].destroy();
    }
    const mediaDesktop = window.matchMedia('(max-width: 1023px)');
    mediaDesktop.addListener(mediaChangeHandler); // Attach listener function on state changes
    mediaChangeHandler(mediaDesktop); // Call listener function at run time
  });
}
function initWebinarSlider() {
  const webinarBox = document.querySelector('.js-webinar-slider');
  const feature = new Swiper(webinarBox, {
    speed: 600,
    navigation: {
      nextEl: '.js-webinar-next',
      prevEl: '.js-webinar-prev'
    },
    loop: false,
    keyboard: {
      enabled: true
    },
    slidesPerView: 3,
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 0,
        allowTouchMove: true
      },
      576: {
        slidesPerView: 2,
        spaceBetween: 0
      },
      1024: {
        slidesPerView: 2,
        allowTouchMove: false
      },
      1200: {
        slidesPerView: 2,
        spaceBetween: 32
      }
    }
  });
}

function initFetureSlider() {
  const featureBox = document.querySelector('.js-feature-slider');
  const feature = new Swiper(featureBox, {
    speed: 600,
    navigation: {
      nextEl: '.js-alternative-next',
      prevEl: '.js-alternative-prev'
    },
    loop: false,
    keyboard: {
      enabled: true
    },
    slidesPerView: 3,
    breakpoints: {
      320: {
        slidesPerView: 'auto',
        spaceBetween: 0,
        allowTouchMove: true
      },
      425: {
        slidesPerView: 'auto',
        spaceBetween: 0
      },
      1024: {
        slidesPerView: 'auto',
        allowTouchMove: false
      },
      1200: {
        slidesPerView: 3,
        spaceBetween: 28
      }
    }
  });
}

class Slider {
  constructor(elem) {
    this.slider = null;
    this.elem = elem;
  }

  init() {
    if (this.elem.querySelectorAll('.swiper-slide') < 2) this.slider.destroy();
    this.slider = new Swiper(this.elem, {
      speed: 400,
      loop: false,
      navigation: {
        prevEl: '.js-resourses-prev',
        nextEl: '.js-resourses-next'
      },
      slidesPerView: 3,
      breakpoints: {
        320: {
          slidesPerView: 'auto',
          spaceBetween: 0,
          allowTouchMove: true
        },
        425: {
          slidesPerView: 'auto',
          spaceBetween: 0
        },
        1024: {
          slidesPerView: 'auto',
          allowTouchMove: false
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 28
        }
      }
    });
  }

  destroy() {
    if (this.slider) this.slider.destroy();
  }
}

export { initSlider, initFetureSlider, initWebinarSlider };

initSlider();
initFetureSlider();
initWebinarSlider();
