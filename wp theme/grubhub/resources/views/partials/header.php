<header class="banner">
	<div class="title-bar">
		<?php $mobileLogo = get_field('mobile_logo', 'option'); ?>
		<?php $mainLogo = get_field('main_logo', 'option'); ?>
		<?php $signin = get_field('sign_in_link', 'option'); ?>
		<a class="brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo $mobileLogo['url']; ?>" alt="<?php echo $mobileLogo['alt']; ?>"></a>
		<a href="<?php echo $signin['url']; ?>" target="<?php echo $signin['target']; ?>" class="mob-sign-in"><?php echo $signin['title']; ?></a>
		<button class="hamburger hamburger--collapse" type="button">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>
	</div>
	<div class="top-bar">
		<div class="top-bar-left show-for-large">
			<ul class="left">
				<li class="home"><a class="brand" href="<?php echo home_url('/'); ?>"><img src="<?php echo $mainLogo['url']; ?>" alt="<?php echo $mainLogo['alt']; ?>"></a></li>
			</ul>
		</div>
		<div class="top-bar-right">
			<?php 
			if (have_rows('mega_menu', 'option')) : ?>
				<nav>
					<ul class="menu" role="menubar">
						<li role="none" class="search hide-for-large">
							<a href="#" aria-label="<?php the_field('search_icon_aria_label', 'option'); ?>" class="search-main">
								<img src="<?php echo gh_assets('icon-search.svg'); ?>" alt="Search Site" />
								<span>Search</span>
							</a>
							<div class="mega-dd search-drop" aria-hidden="true">
								<?php get_search_form(); ?>
							</div>
						</li>
						<?php while (have_rows('mega_menu', 'option')) : the_row(); ?>
							<?php 
							$parent = get_sub_field('parent_item');
							$child = get_sub_field('subnav_children');
							$button = get_sub_field('add_button_style');
							$jump = get_sub_field('make_jump_link');
							$jumpLink = get_sub_field('jump_link_id');
							$mobileHide = get_sub_field('hide_for_mobile');
							$optLink = get_sub_field('optional_bottom_link');
							?>
							<li role="none" class="<?php echo $button ? 'btn' : ''; echo empty($child) ? '' : 'has-children'; echo $mobileHide ? ' show-for-large' : '' ?>">
								<a href="<?php echo $jump ? '#' . $jumpLink : $parent['url']; ?>" class="nav-tl <?php echo $jump ? 'nav-scroll' : ''; ?>" role="menuitem" aria-haspopup="<?php echo empty($child) ? 'false' : 'true'; ?>">
									<?php echo $parent['title']; ?>
								</a>
								<div class="mega-dd" role="menubar" aria-hidden="true">
									<div class="row">
										<?php if (get_sub_field('optional_image')): ?>
											<div class="columns large-4 medium-12 small-12 left-img">
												<?php $imgLeft = get_sub_field('optional_image'); ?>
												<?php $imgLink = get_sub_field('image_link'); ?>
												<a href="<?php echo $imgLink['url'] ?>" target="<?php echo $imgLink['target']; ?>" aria-label="<?php echo $imgLink['title']; ?>">
													<img src="<?php echo $imgLeft['url']; ?>" alt="<?php echo $imgLeft['alt']; ?>" />
												</a>
											</div>
										<?php endif ?>
										<div class="columns <?php echo $imgLeft ? 'large-8 medium-12 small-12' : 'large-6 medium-12 small-12' ?>">
											<?php if (have_rows('subnav_children')) : ?>
												<ul role="menu" aria-label="<?php echo $parent['title']; ?>">
													<?php while (have_rows('subnav_children')) : the_row(); ?>
														<li>
															<?php $subLink = get_sub_field('link'); ?>
															<a href="<?php echo $subLink['url']; ?>">
																<?php echo $subLink['title']; ?>
																<p><?php the_sub_field('description', 'option'); ?></p>
															</a>
														</li>
													<?php endwhile; ?>
												</ul>
											<?php endif; ?>
											<?php if (get_sub_field('optional_bottom_link')): ?>
												<div class="row">
													<div class="columns">
														<a href="<?php echo $optLink['url']; ?>" class="bottom-link"><?php echo $optLink['title']; ?></a>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<div class="mega-bottom show-for-large">
										<div class="row align-middle">
											<div class="columns large-4">
												<p><?php the_sub_field('menu_bottom_left'); ?></p>
											</div>
											<div class="columns large-4">
												<?php if (get_sub_field('menu_bottom_middle')): ?>
													<?php $ddLink1 = get_sub_field('menu_bottom_middle'); ?>
													<a href="<?php echo $ddLink1['url']; ?>" class="<?php the_sub_field('menu_bottom_middle_icon') ?>"><span></span><?php echo $ddLink1['title']; ?></a>
												<?php endif; ?>
											</div>
											<div class="columns large-4">
												<?php if (get_sub_field('menu_bottom_right')): ?>
													<?php $ddLink2 = get_sub_field('menu_bottom_right'); ?>
													<a href="<?php echo $ddLink2['url']; ?>" class="<?php the_sub_field('menu_bottom_right_icon') ?>"><span></span><?php echo $ddLink2['title']; ?></a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							</li>
						<?php endwhile; ?>
						<li role="none" class="search show-for-large">
							<a href="#" aria-label="<?php the_field('search_icon_aria_label', 'option'); ?>" class="search-main">
								<img src="<?php echo gh_assets('icon-search.svg'); ?>" alt="Search Site" />
								<span>Search</span>
							</a>
							<div class="search-drop" aria-hidden="true">
								<?php get_search_form(); ?>
								<a href="#" class="close-search">
									<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.47222 1.47222L17.5278 17.5278" stroke="black" stroke-width="2" stroke-linecap="square"/>
										<path d="M1.47222 17.5278L17.5278 1.47222" stroke="black" stroke-width="2" stroke-linecap="square"/>
									</svg>
									<span class="sr-only">Close Search</span>
								</a>
								<div class="overlay"></div>
							</div>
						</li>
						<li role="none" class="sign-in show-for-large">
							<a href="<?php echo $signin['url']; ?>" target="<?php echo $signin['target']; ?>"><?php echo $signin['title']; ?></a>
						</li>
						<?php 
						if (get_field('mobile_cta_button', 'option')):
							$mobLink = get_field('mobile_cta_button', 'option');
							?>
							<li role="none" class="btn mobile-cta">
								<a href="<?php echo $mobLink['url']; ?>"><?php echo $mobLink['title']; ?></a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
				<?php if (get_field('enable_bug')): ?>
					<a href="#bottomForm" class="bug nav-scroll" tabindex="0" aria-label="Join Grubhub">
						<svg fill="none" viewBox="0 0 70 128" xmlns="http://www.w3.org/2000/svg">
							<g filter="url(#a)">
								<path d="M70 80L8 87.5288V119L70 112.55V80Z" fill="#FF8000"/>
								<path d="M70 0L8 7.52877V39L70 32.5498V0Z" fill="#FF8000"/>
								<rect x="8" y="10" width="62" height="101" fill="#FF8000"/>
								<path d="m26.02 22.459h-2.48v8.144c0 0.528-0.256 0.784-0.656 0.784h-0.544v2.32h0.8c1.952 0 2.88-0.896 2.88-2.88v-8.368zm7.2125-0.24c-3.328 0-5.904 2.336-5.904 5.84s2.576 5.84 5.904 5.84 5.904-2.336 5.904-5.84-2.576-5.84-5.904-5.84zm0 2.56c1.792 0 3.168 1.264 3.168 3.28s-1.376 3.28-3.168 3.28-3.168-1.264-3.168-3.28 1.376-3.28 3.168-3.28zm9.7004-2.32h-2.48v11.2h2.48v-11.2zm11.91 0h-2.48v6.928h-0.016l-5.36-6.928h-2.096v11.2h2.48v-6.896h0.016l5.344 6.896h2.112v-11.2z" fill="#fff"/>
								<g clip-path="url(#b)" fill="#fff">
									<path d="m32.652 67.722c0 0.7296-0.2919 4.0858-2.6996 4.8154-1.6781 0.5107-2.5537-0.8026-2.5537-3.794v-11.017c0-1.0214 0.073-2.6266 1.0215-3.7939 0.5837-0.7297 1.5322-1.3134 2.4077-1.3863 1.0215-0.073 1.897 0.8026 1.897 2.5536v1.6781c0 0.3649 0.2919 0.5837 0.6567 0.4378l4.1588-1.5322c0.1459-0.0729 0.2918-0.2189 0.2918-0.4377v-1.897c0-4.5236-3.9399-7.2232-8.1717-6.1288-5.7639 1.5322-7.6609 6.7854-7.6609 10.288v13.644c0 4.9614 3.4292 7.3691 6.4206 7.3691 4.3777 0 9.412-3.4291 9.412-10.798v-8.4636c0-0.4377-0.3648-0.5107-0.6566-0.4377l-6.7125 2.4807c-0.4377 0.1459-0.4377 0.3648-0.4377 0.6566v3.867c0 0.3648 0.2918 0.5837 0.6566 0.4377l1.97-0.7296v2.1889z"/>
									<path d="m55.343 93.476c0.3648 0.1459 0.6567-0.073 0.6567-0.4378v-28.601c0-0.2189-0.2189-0.4378-0.4378-0.5837l-4.2318-1.5322c-0.3648-0.1459-0.6566 0.073-0.6566 0.4378v11.09l-4.3777-1.6052v-11.309c0-0.2188-0.2189-0.4377-0.4378-0.5837l-4.2317-1.5321c-0.3648-0.146-0.6567 0.0729-0.6567 0.4377v28.528c0 0.2189 0.2189 0.4378 0.4378 0.5837l4.2318 1.5322c0.3648 0.1459 0.6566-0.073 0.6566-0.4378v-11.528l4.3777 1.6052v11.82c0 0.2189 0.2189 0.4378 0.4378 0.5837l4.2317 1.5322z"/>
								</g>
								<path d="M8 119.5V101L37.5 116L8 119.5Z" fill="#FF8000"/>
							</g>
							<defs>
								<filter id="a" x="0" y="0" width="70" height="127.5" color-interpolation-filters="sRGB" filterUnits="userSpaceOnUse">
									<feFlood flood-opacity="0" result="BackgroundImageFix"/>
									<feColorMatrix in="SourceAlpha" result="hardAlpha" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"/>
									<feOffset dx="-4" dy="4"/>
									<feGaussianBlur stdDeviation="2"/>
									<feComposite in2="hardAlpha" operator="out"/>
									<feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
									<feBlend in2="BackgroundImageFix" result="effect1_dropShadow"/>
									<feBlend in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
								</filter>
								<clipPath id="b">
									<rect transform="translate(22 47)" width="34" height="46.476" fill="#fff"/>
								</clipPath>
							</defs>
						</svg>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<div class="faux-bg"></div>
</header>