<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Service_Column_Vertical' ) ) {
	
    class UT_Service_Column_Vertical {
        
        private $shortcode;
            
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_service_column_vertical';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Service Column Vertical', 'ut_shortcodes' ),
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( Base )',
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/service-column-vertical.png',
                        'class'           => '',
                        'content_element' => true,
                        'params'          => array(
                            array(
								'type'              => 'iconpicker',
                                'heading'           => esc_html__( 'Choose Icon', 'ut_shortcodes' ),
                                'param_name'        => 'icon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'attach_image',
                                'heading'           => esc_html__( 'or upload an own Icon', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'recommended size 32x32', 'ut_shortcodes' ),
                                'param_name'        => 'imageicon',
                                'group'             => 'General',                                
                            ),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'color',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Icon Background Color', 'ut_shortcodes' ),
                                'param_name'        => 'background',
								'group'             => 'Colors'
						  	),
                            array(
								'type'              => 'dropdown',
								'class'             => '',
								'heading'           => esc_html__( 'Icon Shape', 'ut_shortcodes' ),
								'param_name'        => 'shape',
								'value'             => '',
								'description'       => '',
								'group'             => 'General',
                                'value'             => array(
                                    'normal'    => esc_html__( 'normal', 'ut_shortcodes' ),
                                    'round'     => esc_html__( 'round', 'ut_shortcodes' ),
                                ),
						  	),  
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Headline', 'ut_shortcodes' ),
                                'description'       => esc_html__( '', 'ut_shortcodes' ),
                                'param_name'        => 'headline',
                                'admin_label'       => true,
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'class'             => '',
								'heading'           => esc_html__( 'Column Headline Color', 'ut_shortcodes' ),
								'param_name'        => 'headline_color',
								'value'             => '',
								'description'       => '',
								'group'             => 'Colors'
						  	),
                            array(
                                'type'              => 'textarea',
                                'heading'           => esc_html__( 'Column Text', 'ut_shortcodes' ),
                                'admin_label'       => true,
                                'param_name'        => 'content',
                                'group'             => 'General'
                            ),
                            array(
								'type'              => 'colorpicker',
								'class'             => '',
								'heading'           => esc_html__( 'Column Text Color', 'ut_shortcodes' ),
								'param_name'        => 'text_color',
								'value'             => '',
								'description'       => '',
								'group'             => 'Colors'
						  	),
                            
                            /* animation */
                            array(
                                'type'              => 'animation_style',
                                'heading'           => __( 'Animation Effect', 'ut_shortcodes' ),
                                'description'       => __( 'Select image animation effect.', 'ut_shortcodes' ),
                                'group'             => 'Animation',
                                'param_name'        => 'effect',
                                'settings' => array(
                                    'type' => array(
                                        'in',
                                        'out',
                                        'other',
                                    ),
                                )
                                
                            ),
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Animation Duration', 'unitedthemes' ),
                                'description'       => esc_html__( 'Animation time in seconds  e.g. 1s', 'unitedthemes' ),
                                'param_name'        => 'animation_duration',
                                'group'             => 'Animation',
                            ), 
                             
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Once?', 'unitedthemes' ),
                                'description'       => esc_html__( 'Animate only once when reaching the viewport, animate everytime when reaching the viewport or make the animation infinite? By default the animation executes everytime when the element becomes visible in viewport, means when leaving the viewport the animation will be reseted and starts again when reaching the viewport again. By setting this option to yes, the animation executes exactly once. By setting it to infinite, the animation loops all the time, no matter if the element is in viewport or not.', 'unitedthemes' ),
                                'param_name'        => 'animate_once',
                                'group'             => 'Animation',
                                'value'             => array(
                                    esc_html__( 'no' , 'unitedthemes' )      => 'no',
                                    esc_html__( 'yes', 'unitedthemes' )      => 'yes',
                                    esc_html__( 'infinite', 'unitedthemes' ) => 'infinite',
                                )
                            ),  
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Image on Tablet?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_tablet',
                                'group'             => 'Animation',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Animate Image on Mobile?', 'ut_shortcodes' ),
                                'param_name'        => 'animate_mobile',
                                'group'             => 'Animation',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'
                                ),
                            ),                            
                            
                            array(
                                'type'              => 'dropdown',
                                'heading'           => esc_html__( 'Delay Animation?', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Time in milliseconds until the image appears. e.g. 200', 'ut_shortcodes' ),
                                'param_name'        => 'delay',
                                'group'             => 'Animation',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'no', 'ut_shortcodes' ) => 'false',
                                    esc_html__( 'yes'  , 'ut_shortcodes' ) => 'true'                                                                        
                                )
                            ),
                            
                            array(
                                'type'              => 'textfield',
                                'heading'           => esc_html__( 'Delay Timer', 'ut_shortcodes' ),
                                'description'       => esc_html__( 'Time in milliseconds until the next image appears. e.g. 200', 'ut_shortcodes' ),
                                'param_name'        => 'delay_timer',
                                'group'             => 'Animation',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'dependency'        => array(
                                    'element' => 'delay',
                                    'value'   => 'true',
                                )
                            ),
                                                        
                            /* css */                            
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design options', 'ut_shortcodes' ),
                            ),                            
                            array(
								'type'              => 'textfield',
								'heading'           => esc_html__( 'CSS Class', 'ut_shortcodes' ),
								'param_name'        => 'class',
								'group'             => 'General'
						  	),     
                            
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'icon'              => '',
                'imageicon'         => '',
                'shape'             => 'normal',
                'color'             => get_option('ut_accentcolor' , '#F1C40F'),
                'headline_color'    => '',
                'text_color'        => '',
                'background'        => '',
                'headline'          => '',
                'effect'            => '',      
                'animate_once'      => 'no',
                'animate_tablet'    => 'no',
                'animate_mobile'    => 'no',
                'delay'             => 'no',
                'delay_timer'       => '200',
                'animation_duration'=> '',  
                'width'             => '',       /* deprecated */
                'margin_bottom'     => '',       /* deprecated */
                'last'              => 'false',  /* deprecated */
                'css'               => '',
                'class'             => ''
            ), $atts ) ); 
            
            $classes    = array();
            $attributes = array();
            $classes_2  = array();
            
            /* deprecated - will be removed one day - start block */
            
                $grid = array( 
                    'third'   => 'ut-one-third',
                    'fourth'  => 'ut-one-fourth',
                    'half'    => 'ut-one-half',
                    'full'    => ''
                );  
                
                $classes[] = ( $last == 'true' ) ? 'ut-column-last' : '';
                $classes[] = !empty( $grid[$width] ) ? $grid[$width] : 'clearfix';
                $classes[] = $class;
                    
                /* margin bottom*/
                $margin_bottom = !empty($margin_bottom) ? 'style="margin-bottom:' . $margin_bottom . 'px"' : '';                
                
            /* deprecated - will be removed one day - end block */
            
            
            /* animation effect */
            $dataeffect = NULL;
            
            if( !empty( $effect ) ) {
                
                $attributes['data-effect']      = esc_attr( $effect );
                $attributes['data-animateonce'] = esc_attr( $animate_once );
                
                $attributes['data-delay'] = esc_attr( $delay_timer );
                
                if( !empty( $animation_duration ) ) {
                    $attributes['data-animation-duration'] = esc_attr( $animation_duration );    
                }
                
                $classes_2[]  = 'ut-animate-element';
                $classes_2[]  = 'animated';
                
                if( $animate_tablet ) {
                    $classes_2[]  = 'ut-no-animation-tablet';
                }
                
                if( $animate_mobile ) {
                    $classes_2[]  = 'ut-no-animation-mobile';
                }
                
                if( $animate_once == 'infinite' ) {
                    $classes_2[]  = 'infinite';
                }                
                
            }
            
            
            /* icon setting */
            if( !empty( $imageicon ) && is_numeric( $imageicon ) ) {
                $imageicon = wp_get_attachment_url( $imageicon );        
            }            
            
            /* overwrite default icon */
            $icon = empty( $imageicon ) ? $icon : $imageicon;
            
            /* check if icon is an image */
            $image_icon = strpos( $icon, '.png' ) !== false || strpos( $icon, '.jpg' ) !== false || strpos( $icon, '.gif' ) !== false || strpos( $icon, '.ico' ) !== false ? true : false;
            
            /* font awesome icon */
            if( !$image_icon ) {
                
                /* fallback */
                $icon = str_replace('fa fa-', 'fa-', $icon );                
                
            }            
            
            /* inline css */
            $id = uniqid("ut_scv_");
            
            $css_style = '<style type="text/css" scoped>';
                
                /* fallback colors */
                if( $shape == 'round' && empty( $background ) && !$image_icon ) {
                    $color      = '#FFF';
                    $background = get_option('ut_accentcolor' , '#F1C40F');
                }
                    
                $css_style .= '#' . $id . ' .ut-service-icon .fa.fa-stack-1x { color: ' . $color . '; }';
                
                if( $background ) {
                    $css_style .= '#' . $id . ' .ut-service-icon .fa.fa-stack-2x { color: ' . $background . '; }';
                }                    
                
                if( $headline_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column.ut-vertical h3 { color: ' . $headline_color . '; }';  
                }
                
                if( $text_color ) {
                    $css_style .= '#' . $id . ' .ut-service-column.ut-vertical p { color: ' . $text_color . '; }';     
                }                
            
            $css_style .= '</style>';            
            
            /* attributes string */
            $attributes = implode(' ', array_map(
                function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
                $attributes,
                array_keys( $attributes )
            ) );
            
            /* start output */
            $output = '';
            
            /* add css */ 
            $output .= ut_minify_inline_css( $css_style );
            
            $output .= '<div id="' . $id . '" class="' . implode(' ', $classes ) . ' ut-vertical-style" ' . $margin_bottom . '>';
                
                if(!empty($icon) && $shape == 'round' && !$image_icon ) {
                
                    $output .= '<figure ' . $attributes . ' class="ut-service-icon fa-stack fa-lg ' . implode(' ', $classes_2 ) . '" style="line-height:60px;">';
                        
                        $output .= '<i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-stack-1x ' . $icon . '"></i>';
                        
                    $output .= '</figure>';
                
                } elseif( !empty($icon) ) {
                                        
                        if( $image_icon ) {
                            
                            $output .= '<figure ' . $attributes . ' class="ut-service-icon ut-custom-icon ' . implode(' ', $classes_2 ) . '" style="text-align:center;">';                        
                            $output .= '<img alt="' . ( !empty($headline) ? $headline : 'icon' ) . '" src="' . esc_url( $icon ) . '">';                        
                            
                        } else { 
                            
                            $output .= '<figure ' . $attributes . ' class="ut-service-icon ' . implode(' ', $classes_2 ) . '" style="text-align:center;">';
                            $output .= '<i style="color: ' . $color . '" class="fa ' . $icon . '"></i>';
                            
                        } 
                        
                    $output .= '</figure>';
                    
                }
                    
                $output .= '<div class="ut-service-column ut-vertical">';
                    
                    if( !empty($headline) ) {
                        $output .= '<h3>' . $headline . '</h3>';
                    }
                    
                    $output .= '<p>' . do_shortcode( $content ) . '</p>';
                    
                $output .= '</div>';
                
           $output .= '</div>';
           
           if( defined( 'WPB_VC_VERSION' ) ) { 
                
                return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $output . '</div>'; 
            
            }
           
           return $output;
        
        }
            
    }

}

new UT_Service_Column_Vertical;