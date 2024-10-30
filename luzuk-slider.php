<?php

/*
Plugin Name: Luzuk Slider
Plugin URI:
Description: luzuk slider plugin. You can add this shortcode [luzuk_slider].
Version: 0.1.5
Author: Luzuk
Author URI: https://www.luzuk.com
License: GPLv2
*/

//defining path

define( 'LSFP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'LSFP_DIR_URL', plugin_dir_url( __FILE__ ) );

// Active plugin
function lsfp_activation() {
}
register_activation_hook(__FILE__, 'lsfp_activation');

// Deactive plugin
function lsfp_deactivation() {
}
register_deactivation_hook(__FILE__, 'lsfp_deactivation');


$lsp_options=[];

if(get_option('lsp_options')){
  $lsp_options = get_option('lsp_options');
}



// Dynamic styles
require LSFP_DIR_PATH . 'includes/sliderdynstyle.php';


// Added styes
add_action('wp_enqueue_scripts', 'lsfp_styles');
function lsfp_styles() {

    wp_register_style('template1', plugins_url('assets/css/template1.css', __FILE__));
    wp_enqueue_style('template1');

    wp_register_style('template2', plugins_url('assets/css/template2.css', __FILE__));
    wp_enqueue_style('template2');

    wp_register_style('lsfp_swiper_style', plugins_url('assets/css/swiper.min.css', __FILE__));
    wp_enqueue_style('lsfp_swiper_style');

    wp_register_style('animate_style', plugins_url('assets/css/animate.css', __FILE__));
    wp_enqueue_style('animate_style');

}

add_action('admin_enqueue_scripts', 'lsfp_admin_styles');
function lsfp_admin_styles() {

    wp_enqueue_script('slider_custom_script', plugins_url('assets/js/slider-custom-script.js', __FILE__),array("jquery"));
    wp_enqueue_script('slider_custom_script');

    wp_register_style('slider_custom_style', plugins_url('assets/css/slider-custom-script.css', __FILE__));
    wp_enqueue_style('slider_custom_style');

}

// Added script
add_action('wp_enqueue_scripts', 'lsfp_scripts');
function lsfp_scripts() {

    wp_register_script('luzukswiper_min', plugins_url('assets/js/swiper.min.js', __FILE__),array("jquery"));
    wp_enqueue_script('luzukswiper_min');

    wp_register_script('lslider_fontawesome', plugins_url('assets/js/lsliderfontawesome.js', __FILE__),array("jquery"));
    wp_enqueue_script('lslider_fontawesome');

}


// Dynamic colors 
function lsp_lite_scripts() {
    wp_enqueue_style( 'luzuk-premium-style', get_stylesheet_uri() );
    $handle = 'luzuk-premium-style';
    $custom_css = lsp_totalls_dymanic_styles();
    wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'lsp_lite_scripts' );


// Dynamic colors patterns .
function lsfp_css_strip_whitespace($css){
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
        ";}"  => "}", // Strip optional semicolons.
        ",\n" => ",", // Don't wrap multiple selectors.
        "\n}" => "}", // Don't wrap closing braces.
        "} "  => "}\n", // Put each rule on it's own line.
      );
      $search = array_keys($replace);
      $css = str_replace($search, $replace, $css);
      return trim($css);
}

// Adding Custome Post Type
function lsfp_create_custome_types_slider() {
// slider
    register_post_type( 'lsfp-slider',
        array(
            'labels' => array(
                'name' => __( 'Luzuk Slider' , 'Luzuk'),
                'singular_name' => __( 'Slider', 'Luzuk' )
            ),
            'public' => true,
            'featured_image'=>true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-images-alt', //  The url to the icon to be used for this menu or the name of the icon from the iconfont
            'supports' => array('title', 'thumbnail','editor', 'page-attributes'),
        )
    );

}
// post type initialize
add_action( 'init', 'lsfp_create_custome_types_slider' );

/**
  * Custom Post Type add Subpage to Custom Post Menu
  * @description- Luzuk slider Custom Post Type Submenu Example
  *
  *
  */

// Hook

add_action('admin_menu', 'add_lsfp_submenu');

//admin_menu callback function

function add_lsfp_submenu(){

    add_submenu_page(
        'edit.php?post_type=lsfp-slider', //$parent_slug
        'Slider',  //$page_title
        'Settings',        //$menu_title
        'manage_options',           //$capability
        'lsfp_tutorial_subpage_example',//$menu_slug
        'lsfp_options_page'//$function
    );

}

function lsfp_register_settings() {
    add_option( 'lsfp_option_name', 'slide');
    register_setting( 'lsfp_options_group', 'lsfp_option_name', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_settings' );


function lsfp_register_titlecolorsettings() {
    add_option( 'lsfp_option_titlecolor', '#FFFFFF');
    register_setting( 'lsfp_options_group', 'lsfp_option_titlecolor', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_titlecolorsettings' );


function lsfp_register_textcolorsettings() {
    add_option( 'lsfp_option_textcolor', '#FFFFFF');
    register_setting( 'lsfp_options_group', 'lsfp_option_textcolor', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_textcolorsettings' );


function lsfp_register_btnbgcolorsettings() {
    add_option( 'lsfp_option_btnbgcolor', '#773afd');
    register_setting( 'lsfp_options_group', 'lsfp_option_btnbgcolor', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_btnbgcolorsettings' );



function lsfp_register_btnlabelcolorsettings() {
    add_option( 'lsfp_option_btnlabelcolor', '#FFFFFF');
    register_setting( 'lsfp_options_group', 'lsfp_option_btnlabelcolor', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_btnlabelcolorsettings' );



function lsfp_register_btnbgcolorsettings1() {
    add_option( 'lsfp_option_btnbgcolor1', '#FFFFFF');
    register_setting( 'lsfp_options_group', 'lsfp_option_btnbgcolor1', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_btnbgcolorsettings1' );



function lsfp_register_btnlabelcolorsettings1() {
    add_option( 'lsfp_option_btnlabelcolor1', '#000000');
    register_setting( 'lsfp_options_group', 'lsfp_option_btnlabelcolor1', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_btnlabelcolorsettings1' );


function lsfp_transitionduration() {
    add_option( 'teamslidertransitionduration', '4');
    register_setting( 'lsfp_options_group', 'teamslidertransitionduration', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_transitionduration' );


function lsfp_sortorder() {
    add_option( 'lsfp_sortpostorder', 'ASC');
    register_setting( 'lsfp_options_group', 'lsfp_sortpostorder', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_sortorder' );


function lsfp_sliderimageheight() {
    add_option( 'lsp_option_imageheight', '0');
    register_setting( 'lsfp_options_group', 'lsp_option_imageheight', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_sliderimageheight' );


function lsfp_register_seltemplate() {
    add_option( 'lsfp_option_sel_template', 'Template1');
    register_setting( 'lsfp_options_group', 'lsfp_option_sel_template', 'lsfp_callback' );
}
add_action( 'admin_init', 'lsfp_register_seltemplate' );


function lsfp_options_page() {

    global $lsp_options; 


    if(isset($lsp_options['lsfp_option_bgcolor'])){
        $lsp_options['lsfp_option_bgcolor'] = $lsp_options['lsfp_option_bgcolor'];
    }else{
       $lsp_options['lsfp_option_bgcolor'] = "#016efd";
    }


    if(isset($lsp_options['ls_sarrowbtn'])){
        $lsp_options['ls_sarrowbtn'] = $lsp_options['ls_sarrowbtn'];
    }else{
       $lsp_options['ls_sarrowbtn'] = "#000000";
    }

    if(isset($lsp_options['ls_sprevbtnbg'])){
        $lsp_options['ls_sprevbtnbg'] = $lsp_options['ls_sprevbtnbg'];
    }else{
       $lsp_options['ls_sprevbtnbg'] = "#FFFFFF";
    }

    
    if(isset($lsp_options['ls_sarrowbtnhrv'])){
        $lsp_options['ls_sarrowbtnhrv'] = $lsp_options['ls_sarrowbtnhrv'];
    }else{
       $lsp_options['ls_sarrowbtnhrv'] = "#FFFFFF";
    }
    

    if(isset($lsp_options['ls_sarrowbtnhrvbg'])){
        $lsp_options['ls_sarrowbtnhrvbg'] = $lsp_options['ls_sarrowbtnhrvbg'];
    }else{
       $lsp_options['ls_sarrowbtnhrvbg'] = "#773afd";
    }


    if(isset($lsp_options['lsp_option_titlefontsizeslider'])){
        $lsp_options['lsp_option_titlefontsizeslider'] = $lsp_options['lsp_option_titlefontsizeslider'];
    }else{
       $lsp_options['lsp_option_titlefontsizeslider'] = "55";
    }

    if(isset($lsp_options['lsp_option_textfontsizeslider'])){
        $lsp_options['lsp_option_textfontsizeslider'] = $lsp_options['lsp_option_textfontsizeslider'];
    }else{
       $lsp_options['lsp_option_textfontsizeslider'] = "20";
    }

    if(isset($lsp_options['lsp_option_btntxtfontsizeslider'])){
        $lsp_options['lsp_option_btntxtfontsizeslider'] = $lsp_options['lsp_option_btntxtfontsizeslider'];
    }else{
       $lsp_options['lsp_option_btntxtfontsizeslider'] = "20";
    }


    if(isset($lsp_options['lsfp_fontcase'])){
        $lsp_options['lsfp_fontcase'] = $lsp_options['lsfp_fontcase'];
    }else{
       $lsp_options['lsfp_fontcase'] = "";
    }


    if(isset($lsp_options['lsfp_arrowslider'])){
        $lsp_options['lsfp_arrowslider'] = $lsp_options['lsfp_arrowslider'];
    }else{
       $lsp_options['lsfp_arrowslider'] = "block";
    }


?>


  <div>
    <?php screen_icon(); ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'lsfp_options_group' ); ?>
        <h3><?php echo esc_html('Slider Setting'); ?></h3>
        <div id="teamblock">
            <nav>
                <ul class="team-block-tab">
                    <li tblock-id="teamblock1"><span><?php esc_html_e('Template'); ?></span></li>
                    <li tblock-id="teamblock2"><span><?php esc_html_e('Animation'); ?></span></li>
                    <li tblock-id="teamblock3"><span><?php echo esc_html('Layout'); ?></span></li>
                    <li tblock-id="teamblock4"><span><?php echo esc_html('Color Setting'); ?></span></li>
                    <li tblock-id="teamblock5"><span><?php echo esc_html('Font Setting'); ?></span></li>
                </ul>
            </nav>
            <div class='content-section-team'>
                <div id='teamblock1' class="teamblock-content-wrap">
                    <?php 
                        $lsfp_option_sel_template = get_option('lsfp_option_sel_template'); 
                            
                    ?>
                    <label><?php echo esc_html('Select Template'); ?></label> 

                    <div class="slider-tab-row">
                        <div class="slider-tab-col imgtemplate">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/template1.png'; ?>">
                            <label><input id="inputradiobtn1" type="radio" name="lsfp_option_sel_template" value="Template1" <?php if(isset($lsfp_option_sel_template)){checked( 'Template1' == $lsfp_option_sel_template ); } ?>  /><?php echo esc_html('Dinero'); ?> </label>
                        </div>
                        <div class="slider-tab-col imgtemplate">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/template2.png'; ?>">
                            <label><input id="inputradiobtn1" type="radio" name="lsfp_option_sel_template" value="Template2" <?php if(isset($lsfp_option_sel_template)){checked( 'Template2' == $lsfp_option_sel_template ); } ?>  /><?php echo esc_html('Slider 2'); ?> </label>
                        </div>
                        <div class="slider-tab-col imgtemplate">
                        </div>
                    </div>

                </div>

                <div id='teamblock2' class="teamblock-content-wrap">
                    <div>
                        <label><?php echo esc_html('Transition Effect'); ?> </label>
                        <?php 
                            $lsfp_option_name = get_option('lsfp_option_name'); 

                            if($lsfp_option_name == 'slide'){
                                $slide_selected = 'selected';
                            }
                            else
                            {
                                $slide_selected = '';
                            }

                            if($lsfp_option_name == 'fade'){
                                $fade_selected = 'selected';
                            }
                            else
                            {
                                $fade_selected = '';
                            }

                            if($lsfp_option_name == 'cube'){
                                $cube_selected = 'selected';
                            }
                            else
                            {
                                $cube_selected = ''; 
                            }
                            
                            if($lsfp_option_name == 'flip'){
                                $flip_selected = 'selected';
                            }
                            else
                            {
                                $flip_selected = ''; 
                            }

                        ?>
                        <select name="lsfp_option_name" id="myInput">
                            <option value="slide" <?php echo esc_attr($slide_selected); ?>>slide</option>
                            <option value="fade" <?php echo esc_attr($fade_selected); ?>>fade</option>
                            <option value="cube" <?php echo esc_attr($cube_selected); ?>>cube</option>
                            <option value="flip" <?php echo esc_attr($flip_selected); ?>>flip</option>
                        </select>
                    </div>

                    <div class="sliderange">
                        <label><?php echo esc_html('Time Delay'); ?></label>
                        <span>
                            <input id="transtduration" class="basic-slide" type="number" name="teamslidertransitionduration" min="1" max="120" value="<?php echo esc_attr(get_option('teamslidertransitionduration')); ?>"><label for="transtduration">SEC</label>
                        </span>
                    </div>

                    <!-- <span>
                        <input class="basic-slide" id="name" type="text" placeholder="4" /><label for="name">SEC</label>
                    </span> -->
                </div>

                <div id='teamblock3' class="teamblock-content-wrap">
                    <div>
                        <label><?php echo esc_html('Arrow On/Off'); ?></label>

                        <?php 
                            $lsfp_arrowslider = esc_attr($lsp_options['lsfp_arrowslider']); 

                            if($lsfp_arrowslider == 'block'){
                                $slide_arrowon = 'selected';
                            }
                            else
                            {
                                $slide_arrowon = '';
                            }

                            if($lsfp_arrowslider == 'none'){
                                $slide_arrowoff = 'selected';
                            }
                            else
                            {
                                $slide_arrowoff = '';
                            }

                        ?>
                        <select name="lsp_options[lsfp_arrowslider]" id="arrowonoff">
                            <option value="block" <?php echo esc_attr($slide_arrowon); ?>>on</option>
                            <option value="none" <?php echo esc_attr($slide_arrowoff); ?>>off</option>
                        </select>

                    </div>
                    

                    <div class="sliderange">

                        <label><?php echo esc_html('Sort Order'); ?> </label>

                        <?php 
                            $lsfp_sortpostorder = get_option('lsfp_sortpostorder');  

                            if($lsfp_sortpostorder == 'ASC'){
                                $order_asending = 'selected';
                            }
                            else
                            {
                                $order_asending = '';
                            }

                            if($lsfp_sortpostorder == 'DESC'){
                                $order_desending = 'selected';
                            }
                            else
                            {
                                $order_desending = '';
                            }

                        ?>
                        <select name="lsfp_sortpostorder" id="sortorder">
                            <option value="ASC" <?php echo esc_attr($order_asending); ?>>Asending</option>
                            <option value="DESC" <?php echo esc_attr($order_desending); ?>>Desending</option>
                        </select>

                    </div>

                    <div class="sliderange">

                        <label><?php echo esc_html('Image Height (0px = auto)'); ?></label>

                        <div>
                            <input type="range" class="sliderimgheight" id="myRangeimghgtSlider" name="lsp_option_imageheight" min="0" max="800" value="<?php echo esc_attr(get_option('lsp_option_imageheight')); ?>" />
                            <span id="sliderimageheight"></span><?php echo esc_html('px'); ?>
                        </div>
                        
                        <script>
                            var sliderimgheight = document.getElementById("myRangeimghgtSlider");
                            var outputimageheight = document.getElementById("sliderimageheight");
                            outputimageheight.innerHTML = sliderimgheight.value;

                            sliderimgheight.oninput = function() {
                            outputimageheight.innerHTML = this.value;
                            }
                        </script>

                    </div>
                </div>

                <div id='teamblock4' class="teamblock-content-wrap">
                    <label><?php echo esc_html('Title Color'); ?>
                        <input id="inputtitlcolor" type="color" name="lsfp_option_titlecolor" value="<?php echo esc_attr(get_option('lsfp_option_titlecolor')); ?>" /></label>
                    <label><?php echo esc_html('Text Color'); ?>
                        <input id="inputtextcolor" type="color" name="lsfp_option_textcolor" value="<?php echo esc_attr(get_option('lsfp_option_textcolor')); ?>" /></label>
                    <label><?php echo esc_html('Background Color'); ?>
                        <input id="inputbgcolor" type="color" name="lsp_options[lsfp_option_bgcolor]" value="<?php echo esc_attr($lsp_options['lsfp_option_bgcolor']); ?>" /></label>
                    <label><?php echo esc_html('Button 1 Label Color'); ?>
                        <input id="inputbtn1lcolor" type="color" name="lsfp_option_btnlabelcolor" value="<?php echo esc_attr(get_option('lsfp_option_btnlabelcolor')); ?>" /></label>
                    <label><?php echo esc_html('Button 1 Background Color'); ?>
                        <input id="inputbtn1bgcolor" type="color" name="lsfp_option_btnbgcolor" value="<?php echo esc_attr(get_option('lsfp_option_btnbgcolor')); ?>" /></label>
                    <label><?php echo esc_html('Button 2 Label Color'); ?>
                        <input id="inputbtn2lcolor" type="color" name="lsfp_option_btnlabelcolor1" value="<?php echo esc_attr(get_option('lsfp_option_btnlabelcolor1')); ?>" /></label>
                    <label><?php echo esc_html('Button 2 Background Color'); ?>
                        <input id="inputbtn2bgcolor" type="color" name="lsfp_option_btnbgcolor1" value="<?php echo esc_attr(get_option('lsfp_option_btnbgcolor1')); ?>" /></label>
                    <label><?php echo esc_html('Slider Arrow Color'); ?>
                        <input id="inputarrowbtncolor" type="color" name="lsp_options[ls_sarrowbtn]" value="<?php echo esc_attr($lsp_options['ls_sarrowbtn']); ?>" /></label>
                    <label><?php echo esc_html('Slider Arrow Background Color'); ?>
                        <input id="inputarrowbtnbgcolor" type="color" name="lsp_options[ls_sprevbtnbg]" value="<?php echo esc_attr($lsp_options['ls_sprevbtnbg']); ?>" /></label>
                    <label><?php echo esc_html('Slider Arrow Hover Color'); ?>
                        <input id="inputarrowbtnhrvcolor" type="color" name="lsp_options[ls_sarrowbtnhrv]" value="<?php echo esc_attr($lsp_options['ls_sarrowbtnhrv']); ?>" /></label>
                    <label><?php echo esc_html('Slider Arrow Background Hover Color'); ?>
                        <input id="inputarrowbtnhrvbgcolor" type="color" name="lsp_options[ls_sarrowbtnhrvbg]" value="<?php echo esc_attr($lsp_options['ls_sarrowbtnhrvbg']); ?>" /></label>
                </div>

                <div id='teamblock5' class="teamblock-content-wrap">
                    <div>
                        <label><?php echo esc_html('Title Font Size'); ?> </label>
                            <div>
                                <input type="range" class="slidertitlefontsize" id="myRangetitleSlider" name="lsp_options[lsp_option_titlefontsizeslider]" min="1" max="100" value="<?php echo esc_attr($lsp_options['lsp_option_titlefontsizeslider']); ?>" />
                                <span id="titlefontslider"></span><?php echo esc_html('px'); ?>
                            </div>
                            
                            <script>
                                var slidertitlefontsize = document.getElementById("myRangetitleSlider");
                                var outputtitleslider = document.getElementById("titlefontslider");
                                outputtitleslider.innerHTML = slidertitlefontsize.value;

                                slidertitlefontsize.oninput = function() {
                                outputtitleslider.innerHTML = this.value;
                                }
                            </script>
                    </div>

                    <div class="sliderange">
                        <label><?php echo esc_html('Text Font Size'); ?></label>
                            <div>
                                <input type="range" class="slidertextfontsize" id="myRangetextSlider" name="lsp_options[lsp_option_textfontsizeslider]" min="1" max="100" value="<?php echo esc_attr($lsp_options['lsp_option_textfontsizeslider']); ?>" />
                                <span id="textfontslider"></span><?php echo esc_html('px'); ?>
                            </div>
                            
                            <script>
                                var slidertextfontsize = document.getElementById("myRangetextSlider");
                                var outputtextslider = document.getElementById("textfontslider");
                                outputtextslider.innerHTML = slidertextfontsize.value;

                                slidertextfontsize.oninput = function() {
                                outputtextslider.innerHTML = this.value;
                                }
                            </script>
                    </div>

                    <div class="sliderange">
                        <label><?php echo esc_html('Button Font Size'); ?></label>
                            <div>
                                <input type="range" class="sliderbtntxtfontsize" id="myRangebtntxtSlider" name="lsp_options[lsp_option_btntxtfontsizeslider]" min="1" max="100" value="<?php echo esc_attr($lsp_options['lsp_option_btntxtfontsizeslider']); ?>" />
                                <span id="btntxtfontslider"></span><?php echo esc_html('px'); ?>
                            </div>
                            
                            <script>
                                var sliderbtntxtfontsize = document.getElementById("myRangebtntxtSlider");
                                var outputbtntxtslider = document.getElementById("btntxtfontslider");
                                outputbtntxtslider.innerHTML = sliderbtntxtfontsize.value;

                                sliderbtntxtfontsize.oninput = function() {
                                outputbtntxtslider.innerHTML = this.value;
                                }
                            </script>
                    </div>

                    <div class="sliderange">
                        <label><?php echo esc_html('Font Case'); ?></label>

                        <?php 
                            $lsfp_fontcase = esc_attr($lsp_options['lsfp_fontcase']); 

                            if($lsfp_fontcase == ''){
                                $default_fontcase = 'selected';
                            }
                            else
                            {
                                $default_fontcase = '';
                            }

                            if($lsfp_fontcase == 'uppercase'){
                                $uppercase_fontcase = 'selected';
                            }
                            else
                            {
                                $uppercase_fontcase = '';
                            }

                            if($lsfp_fontcase == 'lowercase'){
                                $lowercase_fontcase = 'selected';
                            }
                            else
                            {
                                $lowercase_fontcase = '';
                            }

                            if($lsfp_fontcase == 'capitalize'){
                                $capitalize_fontcase = 'selected';
                            }
                            else
                            {
                                $capitalize_fontcase = '';
                            }

                        ?>
                        <select name="lsp_options[lsfp_fontcase]" id="fontcase">
                            <option value="" <?php echo esc_attr($default_fontcase); ?>>Default</option>
                            <option value="uppercase" <?php echo esc_attr($uppercase_fontcase); ?>>Uppercase</option>
                            <option value="lowercase" <?php echo esc_attr($lowercase_fontcase); ?>>Lowercase</option>
                            <option value="capitalize" <?php echo esc_attr($capitalize_fontcase); ?>>Capitalize</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="slider-tab-row">
            <?php  submit_button(); ?>
            <button class="buttonreset button-primary" onclick="myFunction()" >Reset</button>
            <script>
                function myFunction() {
                    document.getElementById('myInput').value = 'slide', 
                    document.getElementById('transtduration').value = '4', 
                    document.getElementById('arrowonoff').value='block',
                    document.getElementById('sortorder').value='ASC',
                    document.getElementById('myRangeimghgtSlider').value='0',
                    document.getElementById('inputtitlcolor').value = '#FFFFFF',
                    document.getElementById('inputtextcolor').value = '#FFFFFF',
                    document.getElementById('inputbgcolor').value = '#016efd',
                    document.getElementById('inputbtn1lcolor').value = '#FFFFFF',
                    document.getElementById('inputbtn1bgcolor').value = '#773afd',
                    document.getElementById('inputbtn2lcolor').value = '#000000',
                    document.getElementById('inputbtn2bgcolor').value = '#FFFFFF',           
                    document.getElementById('inputarrowbtncolor').value='#000000',
                    document.getElementById('inputarrowbtnbgcolor').value='#FFFFFF',
                    document.getElementById('inputarrowbtnhrvcolor').value='#FFFFFF',
                    document.getElementById('inputarrowbtnhrvbgcolor').value='#773afd',
                    document.getElementById('myRangetitleSlider').value='55',
                    document.getElementById('myRangetextSlider').value='20',
                    document.getElementById('myRangebtntxtSlider').value='20',
                    document.getElementById('fontcase').value=''
                }
            </script>
        </div>
    </form>
  </div>
<?php }

/* --------- New -------- */
add_action( 'admin_init', 'lsp_register_settings' );
function lsp_register_settings() {
    register_setting('lsfp_options_group', 'lsp_options', 'lsp_validate_options');
}



/***** Start Add custome fields for slider luzuk section *****/
/**
 * @author Luzuk <support@luzuk.com>
 **/

/**
 * When the post is saved, saves our custom data
 * @author Luzuk <support@luzuk.com>
 **/
function sliderluzukpostButtonCutomFieldHtml(){
    global $post;
    // get the saved value
    $buttonlabel = get_post_meta($post->ID, 'buttonlabel', false);
    $buttonlabel = !empty($buttonlabel[0])?$buttonlabel[0]:'';

    $buttonlink = get_post_meta($post->ID, 'buttonlink', false);
    $buttonlinkvalue = !empty($buttonlink[0])?$buttonlink[0]:'';

    $buttonlabel1 = get_post_meta($post->ID, 'buttonlabel1', false);
    $buttonlabel1 = !empty($buttonlabel1[0])?$buttonlabel1[0]:'';

    $buttonlink1 = get_post_meta($post->ID, 'buttonlink1', false);
    $buttonlinkvalue1 = !empty($buttonlink1[0])?$buttonlink1[0]:'';

    // Use nonce for verification
    echo '<table width="100%">';
    echo '<tr>
        <th width="10%">1. Button label :</span></th>
        <td width="10%"><input type="text" name="buttonlabel" value="'.$buttonlabel.'" /></td>
        <th width="10%">Button link :</span></th>
        <td ><input type="text" name="buttonlink" value="'.$buttonlinkvalue.'" /></td>
    </tr>';
    echo '<tr>
        <th width="10%">2. Button label :</span></th>
        <td width="10%"><input type="text" name="buttonlabel1" value="'.$buttonlabel1.'" /></td>
        <th width="10%">Button link :</span></th>
        <td ><input type="text" name="buttonlink1" value="'.$buttonlinkvalue1.'" /></td>
    </tr>';
    echo '</table>';
}

function addSliderluzukpostHook(){
    add_meta_box('sliderluzuk-text', __('Add Button', 'luzuk-premium'), 'sliderluzukpostButtonCutomFieldHtml', 'lsfp-slider', 'normal', 'high');
} 

function savesliderluzukpostButtonCutomData($post_id){
    // If it is our form has not been submitted, so we dont want to do anything
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if(empty($_POST['buttonlink']) && empty($_POST['buttonlabel']) && empty($_POST['buttonlink1']) && empty($_POST['buttonlabel1']) && empty($_POST['lsfp_option_name']) && empty($_POST['lsfp_option_titlecolor']) && empty($_POST['lsfp_option_textcolor']) && empty($_POST['lsfp_option_btnbgcolor']) && empty($_POST['lsfp_option_btnlabelcolor']) && empty($_POST['lsfp_option_btnbgcolor1']) && empty($_POST['lsfp_option_btnlabelcolor1']) && empty($_POST['lsfp_option_sel_template']) && empty($_POST['teamslidertransitionduration']) && empty($_POST['lsfp_sortpostorder']) && empty($_POST['lsp_option_imageheight'])){
        // echo 'empty --> '; exit;
        return;
    }

    $buttonlink = sanitize_text_field($_POST['buttonlink']);
    update_post_meta($post_id, 'buttonlink', $buttonlink);

    $buttonlabel = sanitize_text_field($_POST['buttonlabel']);
    update_post_meta($post_id, 'buttonlabel', $buttonlabel);

    $buttonlink1 = sanitize_text_field($_POST['buttonlink1']);
    update_post_meta($post_id, 'buttonlink1', $buttonlink1);

    $buttonlabel1 = sanitize_text_field($_POST['buttonlabel1']);
    update_post_meta($post_id, 'buttonlabel1', $buttonlabel1);

    $lsfp_option_name = sanitize_text_field($_POST['lsfp_option_name']);
    update_post_meta($post_id, 'lsfp_option_name', $lsfp_option_name);

    $lsfp_option_titlecolor = sanitize_text_field($_POST['lsfp_option_titlecolor']);
    update_post_meta($post_id, 'lsfp_option_titlecolor', $lsfp_option_titlecolor);

    $lsfp_option_textcolor = sanitize_text_field($_POST['lsfp_option_textcolor']);
    update_post_meta($post_id, 'lsfp_option_textcolor', $lsfp_option_textcolor);

    $lsfp_option_btnbgcolor = sanitize_text_field($_POST['lsfp_option_btnbgcolor']);
    update_post_meta($post_id, 'lsfp_option_btnbgcolor', $lsfp_option_btnbgcolor);

    $lsfp_option_btnlabelcolor = sanitize_text_field($_POST['lsfp_option_btnlabelcolor']);
    update_post_meta($post_id, 'lsfp_option_btnlabelcolor', $lsfp_option_btnlabelcolor);

    $lsfp_option_btnbgcolor1 = sanitize_text_field($_POST['lsfp_option_btnbgcolor1']);
    update_post_meta($post_id, 'lsfp_option_btnbgcolor1', $lsfp_option_btnbgcolor1);

    $lsfp_option_btnlabelcolor1 = sanitize_text_field($_POST['lsfp_option_btnlabelcolor1']);
    update_post_meta($post_id, 'lsfp_option_btnlabelcolor1', $lsfp_option_btnlabelcolor1);

    $lsfp_option_sel_template = sanitize_text_field($_POST['lsfp_option_sel_template']);
    update_post_meta($post_id, 'lsfp_option_sel_template', $lsfp_option_sel_template);

    $teamslidertransitionduration = sanitize_text_field($_POST['teamslidertransitionduration']);
    update_post_meta($post_id, 'teamslidertransitionduration', $teamslidertransitionduration);

    $lsfp_sortpostorder = sanitize_text_field($_POST['lsfp_sortpostorder']);
    update_post_meta($post_id, 'lsfp_sortpostorder', $lsfp_sortpostorder);

    $lsp_option_imageheight = sanitize_text_field($_POST['lsp_option_imageheight']);
    update_post_meta($post_id, 'lsp_option_imageheight', $lsp_option_imageheight);


}

add_action('add_meta_boxes', 'addSliderluzukpostHook');
add_action('save_post', 'savesliderluzukpostButtonCutomData');

// /***** End Add custome fields for slider section *****/

/**
 * Liting the slider/trainer details
 * @param : int $pageId default is null
 * @param : boolean $isCustomizer default is false, if set to true will get the data stored with customizer
 * @param : int $i default is null, it will used as a iteration for data with customizer, this will be used only if the $isCustomizer is set to true.
 * @return: Text $text
 */

// slider shortcode
function lsfp_short_code1_slider($pageId = null, $isCustomizer = false, $i = null) {

    global $lsp_options;

    ob_start();
    $args = array('post_type' => 'lsfp-slider', 'orderby' => 'meta_value', 'order' => get_option('lsfp_sortpostorder'));
    if (!empty($pageId)) {
        $args['page_id'] = absint($pageId);
    }
    $text = '';
    $query = new WP_Query($args);
    if ($query->have_posts()):
        $postN = 0;
 ?>

<?php
    if (get_option('lsfp_option_sel_template') == "Template1" ) { ?>


    <div class="lsfp_section" id="slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <?php
                    while ($query->have_posts()) : $query->the_post();
                    $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-luzuk-thumb');
                    $post = get_post();

                    //button1
                    $buttonlabel = get_post_meta($post->ID, 'buttonlabel', false);
                    $sliderluzuk_buttonlabel = !empty($buttonlabel[0]) ? $buttonlabel[0] : '';

                    $buttonlink = get_post_meta($post->ID, 'buttonlink', false);
                    $sliderluzuk_buttonlink = !empty($buttonlink[0]) ? $buttonlink[0] : '';

                    //button2
                    $buttonlabel1 = get_post_meta($post->ID, 'buttonlabel1', false);
                    $sliderluzuk_buttonlabel1 = !empty($buttonlabel1[0]) ? $buttonlabel1[0] : '';

                    $buttonlink1 = get_post_meta($post->ID, 'buttonlink1', false);
                    $sliderluzuk_buttonlink1 = !empty($buttonlink1[0]) ? $buttonlink1[0] : '';



                ?>

                <div class="lsfp-slide swiper-slide">

                    <?php
                        if(has_post_thumbnail()){
                            $total_slider_image = $luzuk_image[0];
                        } else {
                            $total_slider_image = get_template_directory_uri() . '/images/default.png';
                        }
                    
                    ?>

                    <?php 
                        $imghgtSlider = get_option('lsp_option_imageheight'); 
                    ?>

                    <img class="slide-mainimg" style=" 
                    <?php if( $imghgtSlider == "0" ){  ?>
                        height : auto;
                    <?php } else { ?> 
                        height : <?php echo esc_attr(get_option('lsp_option_imageheight')); ?>px;
                    <?php } ?> " src="<?php echo esc_url($total_slider_image); ?>" alt="<?php get_the_title(); ?>"/>
                    <div class="lsfp-overlay"></div>

                    <div class="lsfp-content" data-wow-duration="1s">
                        <div class="lsfp-title wow bounceInDown" style="color: <?php echo esc_attr(get_option('lsfp_option_titlecolor')); ?>" >
                            <?php echo esc_html(get_the_title()); ?>
                        </div>
                        <div class="lsfp-sub-title wow bounceInLeft" style="color: <?php echo esc_attr(get_option('lsfp_option_textcolor')); ?>" >
                            <?php echo esc_html(get_the_content()); ?>
                        </div>
                        <ul>
                            <?php
                            if(!empty($sliderluzuk_buttonlabel)){ ?>
                                <li class="lsfp-btna" >
                                    <div class="btn5">
                                        <a style="background: <?php echo esc_attr(get_option('lsfp_option_btnbgcolor')); ?>" href="<?php echo esc_url($sliderluzuk_buttonlink); ?>">
                                            <span style="color: <?php echo esc_attr(get_option('lsfp_option_btnlabelcolor')); ?>" ><?php echo esc_html($sliderluzuk_buttonlabel); ?></span>
                                        </a>
                                    </div>
                                </li>
                            <?php }?>
                            <?php
                            if(!empty($sliderluzuk_buttonlabel1)){ ?>
                                <li class="lsfp-btna btn2">
                                    <div class="btn5">
                                        <a style="background: <?php echo esc_attr(get_option('lsfp_option_btnbgcolor1')); ?>" href="<?php echo esc_url($sliderluzuk_buttonlink1); ?>">
                                            <span style="color: <?php echo esc_attr(get_option('lsfp_option_btnlabelcolor1')); ?>"><?php echo esc_html($sliderluzuk_buttonlabel1); ?></span>
                                        </a>
                                    </div>
                                </li>
                            <?php }?>
                        </ul>
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <?php
                endwhile;
                ?>
            </div>
            <div class="swiper-button-next"><i class="fas fa-chevron-right"></i></div>
            <div class="swiper-button-prev"><i class="fas fa-chevron-left"></i></div>
        </div>
    </div>
    <script>
        // Swiper Configuration
        var swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 10,
        centeredSlides: true,
        freeMode: false,
        grabCursor: true,
        loop: true,
        autoHeight: true,
        effect: '<?php echo esc_attr(get_option('lsfp_option_name')); ?>',
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        autoplay: {
            delay: <?php echo esc_attr(get_option('teamslidertransitionduration')); ?>000,
            disableOnInteraction: false
        },
        breakpoints: {
            500: {
            slidesPerView: 1
            },
            700: {
            slidesPerView: 1
            }
        }
        });
    </script>

<?php } else if (get_option('lsfp_option_sel_template') == "Template2" ) {?>

   <div class="lsfp_section-temp2" id="slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <?php
                    while ($query->have_posts()) : $query->the_post();
                    $luzuk_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'total-luzuk-thumb');
                    $post = get_post();

                    //button1
                    $buttonlabel = get_post_meta($post->ID, 'buttonlabel', false);
                    $sliderluzuk_buttonlabel = !empty($buttonlabel[0]) ? $buttonlabel[0] : '';

                    $buttonlink = get_post_meta($post->ID, 'buttonlink', false);
                    $sliderluzuk_buttonlink = !empty($buttonlink[0]) ? $buttonlink[0] : '';

                    //button2
                    $buttonlabel1 = get_post_meta($post->ID, 'buttonlabel1', false);
                    $sliderluzuk_buttonlabel1 = !empty($buttonlabel1[0]) ? $buttonlabel1[0] : '';

                    $buttonlink1 = get_post_meta($post->ID, 'buttonlink1', false);
                    $sliderluzuk_buttonlink1 = !empty($buttonlink1[0]) ? $buttonlink1[0] : '';

                ?>

                <div class="lsfp-slide-temp2 swiper-slide">

                    <div class="lsfp-slide-img-temp2">
                        <div class="lsfp-img-slide-responsive" style="position: absolute; display: block; visibility: visible; z-index: 5; transform: matrix(1, 0, 0, 1, 0, 0);">
                            <div class="tp-loop-wrap rs-wave" style="position: absolute; display: block; min-height: 486px; min-width: 805px; transform: matrix(1, 0, 0, 1, 0, 0);">
                                <div class="tp-mask-wrap" style="position: absolute; display: block; overflow: visible;">                           <?php 
                                    if(has_post_thumbnail()){
                                        $total_slider_image = $luzuk_image[0];
                                    } else {
                                        $total_slider_image = get_template_directory_uri() . '/images/default.png';
                                    }?>   
                                      
                                      <?php 
                        $imghgtSlider = get_option('lsp_option_imageheight'); 
                    ?>

                    <img class="lsfp-slide-img-curve" width="988" height="731" style=" 
                    <?php if( $imghgtSlider == "0" ){  ?>
                        height : auto;
                    <?php } else { ?> 
                        height : <?php echo esc_attr(get_option('lsp_option_imageheight')); ?>px !important;
                    <?php } ?> width: 805px; height: 630px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; " src="<?php echo esc_url($total_slider_image); ?>" alt="<?php get_the_title(); ?>"/>
                                
                                      <!-- <img alt="'. esc_html(get_the_title()) .'" class="lsfp-slide-img-curve" width="988" height="731" style="width: 805px; height: 630px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px;" src="'.esc_url($total_slider_image[0]).'"> -->
                                </div>
                            </div>
                        </div> 
                           
                    <?php
                        if(has_post_thumbnail()){
                            $total_slider_image = $luzuk_image[0];
                        } else {
                            $total_slider_image = get_template_directory_uri() . '/images/default.png';
                        }
                    
                    ?>

                    <?php 
                        $imghgtSlider = get_option('lsp_option_imageheight'); 
                    ?>

                    <img class="lsfp-slide-mainimg" style=" 
                    <?php if( $imghgtSlider == "0" ){  ?>
                        height : auto;
                    <?php } else { ?> 
                        height : <?php echo esc_attr(get_option('lsp_option_imageheight')); ?>px !important;
                    <?php } ?> " src="<?php echo esc_url($total_slider_image); ?>" alt="<?php get_the_title(); ?>"/>


                        <div class="lsfp-slider-top-img">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/sliderdotimage.png'; ?>">
                        </div>
                         <div class="lsfp-slider-bottom-img">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/sliderdotimage.png'; ?>">
                        </div>
                    </div>
                     <!-- <div class="lsfp-overlsfp-slider-imglay-temp2"></div> -->
                    <div class="lsfp-content-temp2" data-wow-duration="1s">
                        <div class="lsfp-slider-img">
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/sliderdotimage.png'; ?>">
                        </div>
                        <div class="lsfp-title-temp2 wow bounceInDown" style="color: <?php echo esc_attr(get_option('lsfp_option_titlecolor')); ?>" >
                            <?php echo esc_html(get_the_title()); ?>
                        </div>
                        <div class="lsfp-sub-title-temp2 wow bounceInLeft" style="color: <?php echo esc_attr(get_option('lsfp_option_textcolor')); ?>" >
                            <?php echo esc_html(get_the_content()); ?>
                        </div>
                        <ul>
                            <?php
                            if(!empty($sliderluzuk_buttonlabel)){ ?>
                                <li class="lsfp-btna-temp2" >
                                    <div class="btn5">
                                        <a style="background: <?php echo esc_attr(get_option('lsfp_option_btnbgcolor')); ?>" href="<?php echo esc_url($sliderluzuk_buttonlink); ?>">
                                            <span style="color: <?php echo esc_attr(get_option('lsfp_option_btnlabelcolor')); ?>" ><?php echo esc_html($sliderluzuk_buttonlabel); ?></span>
                                        </a>
                                    </div>
                                </li>
                            <?php }?>
                            <?php
                            if(!empty($sliderluzuk_buttonlabel1)){ ?>
                                <li class="lsfp-btna-temp2 btn2">
                                    <div class="btn5">
                                        <a style="background: <?php echo esc_attr(get_option('lsfp_option_btnbgcolor1')); ?>" href="<?php echo esc_url($sliderluzuk_buttonlink1); ?>">
                                            <span style="color: <?php echo esc_attr(get_option('lsfp_option_btnlabelcolor1')); ?>"><?php echo esc_html($sliderluzuk_buttonlabel1); ?></span>
                                        </a>
                                    </div>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <?php
                endwhile;
                ?>
            </div>
            <div class="swiper-button-next"><i class="fas fa-chevron-right"></i></div>
            <div class="swiper-button-prev"><i class="fas fa-chevron-left"></i></div>
        </div>
    </div>
    <script>
        // Swiper Configuration
        var swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        spaceBetween: 10,
        centeredSlides: true,
        freeMode: false,
        grabCursor: true,
        loop: true,
        autoHeight: true,
        effect: '<?php echo esc_attr(get_option('lsfp_option_name')); ?>',
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        autoplay: {
            delay: <?php echo esc_attr(get_option('teamslidertransitionduration')); ?>000,
            disableOnInteraction: false
        },
        breakpoints: {
            500: {
            slidesPerView: 1
            },
            700: {
            slidesPerView: 1
            }
        }
        });
    </script>



<?php } else if (get_option('lsfp_option_sel_template') == "Template3" ) {?>

    
<?php }?>


<?php
    $text = ob_get_contents();
    ob_clean();
    endif;
    wp_reset_postdata();
    return $text;
}


// shortcode
add_shortcode('luzuk_slider', 'lsfp_short_code1_slider');

?>
