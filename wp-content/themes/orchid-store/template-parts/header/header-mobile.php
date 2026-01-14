<?php
/**
 * Template part for displaying header layout one
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Orchid_Store
 */

?>
<style>
	.site-navigation>ul>li:first-child>a{
	color: #00217b !important;
}

.site-navigation>ul>li>a {
	color: #00217b !important;
}
.menu-link .main-menu-link{
	color: #00217b !important;
}
.mobile-navigation .top-header-menu-entry nav>ul>li>a{
	color: #00217b !important;
}
.mobile-header .mid-block {
    /* padding: 20px 0; */
}
.trigger-mob-nav-close{
	color: #00217b !important;
}

.mid-block{
	background-color:#f3f4f8;
	padding:0px !important;
}
.menu-toggle span {
    background-color: #00217b !important;
}
.sub-menu li a{
	color: #00217b !important;
}
.mobile-header .special-navigation .sub-toggle, .mobile-navigation .sub-toggle {
    background:#f3f4f8 !important;
    color: #00217b !important;
	
}
.mobile-header .special-navigation .sub-toggle i, .mobile-navigation .sub-toggle i {
	font-size: 22px !important;
}
.mobile-header .special-navigation>ul>li:last-child>a, .mobile-navigation .site-navigation>ul>li:last-child>a {
    display:none !important;
}

.mobile-header .flex-row {
    margin-left: 0px;
	margin-right: 0px; */
}

.mobile-header .bottom-block .flex-row {
    justify-content: normal !important;
}

/* BUSCADOR*/

	#buscador-mobile .is-form-style.is-form-style-3 input.is-search-input {
		border-radius: 10px !important;
		border: 1px solid #FFF !important;
		background: #FFF;
	}
	#buscador-mobile .is-form-style.is-form-style-3 input.is-search-input::placeholder {
		color: #23adb8; /* Example: red color */
		font-size: 12px !important;
		text-align:center;
	}

	#buscador-mobile .is-form-style input.is-search-input {
		background: #f3f4f8;
		color: #23adb8;
		outline: 0 !important;
		height: 40px;
		min-height: 0;
		line-height: 1;
		width: 100%;
	}

	#buscador-mobile .is-search-submit {
		position: absolute;
		top: 40%;
		right: 20px;
		transform: translateY(-50%);
		font-size: 25px;
		color: #00a4a6 !important; /* color de la lupa */
		cursor: pointer;
		padding: 0;
		line-height: 1;
	}
	#buscador-mobile .is-search-icon {
		width: 36px;
		padding-top: 10px !important;
	}

	#buscador-mobile .is-form-style input.is-search-submit, .is-search-icon {
		border: none !important;
		background: none !important;
	}
	#buscador-mobile .is-search-icon svg {
		width: 30px !important;
		display: inline;
		
	}
	#buscador-mobile .is-form-style .is-search-submit path {
		fill: #00a4a6 !important;
	}
	#buscador-mobile .header-info {
	}

	#buscador-mobile .header-info i {
	margin-right: 5px;
	color: #00a4a6; /* puedes ajustar color */
	}

/* FIN BUSCADOR */

	.menu-toggle {
		padding: 0;
		text-align: center;
	}
		.custom-cart-btn a{
		background-color:#23adb8 !important;
		color: #FFF !important;
		border-radius: 20px !important;
		border: 1px solid #23adb8 !important;

	}
	.custom-cart-btn a:hover{
		color:#00217b !important; 
	}
	.product .product-main-wrap {
		border-radius: 20px !important;
		box-shadow:0.3em 0.3em 1em rgb(183 183 183 / 70%);
	}
	#carrusel-top {
        margin-top: -30px;
    }
	.orchid-backtotop{
		background-color: #00a4a6;
	}


	.custom-cart-btn a{
		background-color:#23adb8 !important;
		color: #FFF !important;
		border-radius: 20px !important;
		border: 1px solid #23adb8 !important;

	}
	.custom-cart-btn a:hover{
		color:#00217b !important; 
	}
	.product-main-wrap{
		border-radius: 20px !important;
		padding: 20px;
		box-shadow:0.3em 0.3em 1em rgb(183 183 183 / 70%);
	}

	.woocommerce div.product .woocommerce-tabs {
		margin-top:0px;
    	padding: 30px 0px 0px 0px;
		background:#f3f4f8;
		border:0px !important;
		box-shadow:none;
		
	}
	.woocommerce div.product .woocommerce-tabs .panel {
		margin: 0 0 0;
		padding: 30px;
		background:#FFF;
		border-radius:0px 20px 20px 20px !important;
		box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
		
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs {
		border: 0px solid #ececec;
		font-size: 0;
		list-style: none;
		margin:0px;
		padding: 0;
	
		
	}
	.woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li {
		display: inline-block !important;
		text-align:center;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li {
		background-color: transparent;
		border: none;
		border-radius: 0;
		border-right: 0px solid #ececec;
		cursor: pointer;
		margin: 0;
		padding: 0;
		max-width: 120px;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li a {
        border-bottom: 0px solid #ececec;
        display: block;
        /* padding: 15px 10px; */
    }
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active {
		background: #fff;
		color: #00a4a6 !important; /* color de la lupa */
		z-index: 2;
		border-bottom-color: #fff;
		border-radius:20px 20px 0px 0px !important;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
		color: inherit;
		text-shadow: inherit;
		outline: none !important;
	}
	.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images {
		float: left;
		/*width: 100%;*/
		border-radius:20px 20px 20px 20px !important;
	}
	.woocommerce div.product div.images img {
			border-radius:20px 20px 0px 0px !important;
	}
	.zoomImg {
		border-radius:20px 20px 0px 0px !important;
	}
	aside.secondary-widget-area .widget{
		border-radius:20px 20px 20px 20px !important;
	}
	body.woocommerce:not(.no-sidebar) #content div.product div.summary {
		/*width: 100%;*/
		border-radius:20px 20px 20px 20px !important;
	}
	.woocommerce div.product div.images, .woocommerce div.product div.summary {
		    border: 0px solid #eef1fd;
	}
	.woocommerce div.product div.images {
    	margin-bottom:0;
	}
	.woocommerce div.product div.images.woocommerce-product-gallery{
		border:0px;
	}
	.woocommerce.woocommerce-page div.product .product_title {
		color: #00a4a6 !important; /* color de la lupa */
	}
	.woocommerce div.product .entry-summary form.cart .button {
    	margin-left: 10px;
		opacity: 100% !important;
		background-color:#23adb8 !important;
		color: #FFF !important;
		border-radius: 20px !important;
		border: 1px solid #23adb8 !important;
	}
	.woocommerce div.product .entry-summary form.cart .button:hover {
		color: #0f217b !important;
	}
	.cart-count {
		background-color: #00a4a6;
		color: #fff;
		border-radius: 50%;
		padding: 1px 6px;
		font-size: 10px;
		position: absolute;
		margin-left:20px;
		/*top: -10px;
		left: -20px;*/
	}
</style>
<header class="masterheader mobile-header header-style-1 mobile-header-style-1">
	<div class="top-bar-carousel">
		<div class="carousel-content">
			<span><img src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/05/icono-envios.png"> ¡ENVIAMOS <strong>HOY TU PEDIDO!</strong> <img src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/05/icono-envios.png"></span>
			<span><img src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/05/icono-hora-envios.png"> VALIDO COMPRAS ANTES DE LAS 12PM <img src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/05/icono-hora-envios.png"></span>
			<span>LUNES A VIERNES / NO APLICA FERIADOS</span>
		</div>
	</div>
	<div class="header-inner">
		<?php
		$orchid_store_display_top_header = orchid_store_get_option( 'display_top_header' );
		if ( $orchid_store_display_top_header ) {
			?>
			<div class="top-header top-block">
				<div class="__os-container__">
					<div class="block-entry os-row">
						<?php
						$orchid_store_social_links = orchid_store_get_option( 'top_header_social_links' );

						if ( ! empty( $orchid_store_social_links ) ) {

							$orchid_store_social_links_array = explode( ',', $orchid_store_social_links );
							?>
							<div class="social-icons flex-col">
								<ul class="social-icons-list">
								<?php
								foreach ( $orchid_store_social_links_array as $orchid_store_social_link ) {
									?>
									<li>
										<a href="<?php echo esc_url( $orchid_store_social_link ); ?>"></a>
									</li>
									<?php
								}
								?>
								</ul>
							</div><!-- // social-icons -->
							<?php
						}
						?>
					</div><!-- // block-entry -->
				</div><!-- // __os-container__ -->
			</div><!-- // top-block -->
			<?php
		}
		?>
		<div class="mid-block">
			<div class="__os-container__">
				<div class="block-entry os-row">
					<div class="branding flex-col">
						<?php
						/**
						 * Hook - orchid_store_mobile_site_identity.
						 *
						 * @hooked orchid_store_mobile_site_identity_action - 10
						 */
						do_action( 'orchid_store_mobile_site_identity' );
						?>
					</div><!-- .branding flex-col -->
	



						<div class="header-items flex-col">
							<div class="flex-row">
								<ul style="display:flex;list-style: none; margin:0px!important;">
									<li style="margin:0px !important;"><a href="./mi-cuenta">
										<img style="max-height:30px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO CUENTA.webp"></a>
									</li>
									<li style="margin:0px !important;">
										<a href="#" id="fkcart-floating-toggler" class="fkcart-toggler" style="all: unset; cursor: pointer; display: inline-block;">
												<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>					
											<img class="fas fa-shopping-cart" style="max-height:30px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO CARRITO.webp">
										</a>
									</li>
									<li style="margin:0px !important;">
										<a href="https://www.instagram.com/farmanostica/" target="_blank">
											<img style="max-height:30px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO INSTAGRAM.webp">
										</a>
									</li>
								</ul>
							</div>
						</div>

				</div><!-- // block-entry -->
			</div><!-- // __os-container__ -->
		</div><!-- // mid-block -->
		<div class="mid-block" id="buscador-mobile">
			<?php
				if (
					orchid_store_get_option( 'display_product_search_form_on_mobile' ) &&
					orchid_store_get_option( 'display_product_search_form' )
				) {
					?>
	
						<?php get_search_form(); ?>
						<!--<button class="search-toggle"><i class='bx bx-search'></i></button>-->
			
					<?php
				}
			?>
		</div>
		<div class="bottom-block">
			<div class="__os-container__">
				<div class="block-entry">

			
						<div class="nav-col">
							<div class="menu-toggle">
								<button class="mobile-menu-toggle-btn">
									<span class="hamburger-bar"></span>
									<span class="hamburger-bar"></span>
									<span class="hamburger-bar"></span>
								</button>
							</div><!-- .meu-toggle -->
							<?php
							/**
							 * Hook - orchid_store_primary_navigation.
							 *
							 * @hooked orchid_store_primary_navigation_action - 10
							 */
							do_action( 'orchid_store_primary_navigation' );
							?>
						</div><!-- // nav-col -->


	
				</div><!-- // block-entry -->
			</div><!-- // __os-container__ -->
			<?php
			if (
				orchid_store_get_option( 'display_product_search_form' ) &&
				orchid_store_get_option( 'display_product_search_form_on_mobile' )
			) {
				?>
				<div class="mobile-header-search">
					<?php
					if ( class_exists( 'WooCommerce' ) ) {

						$search_form_type = orchid_store_get_option( 'select_search_form' );

						if ( 'product_search' === $search_form_type ) {
							/**
							* Hook - orchid_store_product_search.
							*
							* @hooked orchid_store_product_search_action - 10
							*/
							do_action( 'orchid_store_product_search' );
						} elseif ( 'default_search' === $search_form_type ) {

							/**
							* Hook - orchid_store_default_search.
							*
							* @hooked orchid_store_default_search_action - 10
							*/
							do_action( 'orchid_store_default_search' );
						} else {
							/**
							 * Hook - orchid_store_third_party_product_search.
							 *
							 * @hooked orchid_store_third_party_product_search_action - 10
							 */
							do_action( 'orchid_store_third_party_product_search' );
						}
					} else {
						/**
						 * Hook - orchid_store_default_search.
						 *
						 * @hooked orchid_store_default_search_action - 10
						 */
						do_action( 'orchid_store_default_search' );
					}
					?>
				</div><!-- // mobile-header-search -->
				<?php
			}

			if ( orchid_store_get_option( 'display_special_menu' ) ) {
				?>
				<nav class="category-navigation special-navigation">
					<?php
					/**
					 * Hook - orchid_store_secondary_navigation.
					 *
					 * @hooked orchid_store_secondary_navigation_action - 10
					 */
					do_action( 'orchid_store_secondary_navigation' );
					?>
				</nav><!-- // special-navigation -->
				<?php
			}
			?>
		</div><!-- // bottom-block -->
	</div><!-- // header-inner -->
</header><!-- .mobile-header header-style-1 -->
<aside class="mobile-navigation canvas" data-auto-focus="true">
	<div class="canvas-inner">
		<div class="canvas-container-entry">
			<div class="canvas-close-container">
				<button class="trigger-mob-nav-close"><i class='bx bx-x'></i></button>
			</div><!-- // canvas-close-container -->
			<div class="top-header-menu-entry">
				<?php

				$orchid_store_top_header_left_item = orchid_store_get_option( 'display_menu_or_login_register_link' );

				if ( 'login_register' === $orchid_store_top_header_left_item ) {
					/**
					 * Hook - orchid_store_user_links.
					 *
					 * @hooked orchid_store_user_links_action - 10
					 */
					do_action( 'orchid_store_user_links' );
				} else {
					/**
					 * Hook - orchid_store_top_header_menu.
					 *
					 * @hooked orchid_store_top_header_menu_action - 10
					 */
					do_action( 'orchid_store_top_header_menu' );
				}
				?>
			</div><!-- // secondary-navigation -->
			<div class="mobile-nav-entry">
				<?php
				/**
				 * Hook - orchid_store_secondary_navigation.
				 *
				 * @hooked orchid_store_secondary_navigation_action - 10
				 */
				do_action( 'orchid_store_primary_navigation' );
				?>
			</div><!-- // mobile-nav-entry -->
		</div><!-- // canvas-container-entry -->
	</div><!-- // canvas-inner -->
</aside><!-- // mobile-navigation-canvas -->
<div class="mobile-navigation-mask"></div><!-- // mobile-navigation-mask -->
