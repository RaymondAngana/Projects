function initSliderOrange() {
  const orangeSlider = document.querySelector('.orange-slider');

  if (!orangeSlider) return;

  class SliderOrange {
    constructor(elem) {
      this.slider = null;
      this.elem = elem;
    }

    init() {
      if (this.slider) this.slider.destroy();
      this.slider = new Swiper(this.elem, {
        allowTouchMove: false,
        speed: 600,
        navigation: {
          nextEl: '.orange-next-btn',
          prevEl: '.orange-prev-btn'
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'fraction'
        },
        keyboard: {
          enabled: true
        }
      });
    }

    initMobile() {
      if (this.slider) this.slider.destroy();
      this.slider = new Swiper(this.elem, {
        allowTouchMove: true,
        speed: 600,
        navigation: {
          nextEl: '.orange-next-btn.orange-next-btn--mobile',
          prevEl: '.orange-prev-btn.orange-prev-btn--mobile'
        },
        pagination: {
          el: '.swiper-pagination.swiper-pagination--mobile',
          type: 'fraction'
        }
      });
    }
  }

  const desktop = window.matchMedia('(max-width: 1023px)');
  const swiperOrange = new SliderOrange(orangeSlider);

  function removeArrows() {
    if (orangeSlider.querySelectorAll('.swiper-slide').length < 2) {
      const pagintaion = document.querySelectorAll('.js-orange-pag');
      Array.from(pagintaion).forEach(item => {
        item.style.display = 'none';
      });
    }
  }

  function mediaChangeHandler(mediaQuery) {
    if (mediaQuery.matches) {
      return swiperOrange.initMobile();
    }
    return swiperOrange.init();
  }

  desktop.addListener(mediaChangeHandler); // Attach listener function on state changes
  mediaChangeHandler(desktop); // Call listener function at run time
  removeArrows();
}

function initNewsSlider() {
  const newsSliderSection = document.querySelectorAll(
    '.js-news-slider-section'
  );
  if (newsSliderSection.length < 1) return;

  let swiperItem = [];

  Array.from(newsSliderSection).forEach(function(item, index) {
    const sliderContainer = item.querySelector('.news-slider');
    const nextBtn = item.querySelector('.js-latest-next-btn');
    const prevBtn = item.querySelector('.js-latest-prev-btn');

    swiperItem[index] = new Swiper(sliderContainer, {
      speed: 600,
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn
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
    if (swiperItem[index].slides.length <= 3) {
      const sliderBtn = item.querySelectorAll('.slider-latest-btn');
      Array.from(sliderBtn).forEach(btnItem => {
        btnItem.classList.add('js-hide');
      });
    }
  });
}

function initAwardsSlider() {
  const awardsSlider = document.querySelector('.awards-slider');
  if (!awardsSlider) return;

  const nextBtn = awardsSlider.previousElementSibling.querySelector('.js-latest-next-btn');
  const prevBtn = awardsSlider.previousElementSibling.querySelector('.js-latest-prev-btn');

  let slider = new Swiper(awardsSlider, {
    speed: 600,
    navigation: {
      nextEl: nextBtn,
      prevEl: prevBtn
    },
    loop: false,
    keyboard: {
      enabled: true
    },
    slidesPerView: 4,
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 0,
        allowTouchMove: true
      },
      425: {
        slidesPerView: 2,
        spaceBetween: 0
      },
      1024: {
        slidesPerView: 3,
        allowTouchMove: false
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 0
      }
    }
  });
}

window.onload = function() {
  initSliderOrange();
  initNewsSlider();
  initAwardsSlider();
};
