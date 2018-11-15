<?php

/*
 * Section Anchor Creator
 *
 * since 4.2.3
 * version 1.0
 */

if ( ! class_exists( 'UT_Section_Anchor_Param' ) ) {

    class UT_Section_Anchor_Param {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        /**
         * @var string
         */
        protected $value = '';
        
        function __construct( $settings, $value ) {
            
            $this->settings = $this->settings( $settings );            
            $this->value    = $this->value( $value );
            
        }
        
        /**
         * Settings
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }
        
        function render() {
            
            $out .= '<div class="ut-section-anchor-wrap">';
                    
                $out .= '<input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ut-section-anchor-input ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="text" value="' . esc_attr( $this->value ) . '" />';           
                
                $out .= '<span class="vc_description vc_clearfix">' . esc_html__( 'Please enter a unique section name.', 'ut_shortcodes' ) . '</span>';
                
                $out .= '<div class="clear"></div>';
                
                $out .= '<code class="ut-url-code"><span class="ut-url"></span><span class="ut-section-id"></span></code>';
                
                $out .= '<span class="vc_description vc_clearfix">' . sprintf( esc_html__( 'This is your final custom link. You can copy this URL and manually add it as a custom link to the themes primary navigation or a custom link such as a button or any other element which supports links. By using the button beneath, the system will add the menu item program automatically to the themes primary navigation. Afterwards you simply need to re order the item. If you are using the custom link on a button, please copy the link, add it to the desired element and additionally add the following CSS class to it: %s', 'ut_shortcodes' ), '<strong>ut-scroll-to-section</strong>' ) . '</span>';
                
                $out .= '<div class="clear"></div>';
                
                $out .= '<button class="ut-add-anchor-section ut-ui-button" rel="" title="' . __( 'Add to menu', 'ut_shortcodes' ) . '">' . __( 'Add to menu', 'ut_shortcodes' ) . '</button>';
                                
            $out .= '</div>';
            
            return $out;
       
        }               
            
    }

}

/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_add_vc_section_anchor_param_type( $settings, $value ) {
    
    $section_anchor = new UT_Section_Anchor_Param( $settings, $value );
    return $section_anchor->render();

}

vc_add_shortcode_param( 
    'section_anchor', 
    'ut_add_vc_section_anchor_param_type', 
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/section-anchor.js' 
);

/*
 * Ajax Request for Section Anchor
 *
 * since 4.2.3
 * version 1.0
 */

function ut_save_anchor_to_menu() {
            
    if( !current_user_can('edit_posts') ) {
        return;    
    }
    
    $menu_locations = get_nav_menu_locations();
    
    if( !empty( $menu_locations['primary'] ) ) {
        
        $title  = $_POST['title'];
        $url    = esc_url( $_POST['url'] );
        
        if( !empty( $title ) && !empty( $url ) ) {
        
            wp_update_nav_menu_item( 
                $menu_locations['primary'], 0, 
                array(
                    'menu-item-title'   =>  $title,
                    'menu-item-url'     =>  $url, 
                    'menu-item-status'  => 'publish'
                )
            );
            
            echo 'item_added';
            
        } else {
            
            echo 'error';
            
        }
        
    } else {
        
        echo 'no_menu';        
    
    }
                    
    exit;

}

add_action( 'wp_ajax_save_section_anchor', 'ut_save_anchor_to_menu' );


/*
 * Range Slider 
 *
 * since 4.0
 * version 1.0
 */

if( !function_exists('ut_add_vc_range_slider_param_type') ) :

    function ut_add_vc_range_slider_param_type( $settings, $value ) {
        
        $value = empty( $value ) && $value != 0 ? 0 : $value;
        
        $out = '<div class="ut_range_slider_block">'; 
                
            $out .= '<div class="ut-range-slider-wrap">';
                
                $out .= '<div data-value="' . esc_attr( $value ) . '" data-min="' . esc_attr( $settings['value']['min'] ) . '" data-max="' . esc_attr( $settings['value']['max'] ) . '" data-step="' . esc_attr( $settings['value']['step'] ) . '" data-for="ut_range_slider_' . esc_attr( $settings['param_name'] ) . '" class="ut-range-slider"></div>';
                $out .= '<span data-unit="' . esc_attr( $settings['value']['unit'] ) . '" class="ut-range-value">' . esc_attr( $value ) . '</span>';
                $out .= '<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />';
            
            $out .= '</div>'; 
                
        $out .= '</div>'; 
        
        return $out; 
        
    }    
    
    vc_add_shortcode_param( 'range_slider', 'ut_add_vc_range_slider_param_type', UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/range-slider.js' );

endif;


/*
 * United Themes CSS Editor
 *
 * since 4.2
 * version 1.0
 */


if ( ! class_exists( 'UT_CSS_Editor' ) ) {

    class UT_CSS_Editor {
        
        /**
         * @var array
         */
        protected $settings = array();
        
        /**
         * @var string
         */
        protected $value = '';
        
        /**
         * @var array
         */
        protected $layers = array( 'margin', 'padding', 'content' );
        
        /**
         * @var array
         */
        protected $positions = array( 'top', 'right', 'bottom', 'left' );
        
        /**
         *
         */
        function __construct() {
        
        
        }

        /**
         * Setters/Getters {{
         *
         * @param null $settings
         *
         * @return array
         */
        function settings( $settings = null ) {
            
            if ( is_array( $settings ) ) {
                $this->settings = $settings;
            }

            return $this->settings;
            
        }
        
        /**
         * @param $key
         *
         * @return string
         */
        function setting( $key ) {
            
            return isset( $this->settings[ $key ] ) ? $this->settings[ $key ] : '';
            
        }

        /**
         * @param null $value
         *
         * @return string
         */
        function value( $value = null ) {
            
            if ( is_string( $value ) ) {
                $this->value = $value;
            }

            return $this->value;
            
        }

        /**
         * @param null $values
         *
         * @return array
         */
        function params( $values = null ) {
            
            if ( is_array( $values ) ) {
                $this->params = $values;
            }

            return $this->params;
            
        }
        
        /**
         * 
         * @return mixed|void
         */
        function render() {
            
            $out  = '<div class="vc_css-editor vc_row vc_ui-flex-row ut-css-editor">';
                
                $out .= '<input id="ut-css-editor" name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $this->value ) . '" />';
                
                $out .= '<div class="vc_layout-onion vc_col-xs-7">';
                    
                    $out .= '<div class="vc_margin">' . $this->layerControls( 'margin' );
                        
                        $out .= '<div class="vc_padding">' . $this->layerControls( 'padding' );
                        
                            $out .= '<div class="vc_content"></div>';
                        
                        $out .= '</div>';
                    
                    $out .= '</div>';
                    
                $out .= '</div>';
        
            $out .= '</div>';
            
            return $out;
        
        }
        
        /**
         * @param $name
         * @param string $prefix
         *
         * @return string
         */
        protected function layerControls( $name, $prefix = '' ) {

            $output = '<label>' . $name . '</label>';

            foreach ( $this->positions as $pos ) {
                
                $output .= '<input type="text" name="' . $name . '_' . $pos . ( '' !== $prefix ? '_' . $prefix : '' ) . '" data-name="' . $name . ( '' !== $prefix ? '-' . $prefix : '' ) . '-' . $pos . '" class="vc_' . $pos . ' ut-css-editor-field" placeholder="-" data-attribute="' . $name . '-' . $pos . '" value="">';
                
            }

            return $output;
            
        }

    }

}
             

/**
 * @param $settings
 * @param $value
 *
 * @return mixed|void
 */
function ut_vc_css_editor_form_field( $settings, $value ) {
    
    $css_editor = new UT_CSS_Editor();
    $css_editor->settings( $settings );
    $css_editor->value( $value );

    return $css_editor->render();

}

vc_add_shortcode_param( 
    'ut_css_editor', 
    'ut_vc_css_editor_form_field',
    UT_SHORTCODES_URL . '/vc/admin/assets/vc_extend/spacing.js'
);