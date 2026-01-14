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
	.header-inner{
	height:166px !important; background-color:#f3f4f8;
	}
	.top-bar-carousel {
	width: 100%;
	overflow: hidden;
	white-space: nowrap;
	background-color: #e0c702; /* Amarillo */
	padding: 6px 0;
	}

	.carousel-content {
	display: inline-block;
	padding-left: 100%;
	animation: scroll-left 15s linear infinite;
	}

	.carousel-content span {
	display: inline-block;
	margin-right: 60px;
	/*font-weight: bold;*/
	font-size: 14px;
	color: #FFF;
	}

	@keyframes scroll-left {
	0% {
		transform: translateX(0%);
	}
	100% {
		transform: translateX(-100%);
	}
	}
	.header-style-1 .top-header .os-col {
		-webkit-box-flex: 0;
		-ms-flex: 0 0 50%;
		flex: 0 0 50%;
		max-width: 100%;
	}
	.header-style-1 .top-header .os-col.left-col {
		-webkit-box-flex: 0;
		flex: 0 0 30% !important;
		max-width: 95%;
	}
		.header-style-1 .top-header .os-col.header-search{
		-webkit-box-flex: 0;
		flex: 0 0 45% !important;
		max-width: 95%;
	}
		.header-style-1 .top-header .os-col.right-col {
		-webkit-box-flex: 0;
		flex: 0 0 25% !important;
		max-width: 95%;
	}
	.is-form-style.is-form-style-3 input.is-search-input {
		border-radius: 20px !important;
		border: 1px solid #23adb8 !important;
	}
	.is-form-style.is-form-style-3 input.is-search-input::placeholder {
		color: #23adb8; /* Example: red color */
		font-size: 18px !important;
	}

	.is-form-style input.is-search-input {
		background: #f3f4f8;
		color: #23adb8;
		padding: 0 12px;
		margin: 20px;
		outline: 0 !important;
		font-size: 14px !important;
		height: 70px;
		min-height: 0;
		line-height: 1;
		width: 100%;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		-webkit-appearance: none;
		-webkit-border-radius: 0;
	}

	.is-search-submit {
		position: absolute;
		top: 40%;
		right: 50px;
		transform: translateY(-50%);
		font-size: 25px;
		color: #00a4a6 !important; /* color de la lupa */
		cursor: pointer;
		padding: 0;
		line-height: 1;
	}

	.is-form-style input.is-search-submit, .is-search-icon {
		border: none !important;
		background: none !important;
	}
	.is-search-icon svg {
		width: 45px !important;
		display: inline;
		
	}
	.is-form-style .is-search-submit path {
		fill: #00a4a6 !important;
	}
	.header-info {
	font-size: 14px;
	}

	.header-info i {
	margin-right: 5px;
	color: #00a4a6; /* puedes ajustar color */
	}

	.footer {
		background: #23adb8 !important;
	}
	.footer, .footer .footer-bottom p, .footer .widget_rss ul li a, .footer .widget_tag_cloud .tagcloud a, .footer a {
		color: #FFF;
	}
	.widget_pages li{
		border-color: #FFF !important;
	}
	.footer .widget .widget-title h3{
		color: #FFF !important;
	}
	.elementor-column-gap-default>.elementor-column>.elementor-element-populated {
		padding: 0px !important;
	}
	@media screen and (min-width: 768px) {
    #carrusel-top {
        margin-top: -40px;
    }


	@media (min-width: 769px) {
		.search-icon {
			display: none !important;
		}
	}

	/* Mostrar en móvil */
	@media (max-width: 768px) {
		.search-icon {
			display: block !important;
		}
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
	.woocommerce div.product .woocommerce-tabs ul.tabs li {
		background-color: transparent;
		border: none;
		border-radius: 0;
		border-right: 0px solid #ececec;
		cursor: pointer;
		margin: 0;
		padding: 0;
		max-width: 500px !important;
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
		margin-left:30px !important;
		/*top: -10px;
		left: -20px;*/
	}
}
</style>
<header class="masterheader desktop-header header-style-1" style="color:#000 !important;">
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
			<div class="top-header" style="height:120px;">
				<div class="__os-container__">
					<div class="os-row">
						<div class="os-col left-col">
							<div class="os-col logo-col">
								<div class="site-branding">
									<h1 class="site-logo">
									<a href="https://www.farmanostica.cl/" class="custom-logo-link" rel="home" aria-current="page"><img fetchpriority="high" width="1168" height="141" src="https://www.farmanostica.cl/wp-content/uploads/2024/05/cropped-cropped-cropped-logo-colorv1-1-1.png" class="custom-logo" alt="Farmanostica" decoding="async" srcset="https://www.farmanostica.cl/develop/wp-content/uploads/2024/05/cropped-logo-colorv1-1.png 1168w, https://www.farmanostica.cl/wp-content/uploads/2024/05/cropped-cropped-logo-letra-300x36.png 300w, https://www.farmanostica.cl/wp-content/uploads/2024/05/cropped-cropped-logo-letra-1024x124.png 1024w, https://www.farmanostica.cl/wp-content/uploads/2024/05/cropped-cropped-logo-letra-768x93.png 768w, https://www.farmanostica.cl/wp-content/uploads/2024/05/cropped-cropped-logo-letra-600x72.png 600w" sizes="(max-width: 1168px) 100vw, 1168px"></a>
									</h1>
								</div><!-- site-branding -->
							</div>
						</div>
						<div class="os-col header-search">
							<?php get_search_form(); ?>
						</div>
						<div class="os-col right-col">
								<div class="os-row">
									<div class="os-col">
										<span class="header-address">
											<a href="https://maps.app.goo.gl/81uSKHYmhM9MkrHcA" target="_blank"><img style="width:100%;" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/DIRECCION.webp"></a>
										</span>
									</div>
									<div class="os-col">
										<ul style="display:flex;list-style: none; margin:0px !important;">
											<li style="margin:0px !important;"><a href="./mi-cuenta/edit-account/"><img style="max-height:40px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO CUENTA.webp"></a></li>
											<li style="margin:0px !important;">
												<a href="#" id="fkcart-floating-toggler" class="fkcart-toggler" style="all: unset; cursor: pointer; display: inline-block;">
					  									<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>					
													<img class="fas fa-shopping-cart" style="max-height:40px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO CARRITO.webp">
												</a>
											</li>
											<li style="margin:0px !important;"><a href="https://www.instagram.com/farmanostica/" target="_blank"><img style="max-height:40px" src="https://www.farmanostica.cl/develop/wp-content/uploads/2025/07/ICONO INSTAGRAM.webp"></a></li>
										</ul>
									</div>
								</div>


							<!--<div class="topbar-items" style="border:1px solid #000;">
								<?php

								/*$orchid_store_top_header_left_item = orchid_store_get_option( 'display_menu_or_login_register_link' );

								if ( 'login_register' === $orchid_store_top_header_left_item ) {
	
									do_action( 'orchid_store_user_links' );
								} else {
			
									do_action( 'orchid_store_top_header_menu' );
								}*/
								?>
							</div>
						</div>-->
						<?php
						$orchid_store_social_links = orchid_store_get_option( 'top_header_social_links' );

						if ( ! empty( $orchid_store_social_links ) ) {

							$orchid_store_social_links_array = explode( ',', $orchid_store_social_links );
							?>
							<div class="os-col right-col">
								<div class="social-icons">
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
							</div><!-- .os-col.right-col -->
							<?php
						}
						?>
						
					</div><!-- .os-row -->
					
				</div><!-- .__os-container__ -->
			</div><!-- .top-header -->
			<?php
		}
		?>
		<div class="mid-header">
			<div class="__os-container__">
				<div class="os-row <?php orchid_store_logo_row_class(); ?>">
					<div class="os-col logo-col">
						<?php
						/**
						 * Hook - orchid_store_desktop_site_identity.
						 *
						 * @hooked orchid_store_desktop_site_identity_action - 10
						 */
						do_action( 'orchid_store_desktop_site_identity' );
						?>
					</div><!-- .os-col.logo-col -->
					<?php
					$orchid_store_display_product_search = orchid_store_get_option( 'display_product_search_form' );
					$orchid_store_display_wishlist_icon  = orchid_store_get_option( 'display_wishlist' );
					$orchid_store_display_minicart       = orchid_store_get_option( 'display_mini_cart' );

					if (
						$orchid_store_display_product_search ||
						$orchid_store_display_minicart ||
						$orchid_store_display_wishlist_icon
					) {
						?>
						<div class="os-col extra-col">
							<div class="aside-right">
								<?php
								if ( $orchid_store_display_product_search ) {

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
								}

								if (
									class_exists( 'WooCommerce' ) &&
									(
										$orchid_store_display_minicart ||
										$orchid_store_display_wishlist_icon
									)
								) {
									?>
									<div class="wishlist-minicart-wrapper">
										<div class="wishlist-minicart-inner">
										<?php
										if ( $orchid_store_display_wishlist_icon ) {

											/**
											* Hook - orchid_store_wishlist_icon.
											*
											* @hooked orchid_store_wishlist_icon_action - 10
											*/
											do_action( 'orchid_store_wishlist_icon' );
										}

										if ( $orchid_store_display_minicart ) {

											/**
											* Hook - orchid_store_mini_cart.
											*
											* @hooked orchid_store_mini_cart_action - 10
											*/
											do_action( 'orchid_store_mini_cart' );
										}
										?>
										</div><!-- . wishlist-minicart-inner -->
									</div>
									<?php
								}
								?>
							</div><!-- .aside-right -->
						</div><!-- .os-col.extra-col -->
						<?php
					}
					?>
				</div><!-- .os-row -->
			</div><!-- .__os-container__ -->
		</div><!-- .mid-header -->
		<div class="bottom-header">
			<div class="main-navigation"> 
				<div class="__os-container__">
					<div class="os-row os-nav-row <?php orchid_store_menu_row_class(); ?>">
						<?php
						if ( orchid_store_get_option( 'display_special_menu' ) ) {
							?>
							<div class="os-col os-nav-col-left">
								<div class="category-navigation">
									<button class="cat-nav-trigger">
										<?php
										$orchid_store_special_menu_title = orchid_store_get_option( 'special_menu_title' );
										if ( ! empty( $orchid_store_special_menu_title ) ) {
											?>
											<span class="title"><?php echo esc_html( $orchid_store_special_menu_title ); ?></span>
											<?php
										}
										?>
										<span class="icon">
											<span class="line"></span>
											<span class="line"></span>
											<span class="line"></span>
										</span>
									</button><!-- . cat-nav-trigger -->

									<?php
									/**
									 * Hook - orchid_store_secondary_navigation.
									 *
									 * @hooked orchid_store_secondary_navigation_action - 10
									 */
									do_action( 'orchid_store_secondary_navigation' );
									?>
								</div><!-- .site-navigation category-navigation -->
							</div><!-- .os-col.os-nav-col-left -->
							<?php
						}
						?>
						<div class="os-col os-nav-col-right">
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
						</div><!-- // os-col os-nav-col-right -->
					</div><!-- // os-row os-nav-row -->
				</div><!-- .__os-container__ -->
			</div><!-- .main-navigation -->
		</div><!-- .bottom-header -->
	</div><!-- .header-inner -->
</header><!-- .masterheader.header-style-1 -->
