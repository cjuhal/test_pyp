<?php
remove_action( 'gallery', 'gallery_shortcode' );
add_shortcode( 'gallery', 'gallery_shortcode_valakax' );



/**
 * Builds the Gallery shortcode output.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * WordPress images on a post.
 *
 * @since 2.5.0
 *
 * @staticvar int $instance
 *
 * @param array $attr {
 *     Attributes of the gallery shortcode.
 *
 *     @type string       $order      Order of the images in the gallery. Default 'ASC'. Accepts 'ASC', 'DESC'.
 *     @type string       $orderby    The field to use when ordering the images. Default 'menu_order ID'.
 *                                    Accepts any valid SQL ORDERBY statement.
 *     @type int          $id         Post ID.
 *     @type string       $itemtag    HTML tag to use for each image in the gallery.
 *                                    Default 'dl', or 'figure' when the theme registers HTML5 gallery support.
 *     @type string       $icontag    HTML tag to use for each image's icon.
 *                                    Default 'dt', or 'div' when the theme registers HTML5 gallery support.
 *     @type string       $captiontag HTML tag to use for each image's caption.
 *                                    Default 'dd', or 'figcaption' when the theme registers HTML5 gallery support.
 *     @type int          $columns    Number of columns of images to display. Default 3.
 *     @type string|array $size       Size of the images to display. Accepts any valid image size, or an array of width
 *                                    and height values in pixels (in that order). Default 'thumbnail'.
 *     @type string       $ids        A comma-separated list of IDs of attachments to display. Default empty.
 *     @type string       $include    A comma-separated list of IDs of attachments to include. Default empty.
 *     @type string       $exclude    A comma-separated list of IDs of attachments to exclude. Default empty.
 *     @type string       $link       What to link each image to. Default empty (links to the attachment page).
 *                                    Accepts 'file', 'none'.
 * }
 * @return string HTML content to display gallery.
 */
function gallery_shortcode_valakax( $attr ) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	/**
	 * Filters the default gallery shortcode output.
	 *
	 * If the filtered output isn't empty, it will be used instead of generating
	 * the default gallery template.
	 *
	 * @since 2.5.0
	 * @since 4.2.0 The `$instance` parameter was added.
	 *
	 * @see gallery_shortcode()
	 *
	 * @param string $output   The gallery output. Default empty.
	 * @param array  $attr     Attributes of the gallery shortcode.
	 * @param int    $instance Unique numeric ID of this gallery shortcode instance.
	 */
	$output = apply_filters( 'post_gallery', '', $attr, $instance );
	if ( $output != '' ) {
		return $output;
	}

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts  = shortcode_atts(
		array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure' : 'dl',
			'icontag'    => $html5 ? 'div' : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => '',
		),
		$attr,
		'gallery'
	);

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts(
			array(
				'include'        => $atts['include'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'exclude'        => $atts['exclude'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	} else {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag    = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag    = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns   = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float     = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';

	/**
	 * Filters whether to print default gallery styles.
	 *
	 * @since 3.1.0
	 *
	 * @param bool $print Whether to print default gallery styles.
	 *                    Defaults to false if the theme supports HTML5 galleries.
	 *                    Otherwise, defaults to true.
	 */
	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class  = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

	/**
	 * Filters the default gallery shortcode CSS styles.
	 *
	 * @since 2.5.0
	 *
	 * @param string $gallery_style Default CSS styles and opening HTML div container
	 *                              for the gallery shortcode output.
	 */
	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link_valakax( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image_valakax( $id, $atts['size'], false, $attr, true );
		} else {
			$image_output = wp_get_attachment_link_valakax( $id, $atts['size'], true, false, false, $attr );
		}
		$image_meta = wp_get_attachment_metadata( $id );

		$orientation = '';
		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";
			if ( $captiontag && trim( $attachment->post_title ) ) {
			$output .= "
			<{$captiontag} class='gallery-text-ch wp-caption-text bold mt-1 c-violeta'>
			" . wptexturize( $attachment->post_title ) . "
			</{$captiontag}>";
		}
		if ( $captiontag && trim( $attachment->post_excerpt ) ) {
			$output .= "
				<{$captiontag} class='gallery-text-ch wp-caption-text' id='$selector-$id'>
				" . wptexturize( $attachment->post_excerpt ) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
}

/*funcion para remplazar el html de foto*/
function wp_get_attachment_image_valakax( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '', $background = false ) {
	$html  = '';
	$image = wp_get_attachment_image_src( $attachment_id, $size, $icon );
	if ( $image ) {
		list($src, $width, $height) = $image;
		$hwstring                   = image_hwstring( $width, $height );
		$size_class                 = $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$attachment   = get_post( $attachment_id );
		$default_attr = array(
			'src'   => $src,
			'class' => "attachment-$size_class size-$size_class",
			'alt'   => trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ),
		);

		$attr = wp_parse_args( $attr, $default_attr );

		// Generate 'srcset' and 'sizes' if not already present.
		if ( empty( $attr['srcset'] ) ) {
			$image_meta = wp_get_attachment_metadata( $attachment_id );

			if ( is_array( $image_meta ) ) {
				$size_array = array( absint( $width ), absint( $height ) );
				$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
				$sizes      = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

				if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
					$attr['srcset'] = $srcset;

					if ( empty( $attr['sizes'] ) ) {
						$attr['sizes'] = $sizes;
					}
				}
			}
		}

		/**
		 * Filters the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param array        $attr       Attributes for the image markup.
		 * @param WP_Post      $attachment Image attachment post.
		 * @param string|array $size       Requested size. Image size or array of width and height values
		 *                                 (in that order). Default 'thumbnail'.
		 */
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
		$attr = array_map( 'esc_attr', $attr );
		if($background){
			$html = rtrim( '<div class="img-ch-size" ' );
			$html .= 'style="background-image:url('.$attr["src"].'");" ';
			$html .= ' ></div>';
		} else {
			$html = rtrim( "<img $hwstring" );
			foreach ( $attr as $name => $value ) {
				$html .= " $name=" . '"' . $value . '"';
			}
			$html .= ' />';
		}
	}

	return $html;
}

/*funcion para remplazar el link de imagenes*/
function wp_get_attachment_link_valakax( $id = 0, $size = 'thumbnail', $permalink = false, $icon = false, $text = false, $attr = '' ) {
	$_post = get_post( $id );

	if ( empty( $_post ) || ( 'attachment' !== $_post->post_type ) || ! $url = wp_get_attachment_url( $_post->ID ) ) {
		return __( 'Missing Attachment' );
	}

	if ( $permalink ) {
		$url = get_attachment_link( $_post->ID );
	}

	if ( $text ) {
		$link_text = $text;
	} elseif ( $size && 'none' != $size ) {
		$link_text = wp_get_attachment_image_valakax( $_post->ID, $size, $icon, $attr, true );
	} else {
		$link_text = '';
	}

	if ( '' === trim( $link_text ) ) {
		$link_text = $_post->post_title;
	}

	if ( '' === trim( $link_text ) ) {
		$link_text = esc_html( pathinfo( get_attached_file( $_post->ID ), PATHINFO_FILENAME ) );
	}
	/**
	 * Filters a retrieved attachment page link.
	 *
	 * @since 2.7.0
	 * @since 5.1.0 Added the $attr parameter.
	 *
	 * @param string       $link_html The page link HTML output.
	 * @param int          $id        Post ID.
	 * @param string|array $size      Size of the image. Image size or array of width and height values (in that order).
	 *                                Default 'thumbnail'.
	 * @param bool         $permalink Whether to add permalink to image. Default false.
	 * @param bool         $icon      Whether to include an icon. Default false.
	 * @param string|bool  $text      If string, will be link text. Default false.
	 * @param array|string $attr      Array or string of attributes. Default empty.
	 */
	return apply_filters( 'wp_get_attachment_link', "<a href='" . esc_url( $url ) . "'>$link_text</a>", $id, $size, $permalink, $icon, $text, $attr );
}

/**
 * Created by PhpStorm.
 * User: valakax
 * Date: 7/4/2018
 * Time: 16:21
 */

 /* AGREGAR IMAGEN A LAS ENTRADAS / POST*/
 add_post_type_support( 'post', 'thumbnail' );
 add_theme_support( 'post-thumbnails' );


/**
* configuro los formatos disponibles para el metabox de formatos
*/
add_action( 'after_setup_theme', 'wpsites_child_theme_posts_formats', 11 );
function wpsites_child_theme_posts_formats(){
 add_theme_support( 'post-formats', array(
    'quote',
    ) );
}


/* shortcode recuadro */
function recuadro_inicio($atts, $content = null){
    $p = shortcode_atts( array (
        'color' => 'turquesa'
    ), $atts );
    return '<div class="recuadro '.$p['color'].'">'.$content.'</div>';
}
add_shortcode('recuadro','recuadro_inicio');

/* shortcode conteiner*/
function conteiner_fx($atts, $content = null){
    $p = shortcode_atts( array (
        'color' => 'turquesa'
    ), $atts );
    return '<div style="width:100%; margin:15px 0px;">'.$content.'</div>';
}

add_shortcode('conteiner','conteiner_fx');

/* modificar el tamaño por default de un video de wordpress */

/*function size_video_wordpress_ch(){
	return array( 'width' => 300, 'height' => 150);
}
add_filter('embed_defaults', 'size_video_wordpress_ch');*/

/*configuracion del tamaño de iframe*/

function crunchify_embed_defaults($embed_size){
	$embed_size['width'] = 610;
	$embed_size['height'] = 500;
	return $embed_size;
}
add_filter('embed_defaults', 'crunchify_embed_defaults');



/* 
recibo una categoria y me fijo a que padre pertenece,
 dependiendo de ello el link seteado sera a su propia pagina
  de categorias o a una personalizada en slug
  */
function get_link_category_valakax($category){
	if ($category->parent == 7){
		return '/'.$category->slug;
	} else {
		return get_category_link( $category->term_id );
	}
}


/* agregar class a una funcion del theme silent*/
function valakax_menu_classes($classes, $item, $args){ 
    if ($args->theme_location == 'top_nav') // como nombraste el menu  // linea 262 en header.php
    { 
    $classes[] = 'nav-item nav-link';
    } 
    return $classes; 
    }
    
	add_filter('nav_menu_css_class', 'valakax_menu_classes',1,3);

/* personalizar colores del editor de wordpresss*/

function wp_dinapyme_personalizar_colores_mce( $opciones ) {

	// el array $colores_base contiene los colores estándar del editor de WordPress
	$colores_base = '
			    "000000", "Negro", 
			    "993300", "Burnt orange",
			    "333300", "Dark olive",
			    "003300", "Dark green",
			    "003366", "Dark azure",
			    "000080", "Navy Blue",
			    "333399", "Indigo",
			    "333333", "Very dark gray",
			    "800000", "Maroon",
			    "FF6600", "Orange",
			    "808000", "Olive",
			    "008000", "Green",
			    "008080", "Teal",
			    "0000FF", "Blue",
			    "666699", "Grayish blue",
			    "808080", "Gray",
			    "FF0000", "Red",
			    "FF9900", "Amber",
			    "99CC00", "Yellow green",
			    "339966", "Sea green",
			    "33CCCC", "Turquoise",
			    "3366FF", "Royal blue",
			    "800080", "Purple",
			    "999999", "Medium gray",
			    "FF00FF", "Magenta",
			    "FFCC00", "Gold",
			    "FFFF00", "Yellow",
			    "00FF00", "Lime",
			    "00FFFF", "Aqua",
			    "00CCFF", "Sky blue",
			    "993366", "Brown",
			    "C0C0C0", "Silver",
			    "FF99CC", "Pink",
			    "FFCC99", "Peach",
			    "FFFF99", "Light yellow",
			    "CCFFCC", "Pale green",
			    "CCFFFF", "Pale cyan",
			    "99CCFF", "Light sky blue",
			    "CC99FF", "Plum",
			    "FFFFFF", "White"
			';
	
	// la variable $mis_colores contiene los colores pesonalizados que añadimos.
	// Podemos añadir más colores al array.
	$mis_colores = '
	    			"73C69C", "Verde PYPSE",
	    			"601586", "Violeta PYPSE", 
	    			"E82A8A", "Magenta PYPSE",
					"00947F", "Amarillo PYPSE",
					"ffcc00", "Amarillo Oscuro PYPSE",
					"CA182A", "Salmon PYPSE",
					"061235", "Azul Oscuro PYPSE"
				';
				
	$opciones['textcolor_map'] = '['.$colores_base.', '.$mis_colores.']';  // asignamos al array texcolor_map los colores base + mis colores
	$opciones['textcolor_rows'] = 6;  // $mis_colores irán en la sexta fila
	
	return $opciones;
}

add_filter('tiny_mce_before_init', 'wp_dinapyme_personalizar_colores_mce');


/*
*	configuracion de paginado seteada en 5
*/
#-----------------------------------------------------------------#
# Search related
#-----------------------------------------------------------------#

if(!function_exists('change_wp_search_size_valakax')){
	function change_wp_search_size_valakax($query) {
		if ( $query->is_search )
			$query->query_vars['posts_per_page'] = 5;

		return $query;
	}
}
if(!is_admin()) {
	add_filter('pre_get_posts', 'change_wp_search_size_valakax');
}



/**
 * Display search form valakax.
 *
 */
function get_search_form_valakax() {

	$search_form_template = locate_template( 'search-form-valakax.php' );
	if ( '' != $search_form_template ) {
		ob_start();
		require( $search_form_template );
		$form = ob_get_clean();
	}

	/**
	 * Filters the HTML output of the search form.
	 *
	 * @since 2.7.0
	 *
	 * @param string $form The search form HTML output.
	 */
	$result = null;

	if ( $result === null ) {
		$result = $form;
	}

	echo $result;
}




//dropdown arrows
if ( !function_exists( 'valakax_custom_nav_menu' ) ) {
	function valakax_custom_nav_menu() {

		class Valakax_Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

			function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
				$item_class = $item->classes;
				if($args->show_carets && $args->walker->has_children){
					$clases_parent_child = ["nav-link dropdown-toggle"];
					array_push($item_class, $item->classes, $clases_parent_child);
					$attr_parent_child = 'role="button" data-bs-toggle="dropdown" aria-expanded="false"';
				}

				$output .= "<li class='" .  implode(" ", $item->classes) . "'". $attr_parent_child."id='navbarDropdown".$id."'>";
		 
				if ($item->url && $item->url != '#') {
					$output .= '<a href="' . $item->url . '">';
				} else {
					$output .= '<span>';
				}
		 
				$output .= $item->title;
		 
				if ($item->url && $item->url != '#') {
					$output .= '</a>';
				} else {
					if ($args->show_carets && $args->walker->has_children) {
						$output .= '<i style="height: fit-content;" class="caret fa fa-angle-down"></i>';
					}
					$output .= '</span>';
				}


			}
			
			/**
	 * Starts the list before the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu', 'dropdown-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names aria-labelledby='navbarDropdown'".$args->id.">{$n}";
	}


		}

	}
}

valakax_custom_nav_menu();


function HTML_custom_menu_valakax(){

	$menu = wp_nav_menu(array('theme_location' => 'top_nav','menu_class' => 'main-menu','container' => 'nav','container_class' => 'valakax_nav_menu','walker' => new Valakax_Custom_Walker_Nav_Menu(), 'show_carets' => true));

	return $menu;
}

add_shortcode( 'HTML_CUSTOM_MENU', 'HTML_custom_menu_valakax' );

function get_empty_search_result_valakax() {
	$emptyResult = '<span class="h3 teal">Sin Resultados</span>
				<div class="alert mt-3 p-2 recuadro rosa">
			 	 <p class="h5 p-4 recuadro" style="text-align: center">No se encontraron resultados, modifique su busqueda y vuelva a intentarlo</p>
				</div>';
	echo $emptyResult;
}
 /* buscador general insertado en top menu */
function general_search_menu_vlkx( $items, $args ) {
    return $items.'<li class="menu-item menu-item-object-category menu-item-type-taxonomy nav-item nav-link" style="background: transparent !important; padding:0px">'.do_shortcode('[wd_asp id=1]').'</li>';
	//'<li class="menu-item menu-item-type-post_type menu-item-object-page nav-item nav-link" style="background: transparent !important;padding: 0px;">'.do_shortcode('[ivory-search id="4070" title="Default Search Form"]').'</li>';
  }
  add_filter('wp_nav_menu_items','general_search_menu_vlkx', 10, 2);

function apply_desing_categories_post($desingPath, $the_query){
				if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$nectar_post_format = (get_post_format() == 'image' || get_post_format() == 'aside') ? false : get_post_format();
					get_template_part($desingPath, $nectar_post_format ); 
				}
			}else{ get_empty_search_result_valakax(); }
}

function get_filter_param(){
	return $_GET["filter"] ? $_GET["filter"] : ''; 
}

function get_search_categoires_post(){
	       			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					// filtro ingresado desde el buscador
					$valakax_filter = get_filter_param();
					// obtengo los datos de la pagina para obtener el slug de la categoria
					$page_object_category_info = get_queried_object();
					// seteo el array con los datos para el buscador de la bbdd
					$args = array(
								's' => $valakax_filter,
								'category_name' => $page_object_category_info->slug,
						        'posts_per_page' => 5,
                				'paged'=>$paged
							);
					// realizo la busqueda y la almaceno
					$the_query = new WP_Query( $args );
					return $the_query;
}
	function valakax_pagination($wp_custo_query) {

		global $options;
		//var_dump($wp_custo_query, $options['extra_pagination'] );
		//extra pagination
		if( !empty($options['extra_pagination']) && $options['extra_pagination'] == '1' ){


			    $wp_custo_query->query_vars['paged'] > 1 ? $current = $wp_custo_query->query_vars['paged'] : $current = 1;
			    $total_pages = $wp_custo_query->max_num_pages;

			    if ($total_pages > 1){

			      $permalink_structure = get_option('permalink_structure');
				  $query_type = (count($_GET)) ? '&' : '?';
			      $format = $query_type.'paged=%#%';
				  echo '<div id="pagination" data-is-text="'.__("All items loaded", NECTAR_THEME_NAME).'">';

			      echo paginate_links(array(
			          'base' => get_pagenum_link(1) . '%_%',
			          'format' => $format,
			          'current' => $current,
			          'total' => $total_pages,
			          'prev_text'    => 'Anterior',
    				  'next_text'    => 'Siguiente',
			        ));

				  echo  '</div>';

			    }
	}
		//regular pagination
		else{

			if( get_next_posts_link() || get_previous_posts_link() ) {
				echo '<div id="pagination" data-is-text="'.__("All items loaded", NECTAR_THEME_NAME).'">
				      <div class="prev">'.get_previous_posts_link('&laquo; Previous').'</div>
				      <div class="next">'.get_next_posts_link('NextPrevious &raquo;','').'</div>
			          </div>';

	        }
		}


	}


	function valakax_pagination_for_search($wp_custo_query) {

		global $options;
		if( !empty($options['extra_pagination']) && $options['extra_pagination'] == '1' ){

			    $wp_custo_query->query_vars['paged'] > 1 ? $current = $wp_custo_query->query_vars['paged'] : $current = 1;
			    $total_pages = $wp_custo_query->max_num_pages;

			    if ($total_pages > 1){

			      $permalink_structure = get_option('permalink_structure');
				  $query_type = (count($_GET));
			      $format = $query_type;
				  echo '<div id="pagination" data-is-text="'.__("All items loaded", NECTAR_THEME_NAME).'">';
			      echo paginate_links(array(
			          'base' => home_url().'/page/'.'%#%'.'/',
			          'format' => $format,
			          'current' => $current,
			          'total' => $total_pages,
			          'prev_text'    => 'Anterior',
    				  'next_text'    => 'Siguiente',
			        ));

				  echo  '</div>';

			    }
	}
		//regular pagination
		else{

			if( get_next_posts_link() || get_previous_posts_link() ) {
				echo '<div id="pagination" data-is-text="'.__("All items loaded", NECTAR_THEME_NAME).'">
				      <div class="prev">'.get_previous_posts_link('&laquo; Previous').'</div>
				      <div class="next">'.get_next_posts_link('NextPrevious &raquo;','').'</div>
			          </div>';

	        }
		}


	}

/*filtrado de pagina page, DEPRECADO SIN USO*/
//function get_form_page(){
//	$url = get_permalink();
//	$hasPage = strpos($link, '/page/' );
//	if($hasPage !== false ){
//		$auxlinkCode =  explode('/page/', $link);
//		return str_replace("/page/", "",$auxlinkCode[0]);
//	} else {
//		return $url;
//	}
//	
//}

function get_category_slug(){
	$term = get_queried_object();
    return $term->slug;
}


/* breadcrumbs */

function crear_breadcrumbs() {
    if (!is_front_page()) {
		echo '<div class="pypse_breadcrumb bg-teal "><div class="margin_pypse">';
        echo '<a href="/">Inicio</a> › ';
        if (is_category() || is_single() || is_page()) {
            if(is_category()){
                $category = get_the_category();
                echo $category[0]->cat_name;
            }else{
                the_category(' - ');
            }if(is_page()) {
                echo the_title();
            }if (is_single()) {
                echo " › ";
                the_title();
            }
        }
		echo '</div></div>';
    }
}
add_action( 'get_breadcrumbs_vlkx', 'crear_breadcrumbs' );