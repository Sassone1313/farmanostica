<?php
/*
Plugin Name: Funciones
Plugin URI: https://farmanostica.cl
Description: Plugin para liberar de funciones el fichero <code>functions.php</code> y activarlo a placer (o no) .
Version: 1.0
Author: Francisco López
Author URI: https://farmanostica.cl
License: GPLv2 o posterior
*/

/** 
* Modificaciones a menu de mi cuenta 
*/
function my_account_menu_order() {
 	$menuOrder = array(
		'edit-account'    => __( 'Mis datos', 'woocommerce' ),
 		'orders'             => __( 'Tus pedidos', 'woocommerce' ),
 		//'downloads'          => __( 'Tus descargas', 'woocommerce' ),
 		'edit-address'       => __( 'Direcciones', 'woocommerce' ),
		'payment-methods'       => __( 'Métodos de pago', 'woocommerce' ), 		
 		'customer-logout'    => __( 'Salir', 'woocommerce' ),
		//'dashboard'          => __( 'Inicio', 'woocommerce' ),
 	);
 	return $menuOrder;
 }
 add_filter ( 'woocommerce_account_menu_items', 'my_account_menu_order' );

/** 
* Oculta wishlist
*/ 
if( ! function_exists( 'yith_wcwl_selectively_hide_add_to_wishlist' ) ) {
	function yith_wcwl_selectively_hide_add_to_wishlist( $show ) {
		/**
		 * @var $product \WC_Product
		 */
		global $product;

			$show = false;
		
		return $show;
	}
	add_filter( 'yith_wcwl_show_add_to_wishlist', 'yith_wcwl_selectively_hide_add_to_wishlist' );
}

/** 
* Oculta versiones 
*/
remove_action('wp_head', 'wp_generator');

function remove_version_info() {
	return '';
}
add_filter('the_generator', 'remove_version_info');

function remove_version_from_style_js( $src ) {
	if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'remove_version_from_style_js',9999);
add_filter( 'script_loader_src', 'remove_version_from_style_js',9999);

/** 
* Error al iniciar sesion 
*/
function no_wordpress_errors(){
	return 'There is an error.';
}
add_filter( 'login_errors', 'no_wordpress_errors' );

/** 
* Agrega file upload en checkout
*/
/*add_action( 'woocommerce_after_checkout_billing_form', 'misha_file_upload_field' );

function misha_file_upload_field() {
	?>
		<p class="form-row form-row-wide">
			<label for="misha_file">Subir documento</label>
			<span class="woocommerce-input-wrapper">
				<input type="file" id="misha_file" name="misha_file" />
				<input type="hidden" name="misha_file_field" />
				<div id="misha_filelist"></div>
			</span>			
		</p>
	<?php
}*/



add_action( 'woocommerce_single_product_summary', 'detalle_producto', 21 );
function detalle_producto() {
	global $product;
	$upload_dir   = wp_upload_dir();
	$receta = 'pa_receta';
	$bio = 'pa_bio';
	$valuereceta = $product->get_attribute( $receta );
	$valuebio = $product->get_attribute( $bio );
	
	/*if ( $valuebio == 'Si' ) {
        $labelbio = get_taxonomy( $bio )->labels->singular_name;
		$imgbio = $upload_dir['baseurl']."/2023/08/bioequivalente.jpeg";
        echo '<p style="display: inline-block;"><img style="width: 50%;" src="'.$imgbio.'"></p>';	
    }*/  
	if ( $valuereceta == 'Si' ) {
        $labelreceta = get_taxonomy( $receta )->labels->singular_name;
        echo '<p><b>Requiere receta &nbsp;</b><i aria-hidden="true" style="vertical-align: middle; color:gray;" class="bx bx-receipt bx-sm bx-border"></i></p>';	
    }	      
}

//agrega principio activo
add_action( 'woocommerce_single_product_summary', 'principio_activo', 6 );
function principio_activo() {
	global $product;
	$precio = $product->get_price();
	$principioactivo = 'pa_principio-activo';
	$forma = 'pa_forma-farmaceutica';
	$comprimidos = 'pa_comprimidos';
	$valueprincipioactivo = $product->get_attribute( $principioactivo );
	$valueforma = $product->get_attribute( $forma );
	$valuecomprimidos = $product->get_attribute( $comprimidos );
	if ($valueprincipioactivo) {
        $labelprincipio = get_taxonomy( $principioactivo )->labels->singular_name;
        echo '<p style="margin:0 0 0 5px;">'.$labelprincipio.': '.$valueprincipioactivo.'</p>';	
    }
	if ($valueforma) {
        $labelforma = get_taxonomy( $forma )->labels->singular_name;
        echo '<p style="margin:0 0 0 5px;">'.$labelforma.': '.$valueforma.'</p>';	
    }
	echo '<p><hr>&nbsp;</p>';
	if ($valueforma == 'Comprimidos'){
		$valorcomprimido = $precio/$valuecomprimidos;
		echo '<p style="margin:0 0 0 0px; color:gray;"><small><i>Precio por unidad: $'.$valorcomprimido.' por COMPRIMIDOS</i></small></p>';
	}
	
}
/** 
* Agrega file upload en producto
// Field validation
add_action( 'woocommerce_add_to_cart_validation', 'validate_receta' );
function validate_receta( $passed ) {
    $error_notice = array(); // Initializing
    
    if ( isset($_POST['receta']) && empty($_POST['receta']) ) {
        $passed = false;
        $error_notice[] = __('Receta requerida', 'woocommerce');
    }
    
    // Display errors notices
    if ( ! empty($error_notice) ) {
        wc_add_notice( implode('<br>', $error_notice), 'error' );
    }
    
    return $passed;
}

// Save as custom cart item data
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data', 10, 2 );
function add_cart_item_custom_data( $cart_item_data, $product_id ) {
    if ( isset($_POST['receta']) && ! empty($_POST['receta']) ) {
        $cart_item_data['receta'] = sanitize_text_field($_POST['receta']);
    }
    
    return $cart_item_data;
}

// Display in cart and checkout
add_filter( 'woocommerce_get_item_data', 'display_on_cart_and_checkout', 10, 2 );
function display_on_cart_and_checkout( $cart_data, $cart_item ) {
    if ( isset($cart_item['receta']) ) {
        $cart_data[] = array( "name" => __("Receta", "woocommerce"),  "value" => $cart_item['receta'] );
    }
    
    return $cart_data;
}

// Display on orders and email notifications (save as custom order item meta data)
add_action( 'woocommerce_checkout_create_order_line_item', 'display_on_orders_and_emails', 10, 4 );
function display_on_orders_and_emails( $item, $cart_item_key, $values, $order ) {
    if ( isset($values['receta']) ) {
        $item->add_meta_data( __("Receta", "woocommerce"), $values['receta'] );
    }
}
*/

add_action( 'woocommerce_after_order_notes', 'bbloomer_checkout_file_upload' );
 
function bbloomer_checkout_file_upload() {	
	$taxonomy = 'pa_receta';
	$receta = null;
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		// Get product
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		// Get custom attribute
		$atributo = $_product->get_attribute($taxonomy);
		if($atributo == 'Si'){ $receta = "true"; }		
	}

	if ($receta == "true") {
		echo "Tu pedido requiere receta, adjuntar a continuación";
		echo '<p class="form-row"><label for="appform">Receta<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="file" id="appform" name="appform" accept=".pdf" required><input type="hidden" name="appform_field" /></span></p>';
	//echo '<p class="form-row"><label for="appform">Application Form (PDF)<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="file" id="appform" name="appform" accept=".pdf" required><input type="hidden" name="appform_field" /></span></p>';
	wc_enqueue_js("
		$( '#appform' ).change( function() {
			if ( this.files.length ) {
				const file = this.files[0];
				const formData = new FormData();
				formData.append( 'appform', file );
				$.ajax({
					url: wc_checkout_params.ajax_url + '?action=appformupload',
					type: 'POST',
					data: formData,
					contentType: false,
					enctype: 'multipart/form-data',
					processData: false,
					success: function ( response ) {
						$( 'input[name=\"appform_field\"]' ).val( response );
					}
				});
			}
		});
	");
	}
}
 
add_action( 'wp_ajax_appformupload', 'bbloomer_appformupload' );
add_action( 'wp_ajax_nopriv_appformupload', 'bbloomer_appformupload' );
 
function bbloomer_appformupload() {
   global $wpdb;
   $uploads_dir = wp_upload_dir();
   if ( isset( $_FILES['appform'] ) ) {
      if ( $upload = wp_upload_bits( $_FILES['appform']['name'], null, file_get_contents( $_FILES['appform']['tmp_name'] ) ) ) {
         echo $upload['url'];
      }
   }
   die;
}
 
add_action( 'woocommerce_checkout_process', 'bbloomer_validate_new_checkout_field' );
   
function bbloomer_validate_new_checkout_field() {
	$taxonomy = 'pa_receta';
	$receta = null;
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		// Get product
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		// Get custom attribute
		$atributo = $_product->get_attribute($taxonomy);
		if($atributo == 'Si'){ $receta = "true"; }		
	}
	if ($receta == "true") {
		if ( empty( $_POST['appform_field'] ) ) {
			wc_add_notice( 'Por favor, adjuntar receta para proceder con tu pedido.', 'error' );
		}
	}
}
 
add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_save_new_checkout_field' );
   
function bbloomer_save_new_checkout_field( $order_id ) { 
   if ( ! empty( $_POST['appform_field'] ) ) {
      update_post_meta( $order_id, '_application', $_POST['appform_field'] );
   }
}
   
add_action( 'woocommerce_admin_order_data_after_billing_address', 'bbloomer_show_new_checkout_field_order', 10, 1 );
    
function bbloomer_show_new_checkout_field_order( $order ) {    
   $order_id = $order->get_id();
   if ( get_post_meta( $order_id, '_application', true ) ) echo '<p><strong>Receta:</strong> <a href="' . get_post_meta( $order_id, '_application', true ) . '" target="_blank">' . get_post_meta( $order_id, '_application', true ) . '</a></p>';
}
  
add_action( 'woocommerce_email_after_order_table', 'bbloomer_show_new_checkout_field_emails', 20, 4 );
   
function bbloomer_show_new_checkout_field_emails( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $sent_to_admin && get_post_meta( $order->get_id(), '_application', true ) ) echo '<p><strong>Receta:</strong> ' . get_post_meta( $order->get_id(), '_application', true ) . '</p>';
}

//agrega banner bio
add_filter( 'woocommerce_single_product_summary', 'banner_image',45 );
function banner_image()
{
	global $product;
	$upload_dir   = wp_upload_dir();
	$bio = 'pa_bio';
	$valuebio = $product->get_attribute( $bio );
	
	if ( $valuebio == 'Si' ) {
        $labelbio = get_taxonomy( $bio )->labels->singular_name;
		$imgbio = $upload_dir['baseurl']."/2023/09/logo_bioequivalente_ancho.png";
		echo '<img src="'.$imgbio.'" alt="Bioequivalente" />';
    }
}
