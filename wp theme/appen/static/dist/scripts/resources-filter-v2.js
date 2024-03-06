var sub_heading;
jQuery(document).ready(function() {
    sub_heading = jQuery('.sub-heading').text();
})
if (jQuery(window).width() >= 992) {
    jQuery('body').on('mouseover', '.resourses-filter__top:not(.search_active)', function() {
        jQuery(this).addClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').addClass('js-show');
    });
    jQuery('body').on('mouseout', '.resourses-filter__top:not(.search_active)', function() {
        jQuery(this).removeClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
    });
    jQuery('.js-filter-content').on('mouseover', function() {
        jQuery(this).closest('.resourses-filter').find('.js-filter-drop').addClass('js-open');
        jQuery(this).addClass('js-show');
    });
    jQuery('.js-filter-content').on('mouseout', function() {
        jQuery(this).closest('.resourses-filter').find('.js-filter-drop').removeClass('js-open');
        jQuery(this).removeClass('js-show');
    });
    jQuery('.custom_search_outer form input.frm_search').on('focusin', function() {
        jQuery('.resourses-filter__top').addClass('search_active');
        jQuery('.resourses-filter__top').removeClass('js-open');
        jQuery('.resourses-filter__top').closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
    });
    jQuery('.custom_search_outer form input.frm_search').on('focusout', function() {
        jQuery('.resourses-filter__top').removeClass('search_active');
    });
} else {
    jQuery('.js-filter-drop').on('click', function(e) {
        e.preventDefault();
        jQuery(this).toggleClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').toggleClass('js-show');
    });
    jQuery('.resourses-filter .menu>li.menu-item-has-children a').on('click', function(e) {
        e.preventDefault();
        jQuery(this).toggleClass('js-open');
        jQuery(this).closest('li.menu-item-has-children').toggleClass('sub-open');
    });
}
jQuery('.resourses-filter .menu>li>a').on('click', function(e) {
    e.preventDefault();
})
jQuery('.resourses-filter .menu>li>ul a').on('click', function(e) {
    e.preventDefault();
    var thisElem = jQuery(this);
    var name = jQuery(thisElem).text().trim();
    var cat = jQuery(thisElem).attr('data-category');
    jQuery('.resourses-filter__active').show();
    /*if(jQuery('.resourses-filter__search_bar').html() == '') {
    	jQuery('.resourses-filter__search_bar').html('<button class="resourses-filter__drop js-filter-drop search_result">Search results:</button>');
    }*/
    if (jQuery(thisElem).hasClass('filtered')) {
        //jQuery(thisElem).removeClass('filtered');
        /*jQuery('.resourses-filter .menu>li>ul a').each(function() {
        	jQuery(this).removeClass('filtered');
        })*/
        //jQuery('.resourses-filter__search_bar').find('span[data-category="'+cat+'"]').remove();
    } else {
        jQuery('.resourses-filter .menu>li>ul a').each(function() {
            jQuery(thisElem).removeClass('filtered');
        })
        jQuery(thisElem).addClass('filtered');
        //jQuery('.resourses-filter__active').html('');
        /*if (jQuery(".resourses-filter__search_bar").is(":visible") == true) {
        	jQuery('.resourses-filter__search_bar').append('<span class="category" data-category="'+cat+'" data-name="'+name+'">'+name+'</span>');
        } else {
        	jQuery('.resourses-filter__active').append('<span data-category="'+cat+'" data-name="'+name+'">'+name+'</span>');
        }*/
        jQuery('.resourses-filter__search_bar').append('<span class="category" data-category="' + cat + '" data-name="' + name + '">' + name + '</span>');
        //jQuery('.custom_searc_section').addClass('searched');
        /*jQuery('.resourses-filter__search_bar').show();
	            jQuery('.custom_search_outer form input').css('width', 'calc(100% - '+(jQuery('.resourses-filter__search_bar').width() + 45)+'px)');*/
    }
    if (jQuery(thisElem).closest('.resourses-filter').find('.resourses-filter__active span').length > 0) {
        jQuery(thisElem).closest('.resourses-filter').find('.js-reset-filter').show();
    }
    jQuery(thisElem).closest('.resourses-filter').find('.js-filter-drop').removeClass('js-open');
    jQuery(thisElem).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
    jQuery(thisElem).closest('.resourses-filter').find('.menu>li.menu-item-has-children a.js-open').removeClass('js-open');
    /*if ("ga" in window) {
        tracker = ga.getAll()[0];
        if (tracker)
            tracker.send("event", "Resource Filtering", jQuery(this).closest('li.menu-item-has-children').children('a').text(), name);
    }*/
    ajax_search();
});
jQuery('select[name="search_sort"]').on('change', function() {
    var termi = jQuery(this).find("option:selected").val();
    var flag = 0;
    jQuery('.resourses__featured-list > a').each(function() {
        if (jQuery(this).attr('data-' + termi) != '[]') {
            //var terms = JSON.parse(jQuery(this).attr('data-'+termi));
            jQuery(this).show();
            flag = flag + 1;
        } else {
            jQuery(this).hide();
        }
    })
    jQuery('.result-count').text(flag);
})

function filter_search() {
    if (jQuery('.resourses-filter__search_bar span.category').length > 0) {
        var flag = 0;
        jQuery('.resourses-filter__search_bar span.category').each(function() {
            var termi = jQuery(this).attr('data-category');
            jQuery('.resourses__featured-list > a').each(function() {
                var terms = JSON.parse(jQuery(this).attr('data-cats'));
                if (inArray(termi, terms)) {
                    jQuery(this).show();
                    flag = flag + 1;
                } else {
                    jQuery(this).hide();
                }
            })
            jQuery('.result-count').text(flag);
        })
    } else {
        jQuery('.resourses__featured-list > a').each(function() {
            jQuery(this).show();
        })
    }
    /*if (jQuery(".resourses-filter__search_bar").is(":visible") == true) {
    	if(jQuery('.resourses-filter__search_bar span.category').length > 0) {
    		var flag = 0;
    		jQuery('.resourses-filter__search_bar span.category').each(function() {
    			var termi = jQuery(this).attr('data-category');
    			jQuery('.resourses__featured-list > a').each(function() {
    				var terms = JSON.parse(jQuery(this).attr('data-cats'));
    				if(inArray(termi, terms)) {
    					jQuery(this).show();
    					flag = flag + 1;
    				} else {
    					jQuery(this).hide();
    				}
    			})	
    			jQuery('.result-count').text(flag);			
    		})
    	} else {
    		jQuery('.resourses__featured-list > a').each(function() {
    			jQuery(this).show();
    		})
    	}
    } else {
    	if(jQuery('.resourses-filter__active span').length > 0) {
    		var flag = 0;
    		jQuery('.resourses-filter__active span').each(function() {
    			var termi = jQuery(this).attr('data-category');
    			jQuery('.resourses__featured-list > a').each(function() {
    				var terms = JSON.parse(jQuery(this).attr('data-cats'));
    				if(inArray(termi, terms)) {
    					jQuery(this).show();
    					flag = flag + 1;
    				} else {
    					jQuery(this).hide();
    				}
    			})	
    			jQuery('.result-count').text(flag);			
    		})
    	} else {
    		jQuery('.resourses__featured-list > a').each(function() {
    			jQuery(this).show();
    		})
    	}
    }*/
}
jQuery('body').on('click', '.resourses-filter__active span', function(e) {
    e.preventDefault();
    var thisElem = jQuery(this);
    var name = jQuery(this).attr('data-name');
    var cat = jQuery(this).attr('data-category');
    jQuery(this).closest('.resourses-filter').find('.menu>li>ul a').each(function() {
        if (jQuery(this).attr('data-category') == cat && jQuery(this).text().trim() == name) {
            jQuery(this).removeClass('filtered');
        }
    });
    if (jQuery(window).width() < 992) {
        jQuery('.resourses-filter').find('.menu>li>ul a').each(function() {
            if (jQuery(this).attr('data-category') == cat && jQuery(this).text().trim() == name) {
                jQuery(this).removeClass('filtered');
            }
        });
    }
    jQuery(thisElem).remove();
    ajax_search();
});
jQuery('body').on('click', '.js-reset-filter', function(e) {
    e.preventDefault();
    var thisElem = jQuery(this);
    jQuery(this).closest('.resourses-filter').find('.menu>li>ul a').each(function() {
        jQuery(this).removeClass('filtered');
    })
    jQuery(thisElem).closest('.resourses-filter').find('.resourses-filter__search_bar').html('');
    jQuery('.frm_search').val('');
    jQuery('.custom_searc_section').removeClass('searched');
    if (jQuery(window).width() < 992) {
        jQuery(this).removeClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
    }
    ajax_search();
});

function inArray(needle, hatstack) {
    if (hatstack.length) {
        if (hatstack.includes(needle)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

jQuery('body').on('submit', '.custom_searc_section', function(e) {
    e.preventDefault();
    ajax_search();
    //jQuery('.frm_search_holder').val(jQuery('.frm_search').val());
    //jQuery('<a class="clear_search" href="#"><i class="la la-times" aria-hidden="true"></i></a>').insertAfter(jQuery(this).find('.frm_search'));
    if (jQuery(this).find('.frm_search').val() != '') {
        if (!jQuery(this).hasClass('searched')) {
            jQuery(this).addClass('searched');
            if ("ga" in window) {
                tracker = ga.getAll()[0];
                if (tracker)
                    tracker.send("event", "Resource Search", "Search", jQuery(this).find('.frm_search').val());
            }
            /*if(jQuery('.resourses-filter__search_bar').html() == '') {
            	jQuery('.resourses-filter__search_bar').html('<button class="resourses-filter__drop js-filter-drop search_result">Search results:</button>');
            }
            jQuery('.resourses-filter__search_bar').append('<span class="text_search">'+jQuery(this).find('.frm_search').val()+'</span>');*/
            /*jQuery('.resourses-filter__search_bar').css('display', 'inline-block');
            jQuery('.custom_search_outer form input').css('width', 'calc(100% - '+(jQuery('.resourses-filter__search_bar').width() + 45)+'px)');*/
        } else {
            /*if(jQuery('.resourses-filter__search_bar span').length <= 0) {
			            jQuery(this).removeClass('searched');
			        }
		            jQuery('.resourses-filter__search_bar .text_search').text('');
		            jQuery('.resourses-filter__search_bar').prepend('<span class="text_search">'+jQuery(this).find('.frm_search').val()+'</span>');
		            jQuery('.resourses-filter__search_bar .resourses-filter__drop').remove();
		            if(jQuery('.resourses-filter__search_bar .resourses-filter__drop').length <= 0) {
		            	jQuery('.resourses-filter__search_bar').prepend('<button class="resourses-filter__drop js-filter-drop search_result">Search results:</button>');
		            }*/
            /*jQuery('.resourses-filter__search_bar').css('display', 'inline-block');
            jQuery('.custom_search_outer form input').css('width', 'calc(100% - '+(jQuery('.resourses-filter__search_bar').width() + 45)+'px)');*/
            jQuery(this).find('.frm_search').val('');
            jQuery(this).removeClass('searched');
        }
    }
});
jQuery('body').on('click', '.resourses-filter__search_bar span', function(e) {
    e.preventDefault();
    var thisElem = jQuery(this);
    if (jQuery(thisElem).hasClass('text_search')) {
        jQuery('.frm_search_holder').val(jQuery('.frm_search').val());
    }
    if (jQuery(thisElem).hasClass('category')) {
        /*jQuery('.custom_searc_section').removeClass('searched');
	            jQuery('.custom_searc_section').find('.frm_search').val('');
	            jQuery('.resourses-filter__search_bar').hide();*/
        var name = jQuery(thisElem).attr('data-name');
        var cat = jQuery(thisElem).attr('data-category');
        jQuery(thisElem).closest('.resourses-filter').find('.menu>li>ul a').each(function() {
            if (jQuery(this).attr('data-category') == cat) {
                jQuery(this).removeClass('filtered');
            }
        });
    }
    jQuery(thisElem).remove();
    //jQuery('.custom_search_outer form input').css('width', 'calc(100% - '+(jQuery('.resourses-filter__search_bar').width() + 45)+'px)');
    if (jQuery('.resourses-filter__search_bar span').length <= 0) {
        jQuery('.resourses-filter__search_bar').html('');
        //jQuery('.custom_searc_section').find('.frm_search').val('');
        //jQuery('.resourses-filter__search_bar').hide();
        //jQuery('.custom_searc_section').removeClass('searched');
        //jQuery('.custom_search_outer form input').css('width', '100%');
    }
    ajax_search();
});

function ajax_search() {
    var cats = [];
    jQuery(".ajax_load_posts").remove();
    if (jQuery('.resourses-filter__active span').length > 0) {
        jQuery('.resourses-filter__active span').each(function() {
            //cats = cats + ',' + jQuery(this).attr('data-category');
            cats.push(jQuery(this).attr('data-category'));
            if (jQuery(".resourses-filter__search_bar").is(":visible") == true) {
                jQuery('.resourses-filter__search_bar').append('<span class="category" data-category="' + jQuery(this).attr('data-category') + '" data-name="' + jQuery(this).attr('data-name') + '">' + jQuery(this).attr('data-name') + '</span>');
                jQuery(this).remove();
            }
        })
    } else {
        jQuery('.resourses-filter__search_bar span.category').each(function() {
            cats.push(jQuery(this).attr('data-category'));
        })
    }
    var search_tem = jQuery('.frm_search').val();
    //jQuery('.frm_search').val('');
    if (search_tem != '') {
        jQuery('.custom_searc_section button').addClass('loading');
    }
    jQuery.ajax({
        url: CustomVar.ajaxurl,
        type: 'post',
        dataType: 'json',
        data: {
            action: 'get_searched_resources',
            resources_search: search_tem,
            resources_cats: cats,
            resources_sort: jQuery('.search-result .search-meta select').find(":selected").val()
        },
        success: function(data, textStatus, jQxhr) {
            if (search_tem != '') {
                jQuery('.sub-heading').html('Search Results for: <strong>' + search_tem + '</strong>');
            } else {
                jQuery('.sub-heading').html(sub_heading);
            }
            jQuery('.result-count').text(data.count);
            jQuery('.filtered-title').html(data.title);
            jQuery('.resourses__cards-wrap .resourses__featured-list').html(data.html);
            //console.log(data.featured);
            if (data.featured == '') {
                jQuery('.resourses__featured').hide();
            } else {
                jQuery('.resourses__featured .appen-wrap').html(data.featured);
                jQuery('.resourses__featured').show();
            }
            jQuery('select[name="search_sort"]').prop('selectedIndex', 0);
            jQuery('.resourses-filter__top').removeClass('search_active');
            //filter_search();
            jQuery('.custom_searc_section button').removeClass('loading');
            if (search_tem != '') {
                jQuery('<a class="clear_search" href="#"><i class="la la-times" aria-hidden="true"></i></a>').insertAfter(jQuery('.custom_searc_section .frm_search'));
            }
        },
        error: function(jqXhr, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}


jQuery(function($) {
    $.fn.isInViewport = function() {
        var property;
        if ($(this).offset()) {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            property = elementBottom > viewportTop && elementTop < viewportBottom;
        }
        return property;
    };

    var canBeLoaded = true

    $(window).on('load resize scroll', function() {
        if ($(".ajax_load_posts").isInViewport()) {
            default_load_posts();
        }
    });

    function default_load_posts() {
        if (canBeLoaded) {
            var offset = parseInt($('.data_scroll_ajax').attr("data-offset"));
            var limit = parseInt($('.data_scroll_ajax').attr("data-limit"));
            $.ajax({
                url: CustomVar.ajaxurl,
                type: 'post',
                dataType: 'json',
                data: {
                    action: 'get_load_resources',
                    paged: offset,
                    per_page: limit,
                    resources_sort: $('.search-result .search-meta select').find(":selected").val()
                },
                beforeSend: function(xhr) {
                    canBeLoaded = false;
                    $(".default_load_posts").show();
                },
                success: function(data, textStatus, jQxhr) {
                    $(".default_load_posts").hide();
                    if (data.html != '') {
                        $('.resourses__cards-wrap .resourses__featured-list').append(data.html);
                        offset++;
                        $('.data_scroll_ajax').attr("data-offset", offset);
                        canBeLoaded = true;
                    }
                    //console.log(data.featured);

                    //filter_search();

                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    }
});