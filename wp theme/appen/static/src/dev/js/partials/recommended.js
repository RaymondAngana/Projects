import Swiper from 'swiper';
export default () => {
  class Slider {
    constructor(elem, slidesPerView) {
      this.slider = null;
      this.elem = elem;
      this.slidesPerView = slidesPerView;
    }

    init() {
      this.slider = new Swiper(this.elem, {
        speed: 400,
        loop: false,
        navigation: {
          prevEl: '.js-recommended-prev',
          nextEl: '.js-recommended-next'
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

  function initSlider(selector) {
    const resourseSlider = document.querySelectorAll(selector);

    if (!resourseSlider) return false;

    let resourseItem = new Slider(resourseSlider);
    function mediaChangeHandler(mediaQuery) {
      if (mediaQuery.matches) {
        return resourseItem.init();
      }
      return resourseItem.destroy();
    }
    const mediaDesktop = window.matchMedia('(max-width: 1023px)');
    mediaDesktop.addListener(mediaChangeHandler); // Attach listener function on state changes
    mediaChangeHandler(mediaDesktop); // Call listener function at run time
  }

  const webinarSlider = document.querySelector('.js-webinar-slider');
  if (webinarSlider) {
    initSlider('.js-webinar-slider');
    return;
  }
  initSlider('.js-recommended');
};
