add_action( 'after_setup_theme', 'yourtheme_setup' );
 
function yourtheme_setup() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
}