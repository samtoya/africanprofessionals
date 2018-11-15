<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Letter_Effects' ) ) {
	
    class UT_Letter_Effects {
        
        private $shortcode;
        private $add_script;  
        
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_letter_effects';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
            /* scripts */
            add_action( 'init', array( $this, 'register_scripts' ) );
            add_action( 'wp_footer', array( $this, 'enqueue_scripts' ) );
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Letter Effects', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/word-rotator.png',
                        'category'        => 'Brooklyn ( Base )',
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Rotation Time', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'value in miliseconds, eg "3000"', 'ut_shortcodes'),
                                'param_name'        => 'timer',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'exploded_textarea',
                                'heading'           => esc_html__( 'Words', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Each new line will be separate Word.', 'ut_shortcodes'),
                                'admin_label'       => true,
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Font Size', 'ut_shortcodes' ),
                                'description'       => esc_html__( '(optional) value in px or em, eg "20px" or "6em"' , 'ut_shortcodes' ),
                                'param_name'        => 'font_size',
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Font Color', 'ut_shortcodes' ),
								'param_name'        => 'font_color',
								'group'             => 'General'
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Display', 'ut_shortcodes' ),
								'param_name'        => 'display',
								'group'             => 'General',
                                'value'             => array(
                                    esc_html__( 'Inline' , 'ut_shortcodes' ) => 'inline',
                                    esc_html__( 'Block'  , 'ut_shortcodes' ) => 'block',
                                ),
						  	), 
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Text Align', 'ut_shortcodes' ),
								'param_name'        => 'text_align',
								'group'             => 'General',
                                'dependency' => array(
                                    'element' => 'display',
                                    'value'   => array( 'block' ),
                                ),
                                'value'             => array(
                                    esc_html__( 'left'   , 'ut_shortcodes' ) => 'left',
                                    esc_html__( 'center' , 'ut_shortcodes' ) => 'center',
                                    esc_html__( 'right' , 'ut_shortcodes' ) => 'right',
                                ),
						  	)
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            /* enqueue scripts */
            $this->add_script = true;
            
            extract( shortcode_atts( array (
                'timer'      => 2000,
                'effect'     => 'fx10',
                'font_size'  => '',
                'font_color' => '',
                'text_align' => '',
                'class'      => ''
            ), $atts ) ); 
            
            /* classes */
            $classes    = array('ut-word-effects');
            $classes[]  = $class;
            
            /* unique ID */
            $id = uniqid("ut_word_effects_");
            
            ob_start(); ?>
            
                <style type="text/css" scoped>
                    
                    <?php if( $font_size ) : ?>
                        
                        #<?php echo $id; ?> .title { 
                            font-size: <?php echo $font_size; ?>;                     
                        }
                        
                    <?php endif; ?>    
                    
                    <?php if( $font_color ) : ?>
                        
                        #<?php echo $id; ?> .title { color: <?php echo $font_color; ?> !important; }';
                        
                    <?php endif; ?>
                    
                    <?php if( $text_align ) : ?>
                        
                        #<?php echo $id; ?> .ut-word-effect-slide { 
                            -webkit-align-items: <?php echo $text_align; ?>;
                                 -ms-flex-align: <?php echo $text_align; ?>;
                                    align-items: <?php echo $text_align; ?>;
                            
                            -webkit-justify-content: <?php echo $text_align; ?>;
                                -ms-justify-content: <?php echo $text_align; ?>;        
                                    justify-content: <?php echo $text_align; ?>;
                        }
                        
                    <?php endif; ?>
                
                </style>
            
            <?php
            
            $css = ob_get_clean();
            
            /* start output */
            $output = '';
            
            /* attach css */
            $output .= ut_minify_inline_css( $css );
            
            /* split up words */
            $words = explode( ',' , $content );
            
            if( !empty( $words ) && is_array( $words ) ) {
                
                $count = 1;
                    
                $output .= '<div id="' . $id . '" class="' . implode( ' ', $classes ) . '" data-effect="' . esc_attr( $effect ) . '" data-timer="' . esc_attr( $timer ) . '">';
                
                    foreach( $words as $key => $word ) {                
                                 
                        $output .= '<div class="ut-word-effect-slide ' . ( $count == 1 ? 'slide--current' : '' ) . '"><h1 class="title letter-effect">' . $word . '</h1></div>';                
                        
                        $count++;
                                
                    }
                
                $output .= '</div>';
            
            }
                                        
            return $output;
        
        }
        
        function register_scripts() {
            
            $min = NULL;
        
            if( !WP_DEBUG ){
                $min = '.min';
            }
            
            wp_register_script( 
                'ut-anime', 
                plugins_url('../js/plugins/letter-effects/anime.min.js', __FILE__), 
                array('jquery'), 
                UT_SHORTCODES_VERSION, 
                true
            );
            
            wp_register_script( 
                'ut-charming', 
                plugins_url('../js/plugins/letter-effects/charming.min.js', __FILE__), 
                array('jquery'), 
                UT_SHORTCODES_VERSION, 
                true
            );
            
            wp_register_script( 
                'ut-letter-effects', 
                plugins_url('../js/plugins/letter-effects/textfx' . $min . '.js', __FILE__), 
                array('jquery'), 
                UT_SHORTCODES_VERSION, 
                true
            );
        
        }
        
        function enqueue_scripts() {
            
            if( !$this->add_script ) {
                return;
            }
            
            wp_print_scripts('ut-charming');
            wp_print_scripts('ut-anime');
            wp_print_scripts('ut-letter-effects');
        
        }
            
    }

}

new UT_Letter_Effects;