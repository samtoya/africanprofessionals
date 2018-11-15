<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'UT_Team_Member' ) ) {
	
    class UT_Team_Member {
        
        private $shortcode;
        private $link;
        private $social;
        private $social_border;
        private $output;
        private $name;
        private $occupation;
        private $content;
             
        function __construct() {
			
            /* shortcode base */
            $this->shortcode = 'ut_team_member';
            
            add_action( 'init', array( $this, 'ut_map_shortcode' ) );
            add_shortcode( $this->shortcode, array( $this, 'ut_create_shortcode' ) );	
            
		}
        
        function ut_map_shortcode( $atts, $content = NULL ) {
            
            if( function_exists( 'vc_map' ) ) {
                                
                vc_map(
                    array(
                        'name'            => esc_html__( 'Team Member', 'ut_shortcodes' ),
                        'icon'            => UT_SHORTCODES_URL . '/admin/img/vc_icons/team-member.png',
                        'base'            => $this->shortcode,
                        'category'        => 'Brooklyn ( 4.0 )',
                        'content_element' => true,
                        'params'          => array(
                            
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__( 'Name', 'ut_shortcodes' ),
                                'param_name'    => 'name',
                                'admin_label'   => true,
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'attach_image',
                                'heading'       => esc_html__( 'Avatar', 'ut_shortcodes' ),
                                'param_name'    => 'avatar',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'textfield',
                                'heading'       => esc_html__( 'Occupation', 'ut_shortcodes' ),
                                'param_name'    => 'occupation',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'textarea',
                                'heading'       => esc_html__( 'Description', 'ut_shortcodes' ),
                                'param_name'    => 'content',
                                'group'         => 'General'
                            ),
                            array(
                                'type'          => 'param_group',
                                'heading'       => esc_html__( 'Social Profiles', 'ut_shortcodes' ),
                                'group'         => 'General',
                                'param_name'    => 'social',
                                'params' => array(
                                    array(
                                        'type'          => 'iconpicker',
                                        'heading'       => esc_html__( 'Icon', 'ut_shortcodes' ),
                                        'param_name'    => 'icon'                                        
                                    ),
                                    array(
                                        'type'          => 'textfield',
                                        'heading'       => esc_html__( 'Title', 'ut_shortcodes' ),
                                        'admin_label'   => true,
                                        'param_name'    => 'title',
                                    ),
                                    array(
                                        'type'          => 'vc_link',
                                        'heading'       => esc_html__( 'Profile Link', 'ut_shortcodes' ),
                                        'param_name'    => 'link',
                                    ),
                                    
                                ),

                            ),
                            array(
                                'type'              => 'vc_link',
                                'heading'           => esc_html__( 'Link', 'ut_shortcodes' ),
                                'param_name'        => 'link',
                                'group'             => 'General'
                            ),                             
                            /* box design */
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Box Style', 'ut_shortcodes' ),
								'param_name'        => 'style',
								'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'Member Style One'  , 'ut_shortcodes' ) => 'member-style-1',
                                    esc_html__( 'Member Style Two'  , 'ut_shortcodes' ) => 'member-style-2',
                                    esc_html__( 'Member Style Three', 'ut_shortcodes' ) => 'member-style-3',
                                    esc_html__( 'Member Style Four' , 'ut_shortcodes' ) => 'member-style-4',
                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Alignment', 'ut_shortcodes' ),
								'param_name'        => 'align',
                                'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'center', 'ut_shortcodes' ) => 'center',
                                    esc_html__( 'left'  , 'ut_shortcodes' ) => 'left',
                                    esc_html__( 'right' , 'ut_shortcodes' ) => 'right',
                                ),
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1' ),
                                ),
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Name Color', 'ut_shortcodes' ),
								'param_name'        => 'name_color',
                                'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Occupation Color', 'ut_shortcodes' ),
								'param_name'        => 'ocupation_color',
                                'edit_field_class'  => 'vc_col-sm-6',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Ocupation Font Weight', 'ut_shortcodes' ),
								'param_name'        => 'ocupation_font_weight',
                                'group'             => 'Box Design',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'value'             => array(
                                    esc_html__( 'bold'  , 'ut_shortcodes' ) => 'bold',
                                    esc_html__( 'normal', 'ut_shortcodes' ) => 'normal',
                                ),
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Description Color', 'ut_shortcodes' ),
								'param_name'        => 'description_color',
								'group'             => 'Box Design',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1', 'member-style-2' ),
                                ),
                                
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Social Icon Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_color',
                                'edit_field_class'  => 'vc_col-sm-6',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Social Icon Hover Color', 'ut_shortcodes' ),
								'param_name'        => 'icon_color_hover',
                                'edit_field_class'  => 'vc_col-sm-6',
								'group'             => 'Box Design'
						  	),
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Overlay Color', 'ut_shortcodes' ),
								'param_name'        => 'overlay_color',
								'group'             => 'Box Design',
                                'edit_field_class'  => 'vc_col-sm-6',
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-3','member-style-4' ),
                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Decoration Line', 'ut_shortcodes' ),
								'param_name'        => 'line',
                                'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'on' , 'ut_shortcodes' ) => 'on',
                                    esc_html__( 'off', 'ut_shortcodes' ) => 'off',
                                ),
                                'dependency' => array(
                                    'element' => 'style',
                                    'value'   => array( 'member-style-1', 'member-style-2' ),
                                ),
						  	),                          
                            array(
								'type'              => 'colorpicker',
								'heading'           => esc_html__( 'Decoration Line Color', 'ut_shortcodes' ),
								'param_name'        => 'line_color',
								'group'             => 'Box Design',
                                'dependency' => array(
                                    'element' => 'line',
                                    'value'   => array( 'on' ),
                                ),
						  	),
                            array(
								'type'              => 'range_slider',
								'heading'           => esc_html__( 'Decoration Line Width', 'ut_shortcodes' ),
								'param_name'        => 'line_width',
								'group'             => 'Box Design',
                                'value'             => array(
                                    'default'   => '2',
                                    'min'       => '1',
                                    'max'       => '10',
                                    'step'      => '1',
                                    'unit'      => 'px'
                                ),
                                'dependency' => array(
                                    'element' => 'line',
                                    'value'   => array( 'on' ),
                                ),
						  	),
                            array(
								'type'              => 'dropdown',
								'heading'           => esc_html__( 'Decoration Line Style', 'ut_shortcodes' ),
								'param_name'        => 'line_style',
								'group'             => 'Box Design',
                                'value'             => array(
                                    esc_html__( 'solid' , 'ut_shortcodes' ) => 'solid',
                                    esc_html__( 'dotted', 'ut_shortcodes' ) => 'dotted',
                                    esc_html__( 'dashed', 'ut_shortcodes' ) => 'dashed',
                                    esc_html__( 'double', 'ut_shortcodes' ) => 'double',
                                    esc_html__( 'groove', 'ut_shortcodes' ) => 'groove',
                                    esc_html__( 'ridge' , 'ut_shortcodes' ) => 'ridge',
                                    esc_html__( 'inset' , 'ut_shortcodes' ) => 'inset',
                                    esc_html__( 'outset', 'ut_shortcodes' ) => 'outset',
                                ),
                                'dependency' => array(
                                    'element' => 'line',
                                    'value'   => array( 'on' ),
                                ),
						  	),
                            /* css */
                            array(
                                'type'              => 'css_editor',
                                'param_name'        => 'css',
                                'group'             => esc_html__( 'Design Options', 'ut_shortcodes' ),
                            )                                                        
                            
                        )                        
                        
                    )
                
                ); /* end mapping */
                
            } 
        
        }
        
        function create_member_box_style_one() {
            
            $this->output .= '<div class="bklyn-team-member-info">';
                    
                if( $this->name ) {        
                    
                    $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                    
                }
                
                if( $this->occupation ) {
                    
                    $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                    
                }
                
                if( $this->content ) {
                    
                    $this->output .= '<p class="bklyn-team-member-description">' . $this->content . '</p>';
                    
                }
                
            $this->output .= '</div>';
            
            $this->create_social_link();
               
        }
        
        
        function create_member_box_style_two() {
            
            $this->output .= '<div class="bklyn-team-member-info">';
                    
                if( $this->name ) {        
                    $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                }
                
                if( $this->occupation ) {
                    $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                }
                
                if( $this->content ) {
                    $this->output .= '<p class="bklyn-team-member-description">' . $this->content . '</p>';
                }
                
            $this->output .= '</div>';
            
            $this->create_social_link();
               
        }
        
        function create_member_box_style_three() {
            
            $this->output .= '<div class="bklyn-team-member-overlay">';
                
                $this->output .= '<div class="bklyn-team-member-overlay-caption">';
                    
                    $this->output .= '<div class="bklyn-team-member-info">';
                    
                        if( $this->name ) {        
                            $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                        }
                        
                        if( $this->occupation ) {
                            $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                        }
                        
                        $this->create_social_link();
                            
                    $this->output .= '</div>';
            
                $this->output .= '</div>';
                
            $this->output .= '</div>';                
               
        }
        
        function create_member_box_style_four() {
            
             $this->output .= '<div class="bklyn-team-member-overlay">';
                
                $this->output .= '<div class="bklyn-team-member-overlay-caption">';
                    
                    $this->output .= '<div class="bklyn-team-member-info">';
                    
                        if( $this->name ) {        
                            $this->output .= '<h3 class="bklyn-team-member-name">' . $this->name . '</h3>';
                        }
                        
                        if( $this->occupation ) {
                            $this->output .= '<p class="bklyn-team-member-ocupation">' . $this->occupation . '</p>';
                        }
                        
                        $this->create_social_link();
                            
                    $this->output .= '</div>';
            
                $this->output .= '</div>';
                
            $this->output .= '</div>';           
               
        }
        
        
        function create_social_link() {
            
            if( !empty( $this->social ) && is_array( $this->social ) ) {
                    
                $this->output .= '<div class="bklyn-team-member-social-icons ' . $this->social_border . '">';
                    
                    $this->output .= '<ul>';
                        
                        foreach( $this->social as $profile ) {
                            
                            if( !empty( $profile['link'] ) ) {
                            
                                /* link settings */
                                $link = vc_build_link( $profile['link'] );
                                
                                $url    = !empty( $link['url'] )    ? $link['url'] : '#';
                                $target = !empty( $link['target'] ) ? $link['target'] : '_self';
                                $title  = !empty( $link['title'] )  ? $link['title'] : '';
                                $rel    = !empty( $link['rel'] )    ? 'rel="' . esc_attr( trim( $link['rel'] ) ) . '"' : '';
                                
                                /* profile icon */
                                $icon   = !empty( $profile['icon'] )?  $profile['icon'] : 'fa fa-circle';
                                       
                                $this->output .= '<li>';
                                    $this->output .= '<a title="' . esc_attr( $title ) . '" href="' . esc_url( $url ) . '" target="' . esc_attr( $target ) . '" ' . $rel . '><i class="' . esc_attr( $icon ) . '"></i></a>';
                                $this->output .= '</li>';
                            
                            }
                        
                        }
                        
                    $this->output .= '</ul>';
                
                $this->output .= '</div>';
            
            }
        
        }        
        
        
        function ut_create_shortcode( $atts, $content = NULL ) {
            
            extract( shortcode_atts( array (
                'style'                 => 'member-style-1',
                'align'                 => 'center',
                'avatar'                => '',
                'name'                  => '',
                'link'                  => '',
                'name_color'            => '',
                'line'                  => 'on',
                'line_color'            => '',
                'line_style'            => '',
                'line_width'            => '',
                'occupation'            => '',
                'ocupation_color'       => '',
                'ocupation_font_weight' => '',
                'description_color'     => '',
                'social'                => '',
                'icon_color'            => '',
                'icon_color_hover'      => get_option('ut_accentcolor'),
                'overlay_color'         => '',
                'css'                   => ''
            ), $atts ) ); 
            
            $this->name          = $name;
            $this->occupation    = $occupation;
            $this->content       = $content;
            $this->social_border = $line == 'off' ? 'no-bklyn-team-member-border' : '';            
                        
            /* extract social items */
            if( function_exists('vc_param_group_parse_atts') && !empty( $social ) ) {
                
                $this->social = array_filter( vc_param_group_parse_atts( $social ) );
                            
            }            
            
            /* avatar */
            $image_meta = get_post( $avatar );
            $alt        = '';
            
            if( get_post( $avatar ) ) {
                $alt = $image_meta->post_title;
            }
            
            if( $style == 'member-style-2' ) {
            
                $avatar = ut_resize( wp_get_attachment_url( $avatar ) , '280', '280', true, true, true );
                
            } else {
            
                $avatar = ut_resize( wp_get_attachment_url( $avatar ) , '800', '600', true, true, true );
            
            }            
                        
            /* fallback */
            if( empty( $avatar ) ) {
                
                $avatar = vc_asset_url( 'vc/no_image.png' );
                
            }
            
            /* link */
            $member_link = false;
            
            if( function_exists('vc_build_link') && $link ) {
                
                $member_link = vc_build_link( $link );
                
            } 
                        
            $target = !empty( $member_link['target'] ) ? $member_link['target'] : '_self';
            $title  = !empty( $member_link['title'] )  ? $member_link['title'] : '';
            $rel    = !empty( $member_link['rel'] )    ? 'rel="' . esc_attr( trim( $member_link['rel'] ) ) . '"' : '';
            $link   = !empty( $member_link['url'] )    ? $member_link['url'] : '#';

            /* unique listz ID */
            $id = uniqid("ut_tm_");
            
            $css_style = '<style type="text/css" scoped>';
                
                if( $name_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-name { color: ' . $name_color . '; }'; 
                }
                
                if( $line == 'on' ) {
                
                    if( $line_color ) {
                        $css_style .= '#' . $id . ' .bklyn-team-member-social-icons { border-color: ' . $line_color . '; }'; 
                    }
                    
                    if( $line_style ) {
                        $css_style .= '#' . $id . ' .bklyn-team-member-social-icons { border-top-style: ' . $line_style . '; }'; 
                    }
                    
                    if( $line_width ) {
                        $css_style .= '#' . $id . ' .bklyn-team-member-social-icons { border-width: ' . $line_width . 'px; }'; 
                    }
                
                }
                
                if( $ocupation_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-ocupation { color: ' . $ocupation_color . '; }'; 
                }
                
                if( $ocupation_font_weight ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-ocupation { font-weight: ' . $ocupation_font_weight . '; }'; 
                }
                
                if( $description_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-description { color: ' . $description_color . '; }'; 
                }
                
                if( $icon_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a { color: ' . $icon_color . '; }';
                    $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:visited { color: ' . $icon_color . '; }';  
                }
                
                $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:hover { color: ' . $icon_color_hover . '; }';
                $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:focus { color: ' . $icon_color_hover . '; }'; 
                $css_style .= '#' . $id . ' .bklyn-team-member-social-icons a:active { color: ' . $icon_color_hover . '; }';  
                
                
                if( $overlay_color ) {
                    $css_style .= '#' . $id . ' .bklyn-team-member-overlay { background: ' . $overlay_color . '; }'; 
                }
                
            $css_style.= '</style>';
            
            /* start output */
            $this->output = '';
            
            $this->output .= ut_minify_inline_css( $css_style );
            
            $this->output .= '<div id="' . esc_attr( $id ) . '" class="bklyn-team-member bklyn-team-' . esc_attr( $style ) . ' bklyn-team-member-' . $align . '">';
                
                if( !empty( $avatar ) ) {
                    
                    if( $member_link ) {
                        
                        $this->output .= '<a title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '" ' . $rel . '>';
                        
                    }
                    
                    $this->output .= '<div class="bklyn-team-member-avatar">';
                        
                        $this->output .= '<img alt="' . esc_attr( $alt ) . '" src="' . esc_url( $avatar ) .  '">';
                        
                    $this->output .= '</div>';
                    
                    if( $member_link ) {
                        
                        $this->output .= '</a>';
                        
                    }
                
                }  
                
                if( $style == 'member-style-1' ) {
                    $this->create_member_box_style_one();    
                }
                
                if( $style == 'member-style-2' ) {
                    $this->create_member_box_style_two();
                }
                
                if( $style == 'member-style-3' ) {
                    $this->create_member_box_style_three();
                }
                
                if( $style == 'member-style-4' ) {
                    $this->create_member_box_style_four();
                }
                
            $this->output .= '</div>';
            
            return '<div class="wpb_content_element ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->shortcode, $atts ) . '">' . $this->output . '</div>';
        
        }
            
    }

}

new UT_Team_Member;