<?php 
/*
Plugin Name: Luzuk Testimonials
Plugin URI: 
Description: You could add or create the Testimonial by using there short codes into your pages [Luzuk_Testimonial] | [Testimonial_Slider].
Version: 0.0.1
Author: Luzuk
Author URI: https://www.luzuk.com
License: GPLv2
*/

//defining path

define( 'LTESTIPM_DIR_PATH', plugin_dir_path( __FILE__ ) );

$ltestip_options=[];

if(get_option('ltestip_options')){
  $ltestip_options = get_option('ltestip_options');
}

// Dynamic styles
require LTESTIPM_DIR_PATH . 'includes/lptstyle.php';

// Active plugin
function ltestip_activation() {
}
register_activation_hook(__FILE__, 'ltestip_activation');

// Deactive plugin
function ltestip_deactivation() {
}
register_deactivation_hook(__FILE__, 'ltestip_deactivation');

// Added script
add_action('wp_enqueue_scripts', 'ltluzuk_scripts');
function ltluzuk_scripts() {

    wp_register_script('ltfontawesome', plugins_url('assets/js/ltfontawesome.js', __FILE__),array("jquery"));
    wp_enqueue_script('ltfontawesome');

    wp_register_script('lt.testimonialj', plugins_url('assets/js/lt.testimonialj.js', __FILE__),array("jquery"));
    wp_enqueue_script('lt.testimonialj');

    wp_register_script('ltowl_carousel_min', plugins_url('assets/js/ltowl.carousel.min.js', __FILE__),array("jquery"));
    wp_enqueue_script('ltowl_carousel_min');

    wp_register_script('lt.simplePagination', plugins_url('assets/js/lt.simplePagination.js', __FILE__),array("jquery"));
    wp_enqueue_script('lt.simplePagination');

    wp_register_script('ltbootstrap.min', plugins_url('assets/js/ltbootstrap.min.js', __FILE__),array("jquery"));
    wp_enqueue_script('ltbootstrap.min');

}

// Added styes
add_action('wp_enqueue_scripts', 'ltluzuk_styles');
function ltluzuk_styles() {

    wp_register_style('ltstyle', plugins_url('assets/css/ltstyle.css', __FILE__));
    wp_enqueue_style('ltstyle');
    
    wp_register_style('ltstylowl_default', plugins_url('assets/css/ltowl.theme.default.min.css', __FILE__));
    wp_enqueue_style('ltstylowl_default');

    wp_register_style('ltstylowl', plugins_url('assets/css/ltowl.carousel.min.css', __FILE__));
    wp_enqueue_style('ltstylowl');

    wp_register_style('simplePaginationcss', plugins_url('assets/css/ltsimplePagination.css', __FILE__));
    wp_enqueue_style('simplePaginationcss');

    wp_register_style('ltbootstrap.mincss', plugins_url('assets/css/ltbootstrap.min.css', __FILE__));
    wp_enqueue_style('ltbootstrap.mincss');
}

add_action('admin_enqueue_scripts', 'testi_admin_styles');
function testi_admin_styles() {

    wp_enqueue_style( 'wp-color-picker' ); 
    wp_enqueue_script( 'wp-color-picker' ); 

    wp_register_script('testi_custom_script', plugins_url('assets/js/testi-custom-script.js', __FILE__),array("jquery"));
    wp_enqueue_script('testi_custom_script');

    wp_register_style('testi_custom_style', plugins_url('assets/css/testi-custom-script.css', __FILE__));
    wp_enqueue_style('testi_custom_style');

}

// Dynamic colors 
function ltestip_pl_scripts() {
    wp_enqueue_style( 'luzuk-premium-style', get_stylesheet_uri() );
    $handle = 'luzuk-premium-style';
    $custom_css = ltestip_totallt_dymanic_styles();
    wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ltestip_pl_scripts' );

// Dynamic colors patterns 
function ltestip_css_strip_whitespace($css){
    $replace = array(
      "#/\*.*?\*/#s" => "",  // Strip C style comments.
      "#\s\s+#"      => " ", // Strip excess whitespace.
    );
    $search = array_keys($replace);
    $css = preg_replace($search, $replace, $css);
  
    $replace = array(
      ": "  => ":",
      "; "  => ";",
      " {"  => "{",
      " }"  => "}",
      ", "  => ",",
      "{ "  => "{",
      ";}"  => "}",   // Strip optional semicolons.
      ",\n" => ",",   // Don't wrap multiple selectors.
      "\n}" => "}",   // Don't wrap closing braces.
      "} "  => "}\n", // Put each rule on it's own line.
    );
    $search = array_keys($replace);
    $css = str_replace($search, $replace, $css);
    return trim($css);
  }

function ltestip_create_custome_types_slider() {

    register_post_type('ltestip-plugin',
        array(
            'labels' => array(
                'name' => __('Luzuk Testimonials' , 'testimony-character-and-slider'),
                'singular_name' => __('Luzuk Testimony', 'testimony-character-and-slider')
            ),
            'public' => true,
            'featured_image'=>true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-testimonial',
            'supports' => array('title','thumbnail','editor','author','page-attributes'),
        )
    );
}


add_action('init', 'ltestip_create_custome_types_slider');



/**
  * Custom Post Type add Subpage to Custom Post Menu
  * @description- Luzuk testimonal Custom Post Type Submenu Example
  *
  *
  */

// Hook

add_action('admin_menu', 'add_ltesti_submenu');

//admin_menu callback function

function add_ltesti_submenu(){

    add_submenu_page(
        'edit.php?post_type=ltestip-plugin', //$parent_slug
        'Testimonal',                        //$page_title
        'Settings',                          //$menu_title
        'manage_options',                    //$capability
        'ltesti_tutorial_subpage_example',   //$menu_slug
        'ltesti_options_page'                //$function
    );

}

function ltesti_register_post_settings() {
    add_option( 'postnumbercol', '3');
    register_setting( 'ltesti_options_group', 'postnumbercol', 'ltesti_callback' );
}
add_action( 'admin_init', 'ltesti_register_post_settings' );

function ltesti_register_settings() {
    add_option( 'postnumber', '2');
    register_setting( 'ltesti_options_group', 'postnumber', 'ltesti_callback' );
}
add_action( 'admin_init', 'ltesti_register_settings' );

// -------------------------------
function ltesti_register_namefont_settings() {
    add_option( 'namefontsize', '21');
    register_setting( 'ltesti_options_group', 'namefontsize', 'ltesti_callback' );
}
add_action( 'admin_init', 'ltesti_register_namefont_settings' );

function ltesti_register_textfont_settings() {
    add_option( 'textfontsize', '16');
    register_setting( 'ltesti_options_group', 'textfontsize', 'ltesti_callback' );
}
add_action( 'admin_init', 'ltesti_register_textfont_settings' );
// -------------------------------

function lteamp_select_slidertesti() {
    add_option( 'ltfp_testi', 'true');
    register_setting( 'ltesti_options_group', 'ltfp_testi', 'ltesti_callback' );
}
add_action( 'admin_init', 'lteamp_select_slidertesti' );

function ltesti_options_page() {

    global $ltestip_options; 

    if(isset($ltestip_options['testimonial_namecolor'])){
        $ltestip_options['testimonial_namecolor'] = $ltestip_options['testimonial_namecolor'];
    }else{ 
        $ltestip_options['testimonial_namecolor'] = "#383838";
    }

    if(isset($ltestip_options['ltestip_option_imgheighttesti'])){
        $ltestip_options['ltestip_option_imgheighttesti'] = $ltestip_options['ltestip_option_imgheighttesti'];
    }else{
       $ltestip_options['ltestip_option_imgheighttesti'] = "100";
    }

    if(isset($ltestip_options['ltestip_option_imgwidthtesti'])){
        $ltestip_options['ltestip_option_imgwidthtesti'] = $ltestip_options['ltestip_option_imgwidthtesti'];
    }else{
       $ltestip_options['ltestip_option_imgwidthtesti'] = "300";
    }

    if(isset($ltestip_options['testimonial_titlecolor'])){
        $ltestip_options['testimonial_titlecolor'] = $ltestip_options['testimonial_titlecolor'];
    }else{ 
        $ltestip_options['testimonial_titlecolor'] = "";
    }

    if(isset($ltestip_options['testimonial_testcolor'])){
        $ltestip_options['testimonial_testcolor'] = $ltestip_options['testimonial_testcolor'];
    }else{ 
        $ltestip_options['testimonial_testcolor'] = "#383838";
    }
    
    if(isset($ltestip_options['testimonial_socialcolor'])){
        $ltestip_options['testimonial_socialcolor'] = $ltestip_options['testimonial_socialcolor'];
    }else{ 
        $ltestip_options['testimonial_socialcolor'] = "#6a6a6a";
    }
    
    if(isset($ltestip_options['ltestip_option_imgwidthtesti1t'])){
        $ltestip_options['ltestip_option_imgwidthtesti1t'] = $ltestip_options['ltestip_option_imgwidthtesti1t'];
    }else{
       $ltestip_options['ltestip_option_imgwidthtesti1t'] = "100";
    }

    if(isset($ltestip_options['ltestip_option_imgheighttesti1t'])){
        $ltestip_options['ltestip_option_imgheighttesti1t'] = $ltestip_options['ltestip_option_imgheighttesti1t'];
    }else{
       $ltestip_options['ltestip_option_imgheighttesti1t'] = "360";
    }

    ?>
    <?php screen_icon(); ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'ltesti_options_group' ); ?>
        <h3><?php echo esc_html('Testimonal Setting'); ?></h3>
        <div class="testi-tab-row">
            <div class="testi-tab-col testi-tab-col1">
                <ul class="testi-admin-tab" id="selectioptiontab">
                    <li testi-id="testi-tab1" id="tabtest1"><span><?php echo esc_html('Slider','testimony-character-and-slider'); ?></span></li>
                    <li testi-id="testi-tab2" id="tabtest2"><span><?php echo esc_html('Post','testimony-character-and-slider'); ?></span></li>
                    <li testi-id="testi-tab3" id="tabtest1"><span><?php echo esc_html('Style','testimony-character-and-slider'); ?></span></li>
                </ul>
            </div>
            <div class="testi-tab-col testi-tab-col2">
                <div class="testi-tab-content">
                    <div class="testi-tab-content-wrap" id="testi-tab1">
                        <div class="lt-input-field">
                            <label><?php echo esc_html('Testimonial Show','testimony-character-and-slider'); ?></label>
                                <input class="numbbox" type="number" id="tentacles" name="postnumber" min="1" max="3" value="<?php echo esc_attr(get_option('postnumber')); ?>">
                            </label>
                        </div>
                        <div class="lt-input-field">
                            <?php $ltfp_testi = get_option('ltfp_testi'); ?>
                            <label><?php echo esc_html('Arrows','testimony-character-and-slider'); ?></label>
                            <div class="switch-field">
                                <input type="radio" id="radio-one" name="ltfp_testi" value="true" <?php if(isset($ltfp_testi)){checked( 'true' == $ltfp_testi ); } ?>  />
                                <label for="radio-one">ON</label>
                                <input type="radio" id="radio-two" name="ltfp_testi" value="false" <?php if(isset($ltfp_testi)){checked( 'false' == $ltfp_testi ); } ?>  />
                                <label for="radio-two">OFF</label> 
                            </div>
                            </label>
                        </div>
                        <div class="lt-input-field">
                            <label><?php echo esc_html('Image Width','testimony-character-and-slider'); ?></label>
                                <div class="range-slider">
                                    <input class="rangesliderrange" id="myRangetestSlider" type="range" min="0" max="100" name="ltestip_options[ltestip_option_imgheighttesti]" value="<?php echo esc_attr($ltestip_options['ltestip_option_imgheighttesti']); ?>">
                                    <div class="rangeslidercec"><span id="rangeslidervalue"></span><?php echo esc_html(' ％'); ?></div>
                                </div>
                                <script>
                                    var rangesliderrange = document.getElementById("myRangetestSlider");
                                    var outputslidertest = document.getElementById("rangeslidervalue");
                                    outputslidertest.innerHTML = rangesliderrange.value;

                                    rangesliderrange.oninput = function() {
                                    outputslidertest.innerHTML = this.value;
                                    }
                                </script>
                            </label>
                        </div>
                        <div class="lt-input-field">
                            <label><?php echo esc_html('Image Height','testimony-character-and-slider'); ?></label>
                                <div class="range-slider">
                                    <input class="rangesliderrangeh" id="myRangetestSliderh" type="range" min="0" max="300" name="ltestip_options[ltestip_option_imgwidthtesti]" value="<?php echo esc_attr($ltestip_options['ltestip_option_imgwidthtesti']); ?>">
                                    <div class="rangeslidercec"><span id="rangeslidervalueh"></span><?php echo esc_html(' px'); ?></div>
                                </div>
                                <script>
                                    var rangesliderrangeh = document.getElementById("myRangetestSliderh");
                                    var outputslidertesth = document.getElementById("rangeslidervalueh");
                                    outputslidertesth.innerHTML = rangesliderrangeh.value;

                                    rangesliderrangeh.oninput = function() {
                                    outputslidertesth.innerHTML = this.value;
                                    }
                                </script>
                            </label>
                        </div>
                    </div>
                    <div class="testi-tab-content-wrap" id="testi-tab2">
                        <div class="lt-input-field">
                            <label><?php echo esc_html('Testimonial Show','testimony-character-and-slider'); ?></label>
                                <input class="numbbox" type="number" id="tentacles" name="postnumbercol" min="1" max="9" value="<?php echo esc_attr(get_option('postnumbercol')); ?>">
                            </label>
                        </div>
                        <div class="lt-input-field hw-size">
                            <label><?php echo esc_html('Image Width','testimony-character-and-slider'); ?></label>
                                <input class="numbfield numbbox" type="number" min="0" max="100" name="ltestip_options[ltestip_option_imgwidthtesti1t]" value="<?php echo esc_attr($ltestip_options['ltestip_option_imgwidthtesti1t']); ?>">
                                <span>%</span>
                            </label>
                        </div>
                        <div class="lt-input-field hw-size">
                            <label><?php echo esc_html('Image Height','testimony-character-and-slider'); ?></label>
                                <input class="numbfield numbbox" type="number" name="ltestip_options[ltestip_option_imgheighttesti1t]" value="<?php echo esc_attr($ltestip_options['ltestip_option_imgheighttesti1t']); ?>">
                                <span>px</span>
                            </label>
                        </div>
                    </div>
                    <div class="testi-tab-content-wrap" id="testi-tab3">
                        <div class="lt-input-field">
                            <label><?php echo esc_html_e('Name Color','testimony-character-and-slider'); ?></label>
                            <input id="lt_nvacol" type="text" name="ltestip_options[testimonial_namecolor]" value="<?php echo esc_attr($ltestip_options['testimonial_namecolor']); ?>" class="ltestcolor-field" />
                        </div>
                        <div class="lt-input-field">
                            <label><?php echo esc_html_e('Text Color','testimony-character-and-slider'); ?></label>
                            <input id="lt_nvacol" type="text" name="ltestip_options[testimonial_testcolor]" value="<?php echo esc_attr($ltestip_options['testimonial_testcolor']); ?>" class="ltestcolor-field" />
                        </div>
                        <div class="lt-input-field">
                            <label><?php echo esc_html_e('Social Icons Color','testimony-character-and-slider'); ?></label>
                            <input id="lt_nvacol" type="text" name="ltestip_options[testimonial_socialcolor]" value="<?php echo esc_attr($ltestip_options['testimonial_socialcolor']); ?>" class="ltestcolor-field" />
                        </div>
                        <div class="lt-input-field hw-size">
                            <label><?php echo esc_html_e('Name Font Size','testimony-character-and-slider'); ?></label>
                            <input class="numbbox" type="number" name="namefontsize" min="1" max="100" value="<?php echo esc_attr(get_option('namefontsize')); ?>">
                            <span>px</span>
                        </div>
                        <div class="lt-input-field hw-size">
                            <label><?php echo esc_html_e('Text Font Size','testimony-character-and-slider'); ?></label>
                            <input class="numbbox" type="number" name="textfontsize" min="1" max="100" value="<?php echo esc_attr(get_option('textfontsize')); ?>">
                            <span>px</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php  submit_button( 'Save Changes' ); ?>
    </form>
    <script>
        jQuery(document).ready(function(){

        jQuery( '.ltestcolor-field' ).wpColorPicker();

        jQuery('.testi-admin-tab li:nth-child(1)').addClass('active');
        jQuery('#testi-tab1').addClass('active');

        jQuery('.testi-admin-tab li').click(function(){
            jQuery('.testi-admin-tab li').removeClass('active');
            jQuery('#testi-tab1').removeClass('active');
            jQuery('.testi-tab-content-wrap').removeClass('active');

            jQuery(this).addClass('active');
            let current_tab = jQuery(this).attr('testi-id');
            jQuery('#' + current_tab).addClass('active');

        });

        });
    </script>
<?php }

/* --------- New -------- */
add_action( 'admin_init', 'lltesti_register_settings' );
function lltesti_register_settings() {
    register_setting('ltesti_options_group', 'ltestip_options', 'ltestip_validate_options');
}


function ltestip_LuzukCustomFieldPostSocial(){
    global $post;
    
    $testimonyluzukFB = get_post_meta($post->ID, 'testimonyluzukFB', false);
    $testimonyluzukFBValue = !empty($testimonyluzukFB[0])?$testimonyluzukFB[0]:'';

    $testimonyluzukTWITTER = get_post_meta($post->ID, 'testimonyluzukTWITTER', false);
    $testimonyluzukTWITTERValue = !empty($testimonyluzukTWITTER[0])?$testimonyluzukTWITTER[0]:'';

    $testimonyluzukLINKDIN = get_post_meta($post->ID, 'testimonyluzukLINKDIN', false);
    $testimonyluzukLINKDINValue = !empty($testimonyluzukLINKDIN[0])?$testimonyluzukLINKDIN[0]:'';

    $testimonyluzukINSTAGRAM = get_post_meta($post->ID, 'testimonyluzukINSTAGRAM', false);
    $testimonyluzukINSTAGRAMValue = !empty($testimonyluzukINSTAGRAM[0])?$testimonyluzukINSTAGRAM[0]:'';

    wp_nonce_field(plugin_basename(__FILE__), 'luzuk_custom_media_links_testi');
    echo '<table id="SocialUrls" width="100%">';
    echo '<tr> 
            <th width="10%"><span class="dashicons dashicons-facebook"></span></th>
            <td width="90%"><input type="text" name="testimonyluzukFB" width="100%" placeholder="Facebook URL" value="'.$testimonyluzukFBValue.'" /></td>
        </tr>';
        echo '<tr>
            <th><span class="dashicons dashicons-twitter"></span></th>
            <td><input type="text" name="testimonyluzukTWITTER" width="100%" placeholder="Twitter URL" value="'.$testimonyluzukTWITTERValue.'" /></td>
        </tr>';
        echo '<tr>
            <th><span class="dashicons dashicons-linkedin"></span></th>
            <td><input type="text" name="testimonyluzukLINKDIN" width="100%" placeholder="Linkedin URL" value="'.$testimonyluzukLINKDINValue.'" /></td>
        </tr>';
        echo '<tr>
            <th><span class="dashicons dashicons-instagram"></span></th>
            <td><input type="text" name="testimonyluzukINSTAGRAM" width="100%" placeholder="Instagram URL" value="'.$testimonyluzukINSTAGRAMValue.'" /></td>
        </tr>';
    echo '</table>';
}

function ltestip_LuzukCustomDesignationCutomFieldHtml(){
    global $post;
    // get the saved value
    $designation = get_post_meta($post->ID, 'designation', false);
    $designation = !empty($designation[0])?$designation[0]:'';

    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'Teamluzuk_social_media_links');
    echo '<table id="socialUrls" width="100%">';
    echo '<tr> 
        <th width="10%"><span class="dashicons dashicons-welcome-learn-more"></span></th>
        <td width="90%"><input type="text" name="designation" width="100%" placeholder="Designation" value="'.$designation.'" /></td>
    </tr>';
    echo '</table>';
}

function TestimonyluzukpostHook(){
    add_meta_box('luzuk-TestimonySocial', __('Add Social Media Links', 'luzuk-premium'), 'ltestip_LuzukCustomFieldPostSocial', 'ltestip-plugin', 'normal', 'high');
    add_meta_box('luzuk-designation-testimony', __('Add Designation', 'luzuk-premium'), 'ltestip_LuzukCustomDesignationCutomFieldHtml', 'ltestip-plugin', 'normal', 'high');
}

function luzukpostSocialCutomDataTestimonialSave($post_id){
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if(empty($_POST['designation']) && empty($_POST['testimonyluzukFB']) && empty($_POST['testimonyluzukTWITTER']) && empty($_POST['testimonyluzukLINKDIN']) && empty($_POST['testimonyluzukINSTAGRAM']) && empty($_POST['postnumber']) && empty($_POST['postnumbercol']) && empty($_POST['namefontsize']) && empty($_POST['textfontsize']) && empty($_POST['ltfp_testi'])){
        return;
    }

    $testimonyluzukFB = sanitize_text_field($_POST['testimonyluzukFB']);
    update_post_meta($post_id, 'testimonyluzukFB', $testimonyluzukFB);

    $testimonyluzukTWITTER = sanitize_text_field($_POST['testimonyluzukTWITTER']);
    update_post_meta($post_id, 'testimonyluzukTWITTER', $testimonyluzukTWITTER);

    $testimonyluzukLINKDIN = sanitize_text_field($_POST['testimonyluzukLINKDIN']);
    update_post_meta($post_id, 'testimonyluzukLINKDIN', $testimonyluzukLINKDIN);

    $testimonyluzukINSTAGRAM = sanitize_text_field($_POST['testimonyluzukINSTAGRAM']);
    update_post_meta($post_id, 'testimonyluzukINSTAGRAM', $testimonyluzukINSTAGRAM);

    $postnumber = sanitize_text_field($_POST['postnumber']);
    update_post_meta($post_id, 'postnumber', $postnumber);

    $postnumbercol = sanitize_text_field($_POST['postnumbercol']);
    update_post_meta($post_id, 'postnumbercol', $postnumbercol);

    $namefontsize = sanitize_text_field($_POST['namefontsize']);
    update_post_meta($post_id, 'namefontsize', $namefontsize);

    $textfontsize = sanitize_text_field($_POST['textfontsize']);
    update_post_meta($post_id, 'textfontsize', $textfontsize);

    $designation = sanitize_text_field($_POST['designation']);
    update_post_meta($post_id, 'designation', $designation);

    $ltfp_testi = sanitize_text_field($_POST['ltfp_testi']);
    update_post_meta($post_id, 'ltfp_testi', $ltfp_testi);

}

add_action('add_meta_boxes', 'TestimonyluzukpostHook');
add_action('save_post', 'luzukpostSocialCutomDataTestimonialSave');

function TestimonyPostShortCode1($pageId = null, $isCustomizer = false, $i = null) {
    ob_start();

    $args = array('post_type' => 'ltestip-plugin');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }

    $args['posts_per_page'] = -1;
    $colCls = '';
    $cols = get_theme_mod('testimonyluzuk_npp_count', get_option('postnumbercol')-1);
    $cols++;
    switch($cols){
        case 1:
            $colCls = 'col-md-12 col-sm-12 col-xs-12';
            break;
        case 2:
        case 4:
            $colCls = 'col-md-6 col-sm-6 col-xs-12';
            break;
        case 3:
        case 6:
        case 9:
            $colCls = 'col-md-4 col-sm-6 col-xs-12';
            break;
        default:
            $colCls = 'col-md-3 col-sm-6 col-xs-12';
            break;
    }

    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0;
?>
    <div id="slider_testimony">
        <div class="areacontent">
            <div class="simpcontent">
                <?php 
                    while ($query->have_posts()) : $query->the_post();
                    $luzuk_testimonyimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-testimonyluzuk-thumb');

                    $post = get_post();

                    if ($isCustomizer === true) {
                        $testimonyluzuk_designation = get_theme_mod('testimonyluzuk_designation' . $i);
                        $testimonyluzuk_FB = get_theme_mod('testimonyluzuk_FB' . $i);
                        $testimonyluzuk_TWITTER = get_theme_mod('testimonyluzuk_TWITTER' . $i);
                        $testimonyluzuk_LINKDIN = get_theme_mod('testimonyluzuk_LINKDIN' . $i);
                        $testimonyluzuk_INSTAGRAM = get_theme_mod('testimonyluzuk_INSTAGRAM' . $i);
                        
                    } else {
                        $testimonyluzuk_FB = '';
                        $testimonyluzuk_TWITTER = '';
                        $testimonyluzuk_LINKDIN = '';
                        $testimonyluzuk_INSTAGRAM = '';
                        $testimonyluzuk_designation = '';
                    }

                    // Social Media
                    $testimonyluzukFB = get_post_meta($post->ID, 'testimonyluzukFB', false);
                    $testimonyluzuk_FB = !empty($testimonyluzukFB[0]) ? $testimonyluzukFB[0] : '';
                    $testimonyluzukTWITTER = get_post_meta($post->ID, 'testimonyluzukTWITTER', false);
                    $testimonyluzuk_TWITTER = !empty($testimonyluzukTWITTER[0]) ? $testimonyluzukTWITTER[0] : '';
                    $testimonyluzukLINKDIN = get_post_meta($post->ID, 'testimonyluzukLINKDIN', false);
                    $testimonyluzuk_LINKDIN = !empty($testimonyluzukLINKDIN[0]) ? $testimonyluzukLINKDIN[0] : '';
                    $testimonyluzukINSTAGRAM = get_post_meta($post->ID, 'testimonyluzukINSTAGRAM', false);
                    $testimonyluzuk_INSTAGRAM = !empty($testimonyluzukINSTAGRAM[0]) ? $testimonyluzukINSTAGRAM[0] : '';

                    $designation = get_post_meta($post->ID, 'designation', false);
                    $testimonyluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

                    if (has_post_thumbnail()) {
                        $limage_url = $luzuk_testimonyimage[0];
                    } else {
                        $limage_url = plugin_dir_url( __FILE__ ) . '/images/defaultpic.png';
                    }

                ?>
                <div class="<?php echo esc_attr($colCls)?> content-area simp-content">
                    <div class="card-testimony">
                        <img class="imgpost" src="<?php echo esc_url($limage_url); ?>" alt="<?php the_title(); ?>" />
                    </div>
                    <div class="contentpsot">
                        <h4 style="font-size: <?php echo esc_html(get_option('namefontsize'))?>px;"><?php the_title(); ?></h4>
                    </div>
                    <div class="content-designation">
                        <?php if (!empty($testimonyluzuk_designation)) { ?>
                            <div class="testimony-member-designation" style="font-size: <?php echo esc_html(get_option('textfontsize'))?>px;"><?php echo esc_html($testimonyluzuk_designation); ?></div>
                        <?php } ?>
                    </div>
                    <div class="aluzuk25424dsaf665ds">
                        <p style="font-size: <?php echo esc_html(get_option('textfontsize'))?>px;"><?php echo esc_html(get_the_content()); ?></p>
                    </div>
                    <?php if ($testimonyluzuk_FB || $testimonyluzuk_TWITTER || $testimonyluzuk_LINKDIN || $testimonyluzuk_INSTAGRAM) { ?>
                        <div class="contentsocialpost">
                            <?php if ($testimonyluzuk_FB) { ?>
                                <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_FB) ?>"><i class="fab fa-facebook-f"></i></a>
                            <?php } ?>
                            <?php if ($testimonyluzuk_TWITTER) { ?>
                                <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_TWITTER) ?>"><i class="fab fa-twitter"></i></a>
                            <?php } ?>
                            <?php if ($testimonyluzuk_LINKDIN) { ?>
                                <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_LINKDIN) ?>"><i class="fab fa-linkedin-in"></i></a>
                            <?php } ?>
                            <?php if ($testimonyluzuk_INSTAGRAM) { ?>
                                <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_INSTAGRAM) ?>"><i class="fab fa-instagram"></i></a>
                            <?php } ?>
                        </div>                
                    <?php } ?>
                </div>
                <?php endwhile ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="pagination-container-ltestimonial" class="paginationcontainernav"></div>
        <script>
            var allitesti = $(".simpcontent .content-area");
            let noItesti = allitesti.length

            if (noItesti <= <?php echo esc_attr(get_option('postnumbercol')); ?>){
                document.querySelector('.paginationcontainernav').style.display = "none";
            }
        </script>
        <script>
            var items = $(".simpcontent .content-area");
            var numItems = items.length;
            var perPage = <?php echo esc_attr(get_option('postnumbercol')); ?>;
            
            items.slice(perPage).hide();

            $('#pagination-container-ltestimonial').pagination({
                items: numItems,
                itemsOnPage: perPage,
                prevText: "&laquo;",
                nextText: "&raquo;",
                onPageClick: function (pageNumber) {
                    var showFrom = perPage * (pageNumber - 1);
                    var showTo = showFrom + perPage;
                    items.hide().slice(showFrom, showTo).show();
                }
            });

        </script>
    </div>  
<?php
$text = ob_get_contents();
ob_clean();
endif;
wp_reset_postdata();
return $text;
}

function TestimonyPostShortCode2($pageId = null, $isCustomizer = false, $i = null) {
    ob_start();

    $args = array('post_type' => 'ltestip-plugin');
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $args['posts_per_page'] = -1;

    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0;

?>
    <div id="slider_testimony">
        <div class="owl-carousell">
            <?php 
                while ($query->have_posts()) : $query->the_post();
                $luzuk_testimonyimage = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-testimonyluzuk-thumb');

                $post = get_post();

                if ($isCustomizer === true) {
                    $testimonyluzuk_designation = get_theme_mod('testimonyluzuk_designation' . $i);
                    $testimonyluzuk_FB = get_theme_mod('testimonyluzuk_FB' . $i);
                    $testimonyluzuk_TWITTER = get_theme_mod('testimonyluzuk_TWITTER' . $i);
                    $testimonyluzuk_LINKDIN = get_theme_mod('testimonyluzuk_LINKDIN' . $i);
                    $testimonyluzuk_INSTAGRAM = get_theme_mod('testimonyluzuk_INSTAGRAM' . $i);
                } else {
                    $testimonyluzuk_FB = '';
                    $testimonyluzuk_TWITTER = '';
                    $testimonyluzuk_LINKDIN = '';
                    $testimonyluzuk_INSTAGRAM = '';
                    $testimonyluzuk_designation = '';
                }

                // Social Media
                $testimonyluzukFB = get_post_meta($post->ID, 'testimonyluzukFB', false);
                $testimonyluzuk_FB = !empty($testimonyluzukFB[0]) ? $testimonyluzukFB[0] : '';
                $testimonyluzukTWITTER = get_post_meta($post->ID, 'testimonyluzukTWITTER', false);
                $testimonyluzuk_TWITTER = !empty($testimonyluzukTWITTER[0]) ? $testimonyluzukTWITTER[0] : '';
                $testimonyluzukLINKDIN = get_post_meta($post->ID, 'testimonyluzukLINKDIN', false);
                $testimonyluzuk_LINKDIN = !empty($testimonyluzukLINKDIN[0]) ? $testimonyluzukLINKDIN[0] : '';
                $testimonyluzukINSTAGRAM = get_post_meta($post->ID, 'testimonyluzukINSTAGRAM', false);
                $testimonyluzuk_INSTAGRAM = !empty($testimonyluzukINSTAGRAM[0]) ? $testimonyluzukINSTAGRAM[0] : '';

                $designation = get_post_meta($post->ID, 'designation', false);
                $testimonyluzuk_designation = !empty($designation[0]) ? $designation[0] : '';

                if (has_post_thumbnail()) {
                    $limage_url = $luzuk_testimonyimage[0];
                } else {
                    $limage_url = plugin_dir_url( __FILE__ ) . '/images/defaultpic.png';
                }

            ?>
            <div class="content-area">
                <div class="card-testimony">
                    <img class="imgpostslider" src="<?php echo esc_url($limage_url); ?>" alt="<?php the_title(); ?>" />
                </div>
                <div class="contentpsot">
                    <h4 style="font-size: <?php echo esc_html(get_option('namefontsize'))?>px;"><?php the_title(); ?></h4>
                </div>
                <div class="content-designation">
                    <?php if (!empty($testimonyluzuk_designation)) { ?>
                        <div class="testimony-member-designation" style="font-size: <?php echo esc_html(get_option('textfontsize'))?>px;"><?php echo esc_html($testimonyluzuk_designation); ?></div>
                    <?php } ?>
                </div>
                <div class="aluzuk25424dsaf665ds">
                    <p style="font-size: <?php echo esc_html(get_option('textfontsize'))?>px;"><?php echo esc_html(get_the_content()); ?></p>
                </div>
                <?php if ($testimonyluzuk_FB || $testimonyluzuk_TWITTER || $testimonyluzuk_LINKDIN || $testimonyluzuk_INSTAGRAM) { ?>
                    <div class="contentsocialpost">
                        <?php if ($testimonyluzuk_FB) { ?>
                            <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_FB) ?>"><i class="fab fa-facebook-f"></i></a>
                        <?php } ?>
                        <?php if ($testimonyluzuk_TWITTER) { ?>
                            <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_TWITTER) ?>"><i class="fab fa-twitter"></i></a>
                        <?php } ?>
                        <?php if ($testimonyluzuk_LINKDIN) { ?>
                            <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_LINKDIN) ?>"><i class="fab fa-linkedin-in"></i></a>
                        <?php } ?>
                        <?php if ($testimonyluzuk_INSTAGRAM) { ?>
                            <a class="social_testi" href="<?php echo esc_url($testimonyluzuk_INSTAGRAM) ?>"><i class="fab fa-instagram"></i></a>
                        <?php } ?>
                    </div>                
                <?php } ?>
            </div>
            <?php endwhile ?>
        </div>
        <script>
            $('.owl-carousell').owlCarousel({
                loop: false,
                margin: 15,
                nav: <?php echo esc_attr(get_option('ltfp_testi')); ?>,
                autoplay: true,
                responsiveClass: true,
                responsive:{
                    0: {
                        items:  1,
                    },
                    600: {
                        items: 2,
                    },
                    960:{
                        items: <?php echo esc_attr(get_option('postnumber')); ?>,
                    },
                    1000: {
                        items: <?php echo esc_attr(get_option('postnumber')); ?>,
                        margin: 30
                    }
                }
            })
        </script>
        <div class="clearfix"></div>
    </div>
<?php
    $text = ob_get_contents();
    ob_clean();
    endif;
    wp_reset_postdata();
    return $text;
    }

    add_shortcode('Luzuk_Testimonial', 'TestimonyPostShortCode1');
    add_shortcode('Testimonial_Slider', 'TestimonyPostShortCode2');
?>