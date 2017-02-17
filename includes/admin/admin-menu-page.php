<?php

/**
* Enqueue Scripts for this page.
*/
add_action( 'admin_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts($hook) {

    wp_enqueue_script( 'rva_admin_js', get_stylesheet_directory_uri() . '/build/js/admin.js', array( 'jquery' ), '1.0', true );
}

class RvaAdminSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */

    private $page_title = 'RVA Magazine Admin';
    private $menu_title = 'RVA Mag Settings';
    private $capability = 'manage_options';
    private $menu_slug = 'rvamag-admin';
    private $function = 'create_admin_page';
    private $icon_url = null;
    private $position = 2;

    private $options;

    private $option_name = 'rva_admin_options';
    private $option_group = 'rva_admin_option_group';
    private $hook = '';
    
    /**
     * Start up
     */
    public function __construct()
    {
        //add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        //add_action( 'admin_init', array( $this, 'page_init' ) );
    }


    public function admin_menu_page_js_args() {
        ?> 
        <script type='text/javascript'>
            jQuery(document).ready( function($){
                rva_admin.bind_media_picker('#btn_upload_subscribe_email_image', '#image_preview_subscribe_email_image', '#subscribe_email_image');
                rva_admin.bind_media_picker('#btn_upload_subscribe_magazine_image', '#image_preview_subscribe_magazine_image', '#subscribe_magazine_image');
            });
        </script>
        <?php
    }


    /**
     * Add options page
     */
    public function add_menu_page()
    {
        // This will be a toplevel menu in the second spot.
       $this->hook =  add_menu_page( $this->page_title, 
            $this->menu_title, 
            $this->capability, 
            $this->menu_slug, 
            array( $this, $this->function ), 
            $this->icon_url, $this->position 
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( $this->option_name );
        ?>
        <div class="wrap">
            <h1> <?php $this->page_title; ?> </h1>
            <?php settings_errors(); ?>
            <form method="post" action="options.php">
            <?php
                $this->admin_menu_page_js_args();
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
        $section_id = "settings_section_id";

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
        if( isset( $input['subscribe_email_image'] ) )
            $new_input['subscribe_email_image'] = absint( $input['subscribe_email_image'] );

        if( isset( $input['subscribe_magazine_image'] ) )
            $new_input['subscribe_magazine_image'] = absint( $input['subscribe_magazine_image'] );

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
        $this->print_media_selector($this->options, $this->option_name, $setting_id );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function subscribe_magazine_image_callback()
    {
        $setting_id = 'subscribe_magazine_image';
        $this->print_media_selector($this->options, $this->option_name, $setting_id );
    }

    function print_form_text_input( $options, $option_name, $setting_id ) {
        printf(
            '<input type="text" id="'.$setting_id.'" name="'.$option_name.'['.$setting_id.']" value="%s" />',
            isset( $options[$setting_id] ) ? esc_attr( $options[$setting_id]) : ''
        );
    }
    
    public function print_media_selector( $options, $option_name, $setting_id ) {

        wp_enqueue_media();
        ?>
            <div class='image-preview-wrapper'>
                <?php printf( 
                    '<img id="image_preview_'.$setting_id.'" src="%s" height="100">',
                    isset( $options[$setting_id] ) ? wp_get_attachment_url( esc_attr( $options[$setting_id]) ) : ''
                ); ?>
            </div>
            <input id="btn_upload_<?php echo $setting_id; ?>" type="button" class="button" value="<?php _e( 'Select Image' ); ?>" />
            
           <?php printf( 
               '<input type="hidden" id="'.$setting_id.'" name="'.$option_name.'['.$setting_id.']" value="%s" />',
                isset( $options[$setting_id] ) ? esc_attr( $options[$setting_id] ) : ''
            ); ?>
        <?php
    }
}

if( is_admin() )
    $rva_admin_settings_page = new RvaAdminSettingsPage();
