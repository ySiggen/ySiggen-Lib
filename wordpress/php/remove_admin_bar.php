//NOTE: this function is intended to be put in the theme folder
// in a file called "functions.php"

//Remove admin bar for non admins
function remove_admin_bar(){
    if (!current_user_can('administrator') && !is_admin()){
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');
