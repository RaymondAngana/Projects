import {initSlider, initFetureSlider, initWebinarSlider} from './app';


showFilter();
showFilterMobile();
(function($) {
  const filterBtn = document.querySelector('.js-filter-drop');
  const filterContent = document.querySelector('.js-filter-content');
  if (!filterBtn) return;

  const category = $('.resourses-filter .menu > li > ul > li:not(.no-filter) > a');
  const categoryAll = $('.resourses-filter .menu > li > ul > li.no-filter > a');
  if (!category) return;

  let data = {
    industries: [],
    roles: [],
    contentTypes: []
  };
  setInitialData();
  getInitialContent();

  const breadcrumbsContainer = $('.resourses-filter__top .resourses-filter__active');
  const featuredMain = $('.resourses__featured');
  const featuredSection = $('.resourses__featured .appen-wrap');
  const cardsSection = $('.resourses__cards-wrap');  
  let featuredContent = '';
  let cardsContent = '';
  const resetButton = $('.js-reset-filter');

  resetButton.on('click', resetFilters);
  categoryAll.on('click', function(e) {
    e.preventDefault();
    resetFilters();
    breadcrumbsContainer.css('display', 'block');
    breadcrumbsContainer.html('All Resources');
  });
  category.on('click', handleCategories);

  function setInitialData() {
    const filtered = $('.resourses-filter .menu > li > ul > li:not(.no-filter) > a.filtered');
    if (!filtered.length) return;
    const slug = $(filtered).attr('data-category');
    const name = $(filtered).text();
    let mainCategory = toCamelCase($(filtered).closest('.sub-menu').siblings('a').attr('data-category'));
    data[mainCategory].push({ name: name, slug: slug });

    const crumbs = $('.resourses-filter__top .resourses-filter__active span');
    $(crumbs).on('click', handleBreadcrumbs);
  }

  function setBreadcrumbs() {
    if (calcDataLength() === 0) {
      breadcrumbsContainer.css('display', 'none');
      return;
    }
    breadcrumbsContainer.css('display', 'block');
    breadcrumbsContainer.html('');
    Object.keys(data).map(key => {
      data[key].map(function(el) {
        const crumb = document.createElement('SPAN');
        $(crumb).text(el.name);
        $(crumb).attr('data-category', el.slug);
        $(crumb).on('click', handleBreadcrumbs);
        $(breadcrumbsContainer).append(crumb);
      });
    });
  }

  function handleBreadcrumbs() {
    hideFilterMenu();
    const slug = $(this).attr('data-category');
    Object.keys(data).map(key => {
      data[key] = data[key].filter(el => {
        return el.slug !== slug;
      });     
    });
    $(this).remove();
    $(`.resourses-filter .menu > li > ul a[data-category=${slug}]`).removeClass('filtered');
    if (calcDataLength() === 0) {
      setBreadcrumbs();
      putInitialContent();
      return;
    }
    getFilteredPosts();
    return;
  }

  function handleCategories(e) {
    e.preventDefault();
    hideFilterMenu();
    const self = $(this);
    const slug = $(this).attr('data-category');
    const name = $(this).text();
    let mainCategory = toCamelCase($(this).closest('.sub-menu').siblings('a').attr('data-category'));
    let isChecked = false;
    Object.keys(data).map(key => {
      data[key].map(el => {
        if (el.slug === slug) {
          isChecked = true;
        };
      });      
    });

    if (isChecked) {
      self.removeClass('filtered');
      self.closest('li').removeClass('current-menu-item');
      data[mainCategory] = data[mainCategory].filter(el => {
        return el.slug !== slug;
      });
      if (calcDataLength() === 0) {
        setBreadcrumbs();
        putInitialContent();
        return;
      }
      getFilteredPosts();
      return;
    }
    self.addClass('filtered');
    data[mainCategory].push({ name: name, slug: slug });
    setBreadcrumbs();
    getFilteredPosts();
  }
  
  function resetFilters() {
    data = {
      industries: [],
      roles: [],
      contentTypes: []
    };
    category.removeClass('filtered');
    hideFilterMenu();
    setBreadcrumbs();
    putInitialContent();
  }

  function getFilteredPosts() {
    setBreadcrumbs();
    if (calcDataLength() < 2) {
      $.ajax({
        url: ajaxUrl,
        type: 'post',
        data: {
          action: 'get_featured_posts',
          categories: data
        },
        beforeSend: function() {
          showLoading();
        },
        success: function(response) {
          if (!response) {
            featuredMain.addClass('hidden');
            hideLoading();
            return;
          }
          featuredMain.removeClass('hidden');
          featuredMain.removeClass('transparent');
          putContent(response, featuredSection);
          reloadSliders();
          hideLoading();
        }
      });
    }
    if (calcDataLength() > 1) featuredMain.addClass('hidden');
    $.ajax({
      url: ajaxUrl,
      type: 'post',
      data: {
        action: 'get_all_resources',
        categories: data
      },
      beforeSend: function() {
        showLoading();
      },
      success: function(response) {
        putContent(response, cardsSection);
        reloadSliders();
        hideLoading();
      }
    });
  }

  function calcDataLength() {
    let length = 0;
    Object.keys(data).map(key => {
      return length += data[key].length;
    });
    return length;
  }
  function hideFilterMenu() {
    filterContent.classList.remove('js-show');
    filterBtn.classList.remove('js-open');
  }
  function putContent(content, section) {
    section.removeClass('transparent');
    section.html(content);
  }
  function showLoading() {
    featuredMain.addClass('transparent');
    cardsSection.addClass('transparent');
    const crumbs = $('.resourses-filter__top .resourses-filter__active span');
    crumbs.addClass('loading');
    category.addClass('loading');
  }
  function hideLoading() {
    const crumbs = $('.resourses-filter__top .resourses-filter__active span');
    crumbs.removeClass('loading');
    category.removeClass('loading');
  }
  function getInitialContent() {
    $.ajax({
      url: ajaxUrl,
      type: 'post',
      data: {
        action: 'get_initial_featured_posts'
      },
      success: function(response) {
        featuredContent = response;
      }
    });
    $.ajax({
      url: ajaxUrl,
      type: 'post',
      data: {
        action: 'get_all_initial_resources'
      },
      success: function(response) {
        cardsContent = response;
      }
    });
  }
  function putInitialContent() {
    featuredMain.removeClass('hidden');
    featuredMain.removeClass('transparent');
    putContent(featuredContent, featuredSection);
    putContent(cardsContent, cardsSection);
    reloadSliders();
  }
  function toCamelCase(str) {
    return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
      return index === 0 ? word.toLowerCase() : word.toUpperCase();
    }).replace(/(-|\s)+/g, '');
  }
})(jQuery);


function toggleStyle(el, styleName, value) {
  if (el.style[styleName] !== value) {
    el.style[styleName] = value;
  } else {
    el.style[styleName] = '';
  }
}

function showFilter() {
  const filterBtn = document.querySelector('.js-filter-drop');
  const filterContent = document.querySelector('.js-filter-content');
  const filterActive = document.querySelector('.resourses-filter__active');

  if (!filterBtn) return;

  document.querySelector('.resourses-filter').addEventListener('mouseover', function(e) {
    const crumbs = document.querySelectorAll('.resourses-filter__active span');
    let isOnCrumb = false;
    crumbs.forEach(el => {
      if (e.target === el) isOnCrumb = true;
    });
    if (e.target === filterActive || isOnCrumb) return;
    filterContent.classList.add('js-show');
    filterBtn.classList.add('js-open');
  });
  document.querySelector('.resourses-filter').addEventListener('mouseout', function() {
    filterContent.classList.remove('js-show');
    filterBtn.classList.remove('js-open');
  });
  if (!filterActive) return;
  filterActive.addEventListener('mouseover', function() {
    filterContent.classList.remove('js-show');
    filterBtn.classList.remove('js-open');
  });
}

function showFilterMobile() {
  const filterContainer = document.querySelector('.resourses-filter');
  if (!filterContainer) return;
  const filterMenuItems = filterContainer.querySelectorAll('.menu-item-has-children > a');

  if (!filterContainer && window.innerWidth >= 768) return;

  Array.from(filterMenuItems).forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();
      this.classList.toggle('js-open');
      const parent = this.closest('li');
      const submenu = parent.querySelector('.sub-menu');
      const submenuHeight = submenu.scrollHeight;
      toggleStyle(submenu, 'max-height', submenuHeight + 'px');
    });
  });
};

function reloadSliders() {
  initSlider();
  initWebinarSlider();
  initFetureSlider();
}

  
  //trigger Resource center filtres//
  function triggerFilter() {
    const ResourceFilterLink = document.querySelectorAll('.js-filter-content .sub-menu a');

    if (ResourceFilterLink) {
        Array.from(ResourceFilterLink).forEach(el => {
          el.addEventListener('click', function() {
              woopra.track("ai_resource_center_filter", {
                category : el.innerText
              });
          });
        })
    }
  }

  triggerFilter();
	
  

