<?php
// /** Step 2 (from text above). */
// add_action( 'admin_menu', 'rvamag_theme_menu' );

// /** Step 1. */
// function rvamag_theme_menu() {
//     $page_title = 'RVA Magazine';
//     $menu_title = 'RVA Mag';
//     $capability = 'manage_options';
//     $menu_slug = 'rvamag_theme_options';
//     $function = 'rva_theme_options';
//     $icon_url = null;
//     $position = 2;

//     add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

//     add_submenu_page( $menu_slug, 'Social Media', 'Social Media', $capability, $menu_slug.'_social_media', 'rva_social_settings_box');

//     /*
//      * References admin-socialmedia.php
//      */
//     add_submenu_page( $menu_slug, 'Advertizing', 'Advertizing', $capability, $menu_slug.'_advertizing', 'rva_advertizing_options');
// }

// /*
//  * 
//  */
// function rva_theme_options() {
// 	if ( !current_user_can( 'manage_options' ) )  {
// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
// 	}
// 	echo '<div class="wrap">';
// 	echo '<p>Here is where the form would go if I actually had options.</p>';
// 	echo '</div>';
// }

// /*
//  * 
//  */
// function rva_socialmedia_options() {
// 	if ( !current_user_can( 'manage_options' ) )  {
// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
// 	}
// 	echo '<div class="wrap">';
// 	echo '<p>Here is where the form would go if I actually had Social Media options.</p>';
// 	echo '</div>';
// }

// function rva_advertizing_options() {
// 	if ( !current_user_can( 'manage_options' ) )  {
// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
// 	}
// 	echo '<div class="wrap">';
// 	echo '<p>Here is where the form would go if I actually had Advertising options.</p>';
// 	echo '</div>';
// }

class RvaAdminSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    private $option_name = 'rva_admin_options';
    private $option_group = "rva_admin_option_group";

    private $page_title = 'RVA Magazine Admin';
    private $menu_title = 'RVA Mag Settings';
    private $capability = 'manage_options';
    private $menu_slug = 'rvamag-admin';
    private $function = 'create_admin_page';
    private $icon_url = null;
    private $position = 2;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_menu_page()
    {

        // This will be a toplevel menu in the second spot.
        add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array( $this, $this->function ), $this->icon_url, $this->position );

        //add_submenu_page( $this->menu_slug, 'Social Media', 'Social Media', $this->capability, $this->menu_slug.'-social-media', 'rva_social_settings_box');

        //add_submenu_page( $this->menu_slug, 'Advertizing', 'Advertizing', $this->capability, $this->menu_slug.'-advertizing', 'rva_advertizing_options');
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( $this->option_name );

        var_dump($this->options);

        ?>
        <div class="wrap">
            <h1> <?php $this->page_title; ?> </h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( $this->option_group );
                do_settings_sections( $this->menu_slug );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {   
        $section_id = "rva_admin_front_page_settings_id";

        register_setting(
            $this->option_group, // Option group
            $this->option_name, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        
        add_settings_section(
            $section_id, // ID
            'Front Page Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            $this->menu_slug // Page
        );  

        add_settings_field(
            'subscribe_email_image', // ID
            'Subscribe Mailing List Image', // Title 
            array( $this, 'subscribe_email_image_callback' ), // Callback
            $this->menu_slug, // Page
            $section_id // Section           
        );      

        add_settings_field(
            'subscribe_magazine_image', 
            'Subscribe Magazine Image', 
            array( $this, 'subscribe_magazine_image_callback' ), 
            $this->menu_slug, 
            $section_id
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your Front Page settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function subscribe_email_image_callback()
    {
        $setting_id = 'subscribe_email_image';
        $this->print_form_text_input($this->options, $this->option_name, $setting_id );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function subscribe_magazine_image_callback()
    {
        $setting_id = 'subscribe_magazine_image';
        $this->print_form_text_input($this->options, $this->option_name, $setting_id );
        // printf(
        //     '<input type="text" id="'.$setting_id.'" name="my_option_name['.$setting_id.']" value="%s" />',
        //     isset( $this->options[$setting_id] ) ? esc_attr( $this->options[$setting_id]) : ''
        // );
    }

    function print_form_text_input($options, $option_name, $setting_id ) {
        printf(
            '<input type="text" id="'.$setting_id.'" name="'.$option_name.'['.$setting_id.']" value="%s" />',
            isset( $options[$setting_id] ) ? esc_attr( $options[$setting_id]) : ''
        );
    }

    public function media_selector_settings_page_callback() {

        // Save attachment ID
        if ( isset( $_POST['submit_image_selector'] ) && isset( $_POST['image_attachment_id'] ) ) :
            update_option( 'media_selector_attachment_id', absint( $_POST['image_attachment_id'] ) );
        endif;

        wp_enqueue_media();

        ?><form method='post'>
            <div class='image-preview-wrapper'>
                <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( 'media_selector_attachment_id' ) ); ?>' height='100'>
            </div>
            <input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
            <input type='hidden' name='image_attachment_id' id='image_attachment_id' value='<?php echo get_option( 'media_selector_attachment_id' ); ?>'>
            <input type="submit" name="submit_image_selector" value="Save" class="button-primary">
        </form><?php
    }
}

if( is_admin() )
    $rva_admin_settings_page = new RvaAdminSettingsPage();
