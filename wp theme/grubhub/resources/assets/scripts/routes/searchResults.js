import { gsap } from "gsap"
import ScrollTrigger from "gsap/ScrollTrigger"
gsap.registerPlugin(ScrollTrigger);

export default {
	init() {
    // var imgInfo = [];
    // var imgCntr = 0;
    // let all = $('.all-res').html();
    // function buildImg() {
    //   $(all).each(function() {
    //     console.log($(this));
    //     // $(all).hide();
    //     imgInfo.push($(all));
    //   });
    //   console.log(imgInfo);
    // }

    // function loadMore(num) {
    //   // for (len = Math.min(imgInfo.length, imgCntr + num); imgCntr < len; imgCntr++) {
    //     for (let i = 0; i <= num; i++) {
    //       console.log($(imgInfo[num]));
    //      $('#all').append($(imgInfo[num]));
    //     }
    //   // }
    // }

    // buildImg();
    // // loadMore(6);

    // $('.gh_loadmore').click(function() {
    //   loadMore(3);
    //   return(false);
    // });
    // $('.gh_loadmore').click(function(){
    //     var button = $(this),
    //         data = {
    //         'action': 'loadmore',
    //         'query': gh_loadmore_params.posts,
    //         'page' : gh_loadmore_params.current_page,
    //     };


    //     $.ajax({ 
    //         url : gh_loadmore_params.ajaxurl,
    //         data : data,
    //         type : 'POST',
    //         beforeSend : function ( xhr ) {
    //             button.text('Loading...');
    //         },
    //         success : function( data ) {
    //             if( data ) {
    //                 button.text( 'More posts' ).prev().after(data);
    //                 gh_loadmore_params.current_page++;

    //                 if ( gh_loadmore_params.current_page == gh_loadmore_params.max_page ) 
    //                     button.remove();
    //             } else {
    //                 button.remove();
    //             }
    //         },
    //     });
    // });

    // const all = $('#all');
    // const results = [];
    // // all.hide();
    // if (window.location.href.indexOf('search') > -1) {
    //   $(all).children('.row').each(function() {
    //     results.push(all);
    //     all.children('.row').hide();
    //   })

    //   let length = results.length;
    //   let groups = length / 6;

    // }
  },
  finalize() {
  },
};
