<?php 

add_shortcode('mercury_slider','mercury_slider');
function mercury_slider($atts, $content=null){
	extract(shortcode_atts(
		array(
			'id' => ''
		), $atts)
	);

ob_start();
?>
<style>
@-webkit-keyframes slideOutLeft {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }

  to {
    visibility: hidden;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}

@keyframes slideOutLeft {
  from {
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
  }

  to {
    visibility: hidden;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}

.slideOutLeft {
  -webkit-animation-name: slideOutLeft;
  animation-name: slideOutLeft;
}


.d-table {width: 100%;height: 100%;display: table;}
.d-tablecell {display: table-cell;vertical-align: middle;}
.custom-btn1 {background-color: #FFFFFF;color: #000000;border: 1px solid #FFFFFF;display: inline-block;padding: 12px 30px;text-transform: uppercase;border-radius: 30px;text-decoration: none;}
.custom-btn1:hover {background-color: #FFFFFF;text-decoration: none;color: #000000;}
/*
Hero slider style
==========================*/
.hero-slider {position: relative;} 
 .single-hs-item {height: 100vh;background-size: cover;background-position: center center;position: relative;} 
 /* .single-hs-item:before {content: '';position: absolute;width: 100%;height: 100%;left: 0;top: 0;background-color: #000;opacity: .6;} 
 */ .item-bg1 { /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#222244+0,222244+50,c38151+50,c38151+100 */ background: #222244; /* Old browsers */ background: -moz-linear-gradient(left,  #222244 0%, #222244 50%, #c38151 50%, #c38151 100%); /* FF3.6-15 */ background: -webkit-linear-gradient(left,  #222244 0%,#222244 50%,#c38151 50%,#c38151 100%); /* Chrome10-25,Safari5.1-6 */ background: linear-gradient(to right,  #222244 0%,#222244 50%,#c38151 50%,#c38151 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222244', endColorstr='#c38151',GradientType=1 ); /* IE6-9 */   } 
 .item-bg2 {     /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#0c7068+0,4ba997+100 */ background: #0c7068; /* Old browsers */ background: -moz-linear-gradient(-45deg,  #0c7068 0%, #4ba997 100%); /* FF3.6-15 */ background: -webkit-linear-gradient(-45deg,  #0c7068 0%,#4ba997 100%); /* Chrome10-25,Safari5.1-6 */ background: linear-gradient(135deg,  #0c7068 0%,#4ba997 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */ filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0c7068', endColorstr='#4ba997',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ } 
 .item-bg3 { background-color: #ce986a; } 
 .hero-text {padding: 0 15px;text-align: center;max-width: 1140px;margin-left: auto;margin-right: auto;position: relative;} 
 .hero-text h1 {color: #fff;font-size: 46px;text-transform: capitalize;font-weight: 300;margin: 0;} 
 .hero-text h3 {color: #fff;font-size: 20px;text-transform: capitalize;font-weight: 600;margin: 0;} 
 .hero-text p {color: #fff;font-size: 20px;/*max-width: 300px;*/margin-left: auto;margin-right: auto;line-height: 30px;margin-top: 20px;margin-bottom: 35px;} 
 .hero-slider .owl-item.active h1,  .hero-slider .owl-item.active h3, .hero-slider .owl-item.active .anim-fadeIn {-animation: 1s .3s fadeIn both; animation: 1s .3s fadeIn both;} 
 .hero-slider .owl-item.active p {-webkit-animation: 1s .3s fadeIn both;animation: 1s .3s fadeIn both; } 
 .hero-slider .owl-item.active .slider-btn {-webkit-animation: 1s .3s fadeIn both;animation: 1s .3s fadeIn both;} 
 .owl-carousel .owl-nav button.owl-prev {background-color: #ff3547;position: absolute;left: 0;top: 50%; color: #fff;font-size: 30px;margin: -40px 0 0;border-radius: 0;height: 50px;width: 50px;} 
 .owl-carousel .owl-nav button.owl-next {background-color: #ff3547;position: absolute;right: 0;top: 50%;color: #fff;font-size: 30px;margin: -40px 0 0;border-radius: 0;height: 50px;width: 50px; } 
 .owl-theme .owl-nav {margin-top: 0;} 
 .owl-dots {position: absolute;left: 0;right: 0; bottom: 20px;} 
 .owl-theme .owl-dots .owl-dot span {width: 11px;height: 20px;} 
 .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {background: #ff3547;} 
 .stp>div { padding: 10px 5px; } 
 img {  max-width: 100%; } 
 .stp { display: flex;  max-width: 350px;  margin: auto; } 
 .ps_p{ display: none !important; } 
 .stp .disabled {  pointer-events: none;  opacity: .6;} 
 .stp .disabled:hover { background: transparent !important; }
 .slider_outer_div{ position: relative; } 
 .d-table .container{ max-width: 1200px !important;width:100% !important;} 
 .d-table .row{ margin: 0 auto !important; } 
 .step_nav {  position: absolute;  width: 110px;  z-index: 99;  left: 0;  top: 50%;  transform: translateY(-50%);  cursor: pointer;  align-items: center;     justify-content: center;  height: 70%; } 
 .step_nav.navNext{ left: auto; right: 0; }
 .step_nav.navNext:not(:hover) { background: transparent !important; } 
 .np_img { position: absolute;  height: 90%; width: 0;  left: 0; transition: .3s;  background-size: cover;  background-position: left center; top: 50%; transform: translateY(-45%); } 
 .step_nav.navNext .np_img{ left: auto;  right: 0; transition: .4s; } 
 .step_nav.navNext .np_hover {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
    opacity: 0.5;
}
.step_nav.navNext:hover .np_hover {
    display: block;
}
.step_nav.navNext.disabled:hover .np_hover {
  display: none;
}

 .step_nav:hover .np_img{   width: 100%; } 
 .np_text { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: 30px; color: #fff; z-index: 999; } 
 .sld_op.sld_bottom {     position: absolute;     bottom: 0;         right: 0;     max-width: 100% !important; } 
 .sld_op.sld_middle {     position: absolute;     top: 50%;     transform: translateY(-50%);     max-width: 100% !important; } 
 .w_55{  width: 55%; right: 0} 
 .w_35{width: 35%; right: 10%; } 
  .anim-delay-500{ animation-delay: 500ms !important; -webkit-animation-delay: 500ms !important; } 
 .anim-delay-1000{ animation-delay: 1000ms !important; -webkit-animation-delay: 1000ms !important; } 
 .anim-delay-1500{ animation-delay: 1500ms !important; -webkit-animation-delay: 1500ms !important; } 
 .anim-delay-2000{ animation-delay: 2000ms !important; -webkit-animation-delay: 2000ms !important; } 
 .anim-delay-2500{ animation-delay: 2500ms !important; -webkit-animation-delay: 2500ms !important; } 
   .sld_pop_box>div {     flex-basis: 50%; } 
 .sld_pop_box {     display: flex;     align-items: center;     justify-content: center;     background: #fff; } 
 .pop_text{ max-width: 400px; margin: auto; padding: 20px;} 
 .fancybox-button svg * { fill: #fff !important; opacity: 1; } 
 .fancybox-close:after{ color:#fff !important; } 
 .sld_pop_outer {     background: transparent; } 
 .sld_pop_outer img{display: block;} 
 .fancybox-skin {     background: transparent !important;     -webkit-box-shadow:none !important;     -moz-box-shadow: none !important;     box-shadow: none !important;  } 
  @media only screen and (max-width: 991px) { 	.d-tablecell { 	    display: block; 	    	} 
 	.d-tablecell  .hero-text { padding: 30px 10px !important; } 
 	.hero-text p{ 		margin: 0 auto 10px; 	} 
 	.slider_outer_div *{ text-align: center; margin-left: auto; margin-right: auto; } 
 	.sld_op {     position: relative !important;     width: 100%;     left: 0 !important;     right: 0 !important;     top: 0 !important;     bottom: 0 !important;     transform: translate(0,0) !important;      max-height: 300px; 	   margin: auto; } 
 .single-hs-item{ height: 70vh; } 
  	.step_nav{ width: 60px; height: 30%; } 
 } 
 @media only screen and (max-width: 600px) {        .hero-text h1 {         font-size: 30px;     } 
     .hero-text p {         font-size: 15px;         margin-bottom: 25px;     } 
     .owl-carousel .owl-nav button.owl-next {         top: auto;         margin: 0;         bottom: 0px;     } 
     .owl-carousel .owl-nav button.owl-prev {         top: auto;         margin: 0;         bottom: 0px;     } 
     .owl-dots {         bottom: 10px;         left: 50px;         right: 50px;     } 
  } 
	</style>
<?php

?>
<div class="slider_outer_div">
    <div id="mercury_slider" class="hero-slider owl-carousel owl-theme">
	<?php
	if(get_field('slides', $id)[1]['slider_thumb']['url']){
    $thum_2 = get_field('slides', $id)[1]['slider_thumb']['url'];
	} else{
    $thum_2 = get_field('slides', $id)[1]['slider_image']['url'];
	}

  $extra_css_2 = explode(';', get_field('slides', $id)[1]['container_extra_css']);

	if(have_rows('slides', $id)){
		while (have_rows('slides', $id)) {
			the_row();
			$background_image = get_sub_field('background_image')['url'];
			$container_extra_css = get_sub_field('container_extra_css');
			$slider_text = get_sub_field('slider_text');
			$slider_image = get_sub_field('slider_image')['url'];
			$image_position = get_sub_field('image_position');
			$image_width = get_sub_field('image_width');
			$slider_thumb = get_sub_field('slider_thumb')['url'];
			if(!get_sub_field('slider_thumb')){
					$slider_thumb = $slider_image;
			}
			?>
			<div class="single-hs-item" style="background-image: url(<?php echo $background_image;?>); background-size: cover; background-position: center center; <?php echo $container_extra_css;?>">				
			      <img class="ps_p" src="<?php echo $slider_thumb;?>">  
			          <div class="d-table">
			                <div class="d-tablecell">
			                    <div class="hero-text">
			                      <div class="container">
			          <div class="row">
			            <div class="col-md-4" style="text-align: left;">
			                       <?php echo $slider_text;?>             
			                    </div>
			             </div>
			          </div>
			          </div>    
			          <div class="sld_op <?php echo $image_position . ' ' . $image_width;?>">
			              <img class=" anim-fadeIn" src="<?php echo $slider_image;?>">
			              </div>
			                </div>
			            </div>
				}			            
			    </div>
			<?php
		}
		wp_reset_postdata();
	}
	?>
</div>
<div class="stp">	
        <div class="step_nav navPrev disabled">
          <div class="np_img" style="background-image: url();"></div>
          <div class="np_text"><?php echo do_shortcode( '[x_icon type="arrow-left"]');?></div>
          <div class="np_hover"></div>
        </div>
        <div class="step_nav navNext" style="<?php echo $extra_css_2[0]; ?>" data-color="<?php echo $extra_css_2[0]; ?>">
          <div class="np_img" style="background-image: url(<?php echo $thum_2;?>);"></div>
          <div class="np_text"><?php echo do_shortcode( '[x_icon type="arrow-right"]');?></div>
          <div class="np_hover" style="<?php echo $extra_css_2[0]; ?>"></div>
        </div>
        </div>


        <?php
		if(have_rows('slides', $id)){
			$count_pop = 0;
		while (have_rows('slides', $id)) {
				the_row();
			$popup_text = get_sub_field('popup_text');
			$slider_image = get_sub_field('slider_image')['url'];			
			$slider_thumb = get_sub_field('slider_thumb')['url'];
			if(!get_sub_field('slider_thumb')){
					$slider_thumb = $slider_image;
			}
			?>
			<div id="popup_<?php echo $count_pop;?>" class="sld_pop_outer" style="display: none;width:100%;max-width:1400px;">
            <div class="sld_pop_box">
                <div class="pop_col">
                    <div class="pop_text">
                    	<?php echo $popup_text;?>
                </div>
                </div>
                <div class="pop_col">
                    <img src="<?php echo $slider_thumb;?>">
                </div>
            </div>
            </div>

			<?php
		}
	}
	?>

        <div id="uveda" class="sld_pop_outer" style="display: none;width:100%;max-width:1400px;">
            <div class="sld_pop_box">
                <div class="pop_col">
                    <div class="pop_text">
                    <h2 class="mb-3">Hello!</h2>
                     <p>
                    The first focusable element in the modal gets the focus for better accessibility.
                    <br />
                    The script traps focus within the modal to disable the user to access the content behind it.

                    Focus is restored to last focused element when modal closes.
                </p>
                </div>
                </div>
                <div class="pop_col">
                    <img src="https://mercury.one/wp-content/uploads/2019/11/2.png" alt="">
                </div>
            </div>
            </div>

             <div id="landesa" class="sld_pop_outer" style="display: none;width:100%;max-width:1400px;">
            <div class="sld_pop_box">
                <div class="pop_col">
                    <div class="pop_text">
                    <h2 class="mb-3">Hello!</h2>
                     <p>
                    The first focusable element in the modal gets the focus for better accessibility.
                    <br />
                    The script traps focus within the modal to disable the user to access the content behind it.

                    Focus is restored to last focused element when modal closes.
                </p>
                </div>
                </div>
                <div class="pop_col">
                    <img src="https://mercury.one/wp-content/uploads/2019/11/3.png" alt="">
                </div>
            </div>
            </div>
        </div>
<script>
jQuery(function($){


// Hero slider JS
var owl= $('.hero-slider').owlCarousel({
    animateOut: 'slideOutLeft',
    animateIn: 'fadeIn',
    margin:0,
    items:1,
    loop:false,
    nav:false,
    dots: false,
    mouseDrag: false
  })


owl.on('changed.owl.carousel', function(property) {
        var current = property.item.index;
        var total_index = property.item.count - 1;
        $('.navPrev').removeClass("disabled");
        $('.navNext').removeClass("disabled");
        if(current==0){
          $('.navPrev').addClass("disabled");
        }
        if(current==total_index){
          $('.navNext').addClass("disabled");
        }
        //var prev = $(property.target).find(".owl-item").eq(current).prev().find("img").attr('src');
        var next = $(property.target).find(".owl-item").eq(current).next().find("img").attr("src");
        //var color1 = $(property.target).find(".owl-item").eq(current).prev().find(".single-hs-item").css("background-color");
        var color = $(property.target).find(".owl-item").eq(current).next().find(".single-hs-item").css("background-color");
        /*$('.navPrev').find('.np_img').css({
          'background-image' : 'url('+prev+')',
        });*/
        /*$('.navNext').find('.np_img').css({
          'background-color' : color,
          'background-image' : 'url('+next+')',
        });*/
        $('.navNext').find('.np_img').css('background-image', 'url('+next+')');
        //$('.navPrev').find('.np_img').css('background-image', 'url('+prev+')');
        if(current == 0){
          var color = $('.navNext').attr('data-color');
          $('.navNext').attr('style', color);
          $('.navNext').find('.np_hover').attr('style', color); 
        } else {
          $('.navNext').css('background-color', color);
          $('.navNext').find('.np_hover').css('background-color', color);          
        }
        /*$('.navPrev').css('background-color', color1);
        $('.navPrev').find('.np_hover').css('background-color', color1); */
      });
      $('.navNext').click(function() {
        owl.trigger('next.owl.carousel');
      });
      $('.navPrev').click(function() {
        owl.trigger('prev.owl.carousel');
      });

$('.sld_pop_act').fancybox();
});


</script>
<?php
return ob_get_clean();
}