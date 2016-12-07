//NOTE: this function is intended to be put in the theme folder
// in a file called "functions.php"

function twentysixteen_enqueue_styles() {

    $parent_style = 'twentysixteen-style'; // This is 'twentysixteen-style' for the Twenty Sixteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'twenty-sixteen-child',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('1.0.0')
    );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_enqueue_styles' );
