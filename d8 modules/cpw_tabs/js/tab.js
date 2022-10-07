/**
 * @file
 * Contains JS function
 */

(function ($, Drupal, drupalSettings) {
  'use strict';
  Drupal.behaviors.cpw_tabs = {
    attach: function (context) {
      $(context).find('.mod-tab__tab a').bind("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        Drupal.behaviors.cpw_tabs.onTabClick(event, context);
      });
      
      // Attached product carousel 
      Drupal.behaviors.product_carousel.attach(context);

      //To move show all products button inside product carousel container
      var tabs =  $(context).find('.mod-tab__pane');
      tabs.each(function() {
        if ($(this).children('.mod-products-carousel__see-all-container').length > 0) {
          var clonedButton = $(this).children('.mod-products-carousel__see-all-container').clone();
          $(this).find('.mod-products-carousel__list-wrapper').append(clonedButton);
          $(this).children('.mod-products-carousel__see-all-container').remove();
        }
      });
    },

  };

  Drupal.behaviors.tab_accessibility = {
    attach: function (context) {
      const tablist = $("[role='tablist']").find("[role='tab']");

      function tabsClickHandler() {
        var thisTabId = $(this).attr('id');
        var thisTabList = $(this).parents("[role='tablist']").find("[role='tab']");

        $(this).parent().find('.mod-tab__tab').removeClass('is-active');
        $(this).addClass('is-active');

        thisTabList.each(function() {
          var thisTabPanel = $("[role='tabpanel'][id='"+$(this).attr('aria-controls')+"']");
          if($(this).attr('id') == thisTabId){
            thisTabPanel.addClass('is-active');
            $(this).attr('aria-selected', true)
            .attr('tabindex', '0');
          }
          else {
            thisTabPanel.removeClass('is-active');
            $(this).attr('aria-selected', false)
             .attr('tabindex', '-1');
          }
        });
      }

      function tabsHandler(event){

        var index = tablist.index($(this));
        var numbTabs = tablist.length;
        var nextId;

        if(numbTabs > 1){

          if(event.keyCode == 40 || event.keyCode == 39) { // DOWN or RIGHT
            nextId = tablist.eq(index+1);

            if(index == numbTabs-1){ // if it is the last not empty tab, then go to first not empty tab
              nextId = tablist.eq(0);
            }

            nextId.focus(); // focus on next tab
            nextId.click();
          }

          if(event.keyCode == 38 || event.keyCode == 37) { // UP or LEFT
            nextId = tablist.eq(index-1);

            if(index == 0){ // if it is the last not empty tab, then go to first not empty tab
              nextId = tablist.eq(numbTabs-1);
            }

            nextId.focus(); // focus on next tab
            nextId.click();
          }
        }
      }

      tablist.on('keydown', tabsHandler);
      tablist.on('click', tabsClickHandler);

      $("[role='tablist'] [role='tab'][aria-selected='true']").click();

    }
  };

})(jQuery, Drupal, drupalSettings);
