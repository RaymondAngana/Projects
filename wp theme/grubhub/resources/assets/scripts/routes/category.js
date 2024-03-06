export default {
	init() {
    // Scroll to post feed
    $('html,body').animate({scrollTop: $('.blog-wrap').offset().top - 75}, 1000);
    if (window.matchMedia("(max-width: 1023px)").matches) {
      var selected = sessionStorage.getItem('active');  
      $('#categories-mob').val(selected);
      $('html,body').animate({scrollTop: $('.card-col:first-of-type').offset().top - 75}, 1000);
    }
  },
  finalize() {
  },
};
