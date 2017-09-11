<?php
class SMYoutubeSubscribeSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_sm_youtube_subscribe_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_sm_youtube_subscribe_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'SM YouTube Subscribe', 
            'manage_options', 
            'sm-youtube-subscribe', 
            array( $this, 'create_sm_youtube_subscribe_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_sm_youtube_subscribe_admin_page()
    {
        // Set class property
        $this->options = get_option( 'sm_youtube_subscribe_options' );
        ?>
        <div class="wrap">
            <h1>SM YouTube Subscribe</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'sm_youtube_subscribe_option_group' );
                do_settings_sections( 'sm-youtube-subscribe' );
                submit_button();
            ?>
            </form>
            <hr/>
            <div class="shortcode_info" style="background: #fff;padding: 10px 20px;">
            	<h2>Short Code:</h2>
            	<code>[sm-youtube-subscribe]</code>
            </div>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'sm_youtube_subscribe_option_group', // Option group
            'sm_youtube_subscribe_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'SM YouTube Subscribe Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'sm-youtube-subscribe' // Page
        );  


        add_settings_field(
            'title', 
            'Title (<span>optional</span>)', 
            array( $this, 'sm_ytcs_title_callback' ), 
            'sm-youtube-subscribe', 
            'setting_section_id'
        );      

        add_settings_field(
            'sm_youtube_channel_id', // ID
            'YouTube Channel ID', // Title 
            array( $this, 'sm_youtube_channel_id_callback' ), // Callback
            'sm-youtube-subscribe', // Page
            'setting_section_id' // Section           
        );  

        add_settings_field(
            'sm_full_layout', // ID
            'Show Full Layout', // Title 
            array( $this, 'sm_full_layout_callback' ), // Callback
            'sm-youtube-subscribe', // Page
            'setting_section_id' // Section           
        );  

        add_settings_field(
            'sm_dark_theme', // ID
            'Show Dark Theme', // Title 
            array( $this, 'sm_dark_theme_callback' ), // Callback
            'sm-youtube-subscribe', // Page
            'setting_section_id' // Section           
        );  

        add_settings_field(
            'sm_subscriber_count_hide', // ID
            'Subscriber count hide', // Title 
            array( $this, 'sm_subscriber_count_hide_callback' ), // Callback
            'sm-youtube-subscribe', // Page
            'setting_section_id' // Section           
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
        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        if( isset( $input['sm_youtube_channel_id'] ) )
            $new_input['sm_youtube_channel_id'] = sanitize_text_field( $input['sm_youtube_channel_id'] );

        if( isset( $input['sm_full_layout'] ) )
            $new_input['sm_full_layout'] = sanitize_text_field( $input['sm_full_layout'] );

        if( isset( $input['sm_dark_theme'] ) )
            $new_input['sm_dark_theme'] = sanitize_text_field( $input['sm_dark_theme'] );

        if( isset( $input['sm_subscriber_count_hide'] ) )
            $new_input['sm_subscriber_count_hide'] = sanitize_text_field( $input['sm_subscriber_count_hide'] );




        /*if( isset( $input['sm_youtube_channel_id'] ) )
            $new_input['sm_youtube_channel_id'] = absint( $input['sm_youtube_channel_id'] );*/


        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your YouTube Subscribe button settings below:';
    }



    /** 
     * Get the settings option array and print one of its values
     */
    public function sm_youtube_channel_id_callback()
    {
        printf(
            '<input type="text" id="sm_youtube_channel_id" required name="sm_youtube_subscribe_options[sm_youtube_channel_id]" value="%s" />',
            isset( $this->options['sm_youtube_channel_id'] ) ? esc_attr( $this->options['sm_youtube_channel_id']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function sm_ytcs_title_callback()
    {
        printf(
            '<input type="text" id="title" name="sm_youtube_subscribe_options[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }

    public function sm_full_layout_callback()
    {
        printf(
            '<input class="checkbox" type="checkbox" id="sm_full_layout" '.checked(isset( $this->options['sm_full_layout'] ),true,false).' name="sm_youtube_subscribe_options[sm_full_layout]" value="on" />',
            isset( $this->options['sm_full_layout'] ) ? esc_attr( $this->options['sm_full_layout']) : ''
        );
    }

    public function sm_dark_theme_callback()
    {
        printf(
            '<input class="checkbox" type="checkbox" id="sm_dark_theme" '.checked(isset( $this->options['sm_dark_theme'] ),true,false).' name="sm_youtube_subscribe_options[sm_dark_theme]" value="on" />',
            isset( $this->options['sm_dark_theme'] ) ? esc_attr( $this->options['sm_dark_theme']) : ''
        );
    }

    public function sm_subscriber_count_hide_callback()
    {
        printf(
            '<input class="checkbox" type="checkbox" id="sm_subscriber_count_hide" '.checked(isset( $this->options['sm_subscriber_count_hide'] ),true,false).' name="sm_youtube_subscribe_options[sm_subscriber_count_hide]" value="on" />',
            isset( $this->options['sm_subscriber_count_hide'] ) ? esc_attr( $this->options['sm_subscriber_count_hide']) : ''
        );
    }





}

if( is_admin() )
    $my_settings_page = new SMYoutubeSubscribeSettingsPage();



function sm_youtube_subscribe_shortcode( $atts ){
	global $wp;
	$current_url = home_url(add_query_arg(array(),$wp->request));
	$instance = get_option( 'sm_youtube_subscribe_options' );

	$title 			= ($instance['title'])?$instance['title']:'';
	$channel_id 	= ($instance['sm_youtube_channel_id'])?$instance['sm_youtube_channel_id']:'UCKIG1BY9SOv2Hg1q5I8WLBQ';	     
	$layout    		= ($instance['sm_full_layout'])?'full':'default';	     
    $theme    		= ($instance['sm_dark_theme'])?'dark':'default';	     
    $count    		= ($instance['sm_subscriber_count_hide'])?'hidden':'default';	
	ob_start();
	?>
    <style type="text/css">
        .dark_theme{
            padding: 8px; 
            background: rgb(85, 85, 85);
        }
    </style>
    <div class="ytsubscribe_container <?php echo $theme; ?>_theme">
    	<script src="https://apis.google.com/js/platform.js"></script>
    	<?php if($title):?>
    	<h3><?= $title;?></h3>
    	<?php endif;?>
    	<div 
    		class="g-ytsubscribe" 
    		data-channelid="<?php echo $channel_id; ?>" 
    		data-layout="<?php echo $layout; ?>" 
    		data-theme="<?php echo $theme; ?>" 
    		data-count="<?php echo $count; ?>">			
    	</div>
    </script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sm-youtube-subscribe', 'sm_youtube_subscribe_shortcode' );
