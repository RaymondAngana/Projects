// source: https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent
(function() {
  if (typeof window.CustomEvent === 'function') return false

  function CustomEvent(event, params) {
    params = params || { bubbles: false, cancelable: false, detail: undefined }
    var evt = document.createEvent('CustomEvent')
    evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail)
    return evt
  }

  CustomEvent.prototype = window.Event.prototype

  window.CustomEvent = CustomEvent
})()

// import external dependencies
import 'jquery';
import 'slick-carousel';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import singlePost from './routes/singlePost';
import category from './routes/category';
import searchResults from './routes/searchResults';
import singleGhResources from './routes/singleGhResources';

/** Populate Router instance with DOM routes */
const routes = new Router({
  common,
  singlePost,
  category,
  searchResults,
  singleGhResources,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
