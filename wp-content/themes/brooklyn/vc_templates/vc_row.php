<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
    'vc_row',
    'wpb_row', //deprecated
    'vc_row-fluid',
    $el_class,
    vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
    if ( vc_is_page_editable() ) {
        $css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
    } else {
        return '';
    }
}

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
    $css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
    $css_classes[] = 'vc_column-gap-'.$atts['gap'];
}



$animation_attributes = array();

/* fill animation classes */
if( !empty( $effect ) && $effect != 'none' ) {
    
    $css_classes[] = 'ut-animate-element';
    $css_classes[] = 'animated';             
                
    if( $animate_tablet ) {
        $css_classes[]  = 'ut-no-animation-tablet';
    }
    
    if( $animate_mobile ) {
        $css_classes[]  = 'ut-no-animation-mobile';
    }
    
    if( $animate_once == 'infinite' ) {
        $css_classes[]  = 'infinite';
    }
    
    $animation_attributes['data-effect'] = esc_attr( $effect );
    $animation_attributes['data-animateonce'] = esc_attr( $animate_once );
    
    $delay_timer = !empty( $delay_timer ) ? $delay_timer : 200;
    $animation_attributes['data-delay'] = esc_attr( $delay_timer );
    
    $animation_duration = !empty( $animation_duration ) ? $animation_duration : '1s';
    $animation_attributes['data-animation-duration'] = esc_attr( $animation_duration );    
    
}

/* attributes string */
$animation_attributes = implode(' ', array_map(
    function ($v, $k) { return sprintf("%s=\"%s\"", $k, $v); },
    $animation_attributes,
    array_keys( $animation_attributes )
) );

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
    $wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}


$needs_side_nav_spacing = false;

if ( ! empty( $full_width ) ) {
    
    $wrapper_attributes[] = 'data-vc-full-width="true"';
    $wrapper_attributes[] = 'data-vc-full-width-init="false"';
    
    if ( 'stretch_row_content' === $full_width ) {
        
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        
        $needs_side_nav_spacing = true;
        
    } elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
        
        $wrapper_attributes[] = 'data-vc-stretch-content="true"';
        $css_classes[] = 'vc_row-no-padding';
        
        $needs_side_nav_spacing = true;
        
    }
    
    $after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
    
}

if ( ! empty( $full_height ) ) {
    
    $css_classes[] = 'vc_row-o-full-height';
    
    if ( ! empty( $columns_placement ) ) {
        
        $flex_row = true;
        $css_classes[] = 'vc_row-o-columns-' . $columns_placement;
    
        if ( 'stretch' === $columns_placement ) {
            $css_classes[] = 'vc_row-o-equal-height';
        }
        
    }
    
}

if ( ! empty( $equal_height ) ) {
    $flex_row = true;
    $css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
    $flex_row = true;
    $css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
    $css_classes[] = 'vc_row-flex';
}

/**
 * Overlay Settings
 */

$overlay_style_id = uniqid("ut_row_overlay_");
$row_custom_class = uniqid("ut_row_");

$custom_css_style = '<style type="text/css" scoped>';
    
if( $bklyn_overlay_color ) {
    
    if ( preg_match( '/^#[a-f0-9]{6}$/i', $bklyn_overlay_color ) ) {
        $bklyn_overlay_color = 'rgba(' .  ut_hex_to_rgb( $bklyn_overlay_color )  . ', 0.8 );';
    }
            
    $custom_css_style .= '#' . $overlay_style_id . '{ background-color: ' . $bklyn_overlay_color . ';}';
    
    /* add parent css class */
    $css_classes[] = 'bklyn-row-with-overlay';
    
    
}
 
/**
 * Row Background
 */
     
if( !$parallax ) {
    
    if( $background_position ) {
        
        $custom_css_style .= '.' . $row_custom_class . '{ background-position: ' . $background_position . ';}';        
        
        /* remove vc background position */
        $atts['css'] = preg_replace("/background-position:/", "", $atts['css']); 
        
        if( unite_mobile_detection()->isMobile() && $hide_bg_mobile ) {
            $atts['css'] = preg_replace("/background-image:/", "", $atts['css']); 
        }
        
        if( unite_mobile_detection()->isTablet() && $hide_bg_tablet ) {
            $atts['css'] = preg_replace("/background-image:/", "", $atts['css']); 
        }
        
        /* search for vc custom css */            
        $vc_custom_css_id = ut_search_array_key('vc_custom_', $css_classes);
        
        /* replace vc css class */
        $atts['css'] = str_replace( $css_classes[$vc_custom_css_id], $row_custom_class, $atts['css']);
        
        unset( $css_classes[$vc_custom_css_id] );
        
        /* add remaining VC CSS */
        $custom_css_style .= $atts['css'];
        
    }
        
    if( $background_attachment ) {
    
        $custom_css_style .= '.' . $row_custom_class . '{ background-attachment: ' . $background_attachment . ';}'; 
    
    }

}          

$css_classes[] = $row_custom_class;
    
$custom_css_style .= '</style>';

if( $hide_bg_tablet ) {
    $css_classes[] = 'hide-bg-on-tablet';
}        
    
if( $hide_bg_mobile ) {
    $css_classes[] = 'hide-bg-on-mobile';
} 

if( $hide_bg_medium ) {
    $css_classes[] = 'hide-bg-on-medium';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
    $parallax = $video_bg_parallax;
    $parallax_speed = $parallax_speed_video;
    $parallax_image = $video_bg_url;
    $css_classes[] = 'vc_video-bg-container';
    wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
    wp_enqueue_script( 'vc_jquery_skrollr_js' );
    $wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
    $css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
    if ( false !== strpos( $parallax, 'fade' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fade';
        $wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
    } elseif ( false !== strpos( $parallax, 'fixed' ) ) {
        $css_classes[] = 'js-vc_parallax-o-fixed';
    }
}

if ( ! empty( $parallax_image ) ) {
    if ( $has_video_bg ) {
        $parallax_image_src = $parallax_image;
    } else {
        $parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
        $parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
        if ( ! empty( $parallax_image_src[0] ) ) {
            $parallax_image_src = $parallax_image_src[0];
        }
    }
    $wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
    $wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
$wrapper_attributes[] = $animation_attributes;

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';

if( $bklyn_section_anchor && !empty( $bklyn_section_anchor_id ) ) {
    
    $output .= '<a class="ut-vc-offset-anchor-top" id="section-' . ut_create_slug( $bklyn_section_anchor_id ) .'" name="section-' . ut_create_slug( $bklyn_section_anchor_id ) .'">' . $bklyn_section_anchor_id .'</a>';    
    
}

if( function_exists('ot_get_option') && ot_get_option( 'ut_header_layout', 'default' ) == 'side' && $needs_side_nav_spacing && 'stretch' != $columns_placement ) {
    $output .= '<div class="vc-sidenav-column-container-wrap">';
}
    
    $output .= wpb_js_remove_wpautop( $content );
    
if( function_exists('ut_return_header_config') && ut_return_header_config( 'ut_header_layout', 'default' ) == 'side' && $needs_side_nav_spacing && 'stretch' != $columns_placement ) {
    $output .= '</div>';
}    

if( $bklyn_overlay ) {
        
        $output .= '<div id="' . $overlay_style_id . '" class="bklyn-overlay ' . ( $bklyn_overlay_pattern ? $bklyn_overlay_pattern_style : '' ) . '"></div>';
        
    }

$output .= $custom_css_style;

if( $bklyn_section_anchor && !empty( $bklyn_section_anchor_id ) ) {
    
    $output .= '<a class="ut-vc-offset-anchor-bottom" id="section-' . ut_create_slug( $bklyn_section_anchor_id ) .'" name="section-' . ut_create_slug( $bklyn_section_anchor_id ) .'">' . $bklyn_section_anchor_id .'</a>';    
    
}

$output .= '</div>';
$output .= $after_output;

echo $output;