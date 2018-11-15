/* <![CDATA[ */
;(function($){

	$.fn.supposition = function(){
		var $w = $(window), /*do this once instead of every onBeforeShow call*/
			_offset = function(dir) {
				return window[dir == 'y' ? 'pageYOffset' : 'pageXOffset']
				|| document.documentElement && document.documentElement[dir=='y' ? 'scrollTop' : 'scrollLeft']
			    || document.body[dir=='y' ? 'scrollTop' : 'scrollLeft'];
			},
			onInit = function(){
				/* I haven't touched this bit - needs work as there are still z-index issues */
				$topNav = $('li',this);
				var cZ=parseInt($topNav.css('z-index')) + $topNav.length;
				$topNav.each(function() {
					$(this).css({zIndex:--cZ});
				});
			},
			onHide = function(){
				this.css({marginTop:'',marginLeft:''});
			},
			onBeforeShow = function(){
				this.each(function(){
					
                    var $u = $(this);
                    
					$u.css('display','block');
					
                    var menuWidth = $u.width(),
						parentWidth = $u.parents('ul').width(),
						totalRight = $w.width() + _offset('x'),
						menuRight = $u.offset().left + menuWidth;
					if (menuRight > totalRight) {
						
                        $u.css('margin-left', ( $u.parents('ul').length === 1 ? totalRight - menuRight : -(menuWidth + parentWidth) ) + 'px');
					}

					var windowHeight = $w.height(),
						offsetTop = $u.offset().top,
						menuHeight = $u.height(),
						baseline = windowHeight + _offset('y');
					var expandUp = (offsetTop + menuHeight > baseline);
					
                    if (expandUp) {
						
                        $u.css('margin-top',baseline - (menuHeight + offsetTop));
                        
					}
                    
					//$u.css('display','none');
                    
				});
			};
		
		return this.each(function() {
			var $this = $(this),
				o = $this.data('sf-options'); /* get this menu's options */
			
			/* if callbacks already set, store them */
			var _onInit = o.onInit,
				_onBeforeShow = o.onBeforeShow,
				_onHide = o.onHide;
				
			$.extend($this.data('sf-options'),{
				onInit: function() {
					onInit.call(this); /* fire our Supposition callback */
					_onInit.call(this); /* fire stored callbacks */
				},
				onBeforeShow: function() {
					onBeforeShow.call(this); /* fire our Supposition callback */
					_onBeforeShow.call(this); /* fire stored callbacks */
				},
				onHide: function() {
					onHide.call(this); /* fire our Supposition callback */
					_onHide.call(this); /* fire stored callbacks */
				}
			});
		});
	};
    
	$.fn.utvmenu = function(option) {
		
        var obj,
			item;
            
		var options = $.extend({
				speed: 200,
				autostart: true,
				autohide: 1
			},
			option);
            
		obj = $(this);
        
		item = obj.find("ul").parent("li").children("a");
		item.attr("data-option", "off");

		item.unbind('click').on("click", function() {
			var a = $(this);
			if (options.autohide) {
				a.parent().parent().find("a[data-option='on']").parent("li").children("ul").slideUp(options.speed / 1.2,
					function() {
						$(this).parent("li").children("a").attr("data-option", "off");
					});
			}
			if (a.attr("data-option") === "off") {
				a.parent("li").children("ul").slideDown(options.speed,
					function() {
						a.attr("data-option", "on");
					});
			}
			if (a.attr("data-option") === "on") {
				a.attr("data-option", "off");
				a.parent("li").children("ul").slideUp(options.speed);
			}
		});
		if (options.autostart) {
			obj.find("a").each(function() {

				$(this).parent("li").parent("ul").slideDown(options.speed,
					function() {
						$(this).parent("li").children("a").attr("data-option", "on");
					});
			});
		}

	};

})(jQuery);

;(function($){
	
	"use strict";
	
    $(document).ready(function(){

        function getHashValue( key ) {
            var matches = location.hash.match(new RegExp(key+'=([^&]*)'));
            return matches ? matches[1] : null;
        }
        
        $("html").addClass('js');
        
        /* Top Header - Header Animation
		================================================== */
        
        /* store header size */        
        var ut_top_header_height = $('#ut-top-header').outerHeight();
        
        function create_placeholder() {
            
            if( !$('#ut-top-header-placeholder').length ) {
            
                $('<div/>', {
                    id: 'ut-top-header-placeholder',
                }).css({
                    'width' : '100%', 'height' :  ut_top_header_height + 'px', 'position' : 'fixed', 'top' : '0px' , 'z-index' : 10
                }).insertBefore( $('#header-section') );
            
            }
            
        }
        
        function remove_placeholder() {
            
            $('#ut-top-header-placeholder').remove();
        
        }
                
        function ut_get_current_scroll() {
            
            return window.pageYOffset || document.documentElement.scrollTop;
            
        }
        
        function ut_animate_top_header() {
           
            var scroll = ut_get_current_scroll();
                                 
            if( $('body').hasClass('ut-has-top-header') ) {
                  
                if ( scroll >= 1 ) {
                    
                    $('#header-section').removeClass('bordered-top');
                    create_placeholder();
                       
                } else {
                    
                    $('#header-section').not('.ha-header-hide').addClass('bordered-top');                    
                    remove_placeholder();
                    
                }
            
            }
        
        }
        
        $(window).scroll(function() {            
            ut_animate_top_header();                
        });
        
        /* execute on load */
        ut_animate_top_header();
     
        
		/* Lazy Load
		================================================== */
        var $imgs = $("img.utlazy");
    
        $imgs.lazyload({
            effect: 'fadeIn',
            effectspeed: '200',
            event : 'scroll',
			load : function() {
                $(this).show();	
                $.waypoints("refresh");
			},
            failure_limit: Math.max($imgs.length - 1, 0)
        });
		
        
		/* Main Navigation & Mobile Navigation Classes
		================================================== */
		$('#navigation ul.menu').find(".current-menu-ancestor").each(function() { 
            
            $(this).find("a").first().addClass("active"); 
        
        }).end().find(".current_page_parent").each(function() { 
                
            $(this).find("a").first().addClass("active"); 
            
        }).end().superfish({autoArrows : true}).supposition();
                
        $('#ut-mobile-menu').find(".current-menu-ancestor").each(function() { 
            
            $(this).find("a").first().addClass("active"); 
        
        }).end().find(".current_page_parent").each(function() { 
        
            $(this).find("a").first().addClass("active"); 
        
        });

		$('#ut-mobile-menu .sub-menu li:last-child').addClass('last');
    	$('#ut-mobile-menu li:last-child').addClass('last');
        
        /* Mobile Navigation
		================================================== */
		function mobile_menu_dimensions() {
			
			var nav_new_width	= $(window).width(),
				nav_new_height  = $(window).outerHeight();
			
			$("#ut-mobile-nav").width( nav_new_width - 20 ).height( nav_new_height );
            
			$(".ut-scroll-pane-wrap").width( nav_new_width -20 ).height( nav_new_height );
            $(".ut-scroll-pane").width( nav_new_width + 20 ).height( nav_new_height );
		
		}
		
		function mobilemenu(){
                
			 if (($(window).width() > 979)) {
				
                $("#ut-mobile-nav").hide(); 
                $('body').removeClass("ut-mobile-menu-open");
                
			 }
			
		}
        
        var mobile_nav_open = false,
            is_animating    = false;
        
		$(".ut-mm-trigger").click(function(event){
		    
            if( is_animating ) {
                return false;
            }
            
            is_animating = true;
            	
            if( !mobile_nav_open ) {
                
                $('body').addClass("ut-mobile-menu-open");                       
            
            }
            
			$(this).toggleClass("active").next().slideToggle(400, function() {
                
                if( !mobile_nav_open ) {
                    
                    mobile_nav_open = true;    
                
                } else {
                    
                    $('body').removeClass("ut-mobile-menu-open");
                    mobile_nav_open = false;
                
                }            
                
                is_animating = false;
                    
            });
            
            mobile_menu_dimensions();
                        
			event.preventDefault();
			
		});		
				
		var mobiletimer;
		
		$(window).utresize(function(){
		  
		  clearTimeout(mobiletimer);
		  mobiletimer = setTimeout(mobilemenu, 100);
		  mobile_menu_dimensions();
          
		});
        
        
        $('.ut-scroll-pane').on('touchstart', function(){
            
            // nothing to do here 
        
        });
        
		/* Tablet Slider
		================================================== */
		$(".ut-tablet-nav li a").click( function(event) {
			
			var index = $(this).parent().index();
						
			/* remove selected state from previuos tabs link */
			$(".ut-tablet-nav li").removeClass("selected");
			
			/* add class selected to current link */
			$(this).parent().addClass("selected");
			
			/* hide all tabs images */
			$(".ut-tablet").children().hide().removeClass("show");		
			
			/* show the selected tab image */
			$(".ut-tablet").children().eq(index).fadeIn("fast").addClass("show");
			
			event.preventDefault();
		
		});
		
        /* Adjust Offset Anchor
		================================================== */        
        var brooklyn_scroll_offset = $('#header-section').outerHeight();
        
        if( $('#header-section').hasClass('ut-header-has-border') ) {
            brooklyn_scroll_offset--;
        }
        
        /* Scroll to Top
		================================================== */
		var ut_scrolleffect = $('body').data("scrolleffect"),
			ut_scrollspeed	= $('body').data("scrollspeed");
		
		$('.logo a[href*="#"]').click( function(event) { 
				
			event.preventDefault();			
			$.scrollTo( $(this).attr('href') , ut_scrollspeed, { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );			
			
		});
		
		$('.toTop').click( function(event) { 
				
			event.preventDefault();			
			$.scrollTo( $(this).attr('href') , ut_scrollspeed, { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );			
			
		});
		
		
		/* Scroll to sections for hero buttons
		================================================== */        
        $('.hero-second-btn[href^="#"], .hero-btn[href^="#"], .hero-down-arrow a[href^="#"]').click( function( event ) {
        
            event.preventDefault();
            
            var target = $(this).attr('href');
            
            if( target === '#ut-to-first-section' ) {
			
				$.scrollTo( $('.wrap') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );
			
			} else {
				
				$.scrollTo( target , ut_scrollspeed, {  easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );
				
			}
            
        
        });         
		
		$('.hero-slider-button[href^="#"]').click( function( event ) {
			
            event.preventDefault();
            
            var target = $(this).attr('href');
            
            if( target === '#ut-to-first-section' ) {
			
				$.scrollTo( $('.wrap') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );
			
			} else {
				
                $.scrollTo( $(this).attr('href') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );
				
			}
			
		});
		
        $('.ut-fancy-image-wrap a[href^="#"]').click( function( event ) {
            
            event.preventDefault();
            
            var target = $(this).attr('href');
            
            if( target === '#ut-to-first-section' ) {
			
				$.scrollTo( $('.wrap') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );
			
			} else {
				
                $.scrollTo( $(this).attr('href') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );
				
			}            
                
        });
                
        /* Scroll to Section Class
		================================================== */     
        $(document).on("click" , '.ut-scroll-to-section, .ut-scroll-to-section a' , function(event) {
            
            var href = $(this).attr('href');
            
            if( href === undefined ) {
                return;
            }
             
            /* extract section hash */
            var section = '#' + href.substring( href.indexOf('#')+1 );
                        
            $.scrollTo( section , ut_scrollspeed, {  
                easing: ut_scrolleffect ,
                offset: -brooklyn_scroll_offset,
                'axis':'y'
            });
            
            /* activate navigation */
            if( $('#navigation a[href*="' + section + '"]').length ) {
            
                $('#navigation a').removeClass('selected');
                $('#navigation a[href*="' + section + '"]').addClass('selected');            
            
            }
            
            /* activate navigation */
            if( $('#bklyn-sidenav a[href*="' + section + '"]').length ) {
            
                $('#bklyn-sidenav a').removeClass('selected');
                $('#bklyn-sidenav a[href*="' + section + '"]').addClass('selected');            
            
            }
            
            event.preventDefault();
            
        });
        
		/* Scroll to Section if Hash exists
		================================================== */
		$(window).load(function() {
						
			if( window.location.hash ) {
				
				setTimeout ( function () {
                    
                    if( site_settings.navigation === 'default' ) {
                    
                        $.scrollTo( window.location.hash , ut_scrollspeed , { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , "axis":"y" } );
                        
					} else if( site_settings.navigation === 'side' ) {
                        
                        $.scrollTo( window.location.hash , ut_scrollspeed , { easing: ut_scrolleffect , offset: 0 , "axis":"y" } );
                    
                    }
                    													
				}, 400 );
								
			}
			
		});
				
		/* Scroll to Sections / Main Menu
		================================================== */
		$('#navigation a').click( function(event) { 
						
			if( this.hash && !$(this).hasClass('external') && $(this.hash).length ) {
			
				$.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );			
				event.preventDefault();				
				
			} else if( this.hash && $(this).parent().hasClass('contact-us') ) {
				
				$.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );			
				event.preventDefault();		
				
			}
			
		});
		
        $('.footer ul.menu a').click( function(event) { 
            
            if( this.hash && $(this.hash).length ) {
			
				$.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );			
				event.preventDefault();				
				
			} 
        
        });        
                
        var isIEMobile = isIEMobile();
        
        function isIEMobile() {
            var regExp = new RegExp("IEMobile", "i");
            return navigator.userAgent.match(regExp);
        }
        
        /* Scroll to Sections / Mobile Menu
		================================================== */
		$('#ut-mobile-menu a').click( function(event) { 
			
			if( this.hash && !$(this).hasClass('external') ) {				
                
                if(!isIEMobile){
                                
                    $.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );
                
                } else {
                
                    var thash = this.hash;
                    
                    $('html, body').animate({ scrollTop: $( thash ).offset().top }, ut_scrollspeed );
                
                }
                
				event.preventDefault();	
                			
			}
			
			/* close menu */
			$('#ut-mobile-nav').slideToggle(500);
			
		});
        
        /* Side Navigation
		================================================== */        
        if( $("#bklyn-sidenav").length ) {
            
            $("#bklyn-sidenav").utvmenu({
                speed: 800,
				autostart: false,
				autohide: true
            });
            
            if( site_settings.type === 'onepage' ) {
            
                $('#bklyn-sidenav a').click( function(event) { 
                            
                    if(this.hash && !$(this).hasClass('external') ) {
                    
                        $.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );			
                        event.preventDefault();				
                        
                    } else if( this.hash && $(this).parent().hasClass('contact-us') ) {
                        
                        $.scrollTo( this.hash , ut_scrollspeed, { easing: ut_scrolleffect , offset: 0 , 'axis':'y' } );			
                        event.preventDefault();		
                        
                    }
                    
                });
            
            } else {
            
            
            
            }

        }        
        
        
        var waypoints_active = false;        
        
        $(window).load(function() {
            
            waypoints_active = true;
            
        });
        
            
        $('.ut-vc-offset-anchor-top').each(function() {
            
            $(this).waypoint( function( direction ) {
                
                if( !waypoints_active ) {
                    return;
                }
                    
                var containerID = $(this).attr('id');
                
                if( direction === 'down' ) {
                        
                    $('#navigation a').removeClass('selected');
                    $('#navigation a[href*="#' + containerID + '"]').addClass('selected');
                
                }
                
                if( direction === 'up' ) {
                    
                    $('#navigation a').removeClass('selected');
                
                }                
                
                if( direction === 'up' && $(this).attr('id') === 'to-main-content' ) {
                    
                    if( site_settings.navigation === 'default' ) {
                                        
                        /* update navigation home */
                        $('#navigation a').removeClass('selected');
                        $('.ut-home-link a').addClass('selected');
                    
                    } else if( site_settings.navigation === 'side' ) {
                        
                        /* update navigation home */
                        $('#bklyn-sidenav a').removeClass('selected');
                        $('.ut-home-link a').addClass('selected');
                        
                    }
                                        
                
                }                
                
            }, { offset: brooklyn_scroll_offset + 1 + 'px' });
            
        });
        
        $('.ut-vc-offset-anchor-bottom').each(function() {                
            
            $(this).waypoint( function( direction ) {
                
                if( !waypoints_active ) {
                    return;
                }
                    
                var containerID = $(this).attr('id');
                                
                if( direction === 'down' ) {
                    
                    $('#navigation a').removeClass('selected');
                
                }
                
                if( direction === 'up' ) {
                    
                    $('#navigation a').removeClass('selected');
                    $('#navigation a[href*="#' + containerID + '"]').addClass('selected');
                    
                }
                
            }, { offset: brooklyn_scroll_offset + 10 + 'px' });                    
    
        });                        
        
        
        
        
        
        

        /* reflect scrolling in navigation
        ================================================== */
        $('.ut-offset-anchor').each(function() {
            
            $(this).waypoint( function( direction ) {
                
                if( direction === 'down' && $(this).attr('id') !== 'to-main-content' ) {
                    
                    var containerID = $(this).attr('id');
                                        
                    if( $(this).data('parent') ) {
                        containerID = $(this).data('parent');
                    }
                    
                    if( site_settings.navigation === 'default' ) {
                    
                        /* update navigation */
                        $('#navigation a').removeClass('selected');
                        $('#navigation a[href*="#'+containerID+'"]').addClass('selected');
                    
                    } else if( site_settings.navigation === 'side' ) {
                        
                        /* update navigation */
                        $('#bklyn-sidenav a').removeClass('selected');
                        $('#bklyn-sidenav a[href*="#'+containerID+'"]').addClass('selected');
                    
                    }
                    
                                    
                }
                
                if( direction === 'up' && $(this).attr('id') === 'to-main-content' ) {
                    
                    if( site_settings.navigation === 'default' ) {
                                        
                        /* update navigation home */
                        $('#navigation a').removeClass('selected');
                        $('.ut-home-link a').addClass('selected');
                    
                    } else if( site_settings.navigation === 'side' ) {
                        
                        /* update navigation home */
                        $('#bklyn-sidenav a').removeClass('selected');
                        $('.ut-home-link a').addClass('selected');
                        
                    }
                                        
                
                }
                            
            } , { offset: brooklyn_scroll_offset + 1 + 'px' });
                  
        });
        
        $('.ut-scroll-up-waypoint').each(function() {
            
            $(this).waypoint( function( direction ) {
                
                if( direction === 'up' ) {
                    
                    var containerID = $(this).data('section');
                    
                    if( $(this).data('parent') ) {
                        containerID = $(this).data('parent');
                    }
                    
                    if( site_settings.navigation === 'default' ) {
                    
                        /* update navigation */
                        $('#navigation a').removeClass('selected');
                        $('#navigation a[href*="#'+containerID+'"]').addClass('selected');
                    
                    } else if( site_settings.navigation === 'side' ) {
                        
                        /* update navigation */
                        $('#bklyn-sidenav a').removeClass('selected');
                        $('#bklyn-sidenav a[href*="#'+containerID+'"]').addClass('selected');
                    
                    }
                                    
                }
                            
            } , { offset: brooklyn_scroll_offset + 10 + 'px' });
                  
        });	        
        
        
        		
		/* Youtube WMODE
		================================================== */
		$('iframe').each(function() {
			
			var url = $(this).attr("src");
			
			if ( url!=undefined ) {
				
				var youtube   = url.search("youtube"),			
					splitable = url.split("?");
				
				/* url has already vars */	
				if( youtube > 0 && splitable[1] ) {
					$(this).attr("src",url+"&wmode=transparent")
				}
				
				/* url has no vars */
				if( youtube > 0 && !splitable[1] ) {
					$(this).attr("src",url+"?wmode=transparent")
				}
			
			}
			
		});
		
		/* Member POPUP
		================================================== */
		var current_member = null;
		$('.ut-show-member-details').click( function(event) { 
		
			event.preventDefault();	
			
			/* show overlay */
			$('.ut-overlay').addClass('ut-overlay-show');			
			
			/* execute animation to make member visible */
			$('#member_'+$(this).data('member')).addClass('ut-box-show').animate( {top: "15%" , opacity: 1 } , 1000 , 'easeInOutExpo' , function() {
				
				var offset  = $(this).offset().top,
					id		= $(this).data("id");
					
				/* now append clone to body */
				$(this).clone().attr("id" , id).css({"position" : "absolute" , "top" : offset , "padding-top" : 0}).appendTo("body").addClass("member-clone");
			
				/* store current member ID */
				$(this).removeClass('ut-box-show').css({ "top" : "30%" , "opacity" : "0" });				
								
			});			
					
		});
		
        $(document).on("click" , '.ut-hide-member-details, body' , function(event) {
			
            if ( !$(event.target).is('.member-social, .member-social *, .ut-btn, .member-box a') ) {
            
                if( $('.ut-modal-box.member-clone').length ) {
                    event.preventDefault();
                }
                
                /* execute animation to make member invisible */
                $('.ut-modal-box.member-clone').animate({top: "0%" , opacity: 0 } , 600 , 'easeInOutExpo' ,function() {
                    
                    $(this).remove();
                    
                    /* hide overlay */
                    $('.ut-overlay').removeClass('ut-overlay-show');				
                    
                });
            
            }
			
		});
		
		$(document).on("click" , '.ut-overlay' , function(event) {
            
			event.preventDefault();
			
			/* execute animation to make member invisible */
			$('.ut-modal-box.member-clone').animate({top: "0%" , opacity: 0 } , 600 , 'easeInOutExpo' ,function() {
				
				$(this).remove();
				
				/* hide overlay */
				$('.ut-overlay').removeClass('ut-overlay-show');				
				
			});
			
		});				
		
        if( !$('html').hasClass('no-touchevents') ) {
               
            var touchmoved;
            
            $(document).on('touchend', '.member-photo', function() {
                                    
                var $this = $(this);
                                
                if( touchmoved !== true ){
                    
                    if( $this.hasClass('ut-touch-event') ) {
                        
                        $this.toggleClass('cs-hover');
                    
                    }
                
                }                
            
            }).on('touchmove', function() {
                
                touchmoved = true;
                
            }).on('touchstart', function() {
                
                touchmoved = false;
                
            });
        
        }
        
		/* FitVid
		================================================== */
		$(".ut-video, .entry-content, .ut-post-media").fitVids();
		
		
		/* Split Screen Calculation
		================================================== */
		$(window).load(function() {
			$(".ut-split-screen-poster").each(function() {
				
				var parent_ID = $(this).data("posterparent"),
					newHeight = $("#"+parent_ID).height();
				
				$(this).height(newHeight);			
				
			});
			
		});
		
		$('.ut-btn[href^="#"], .cta-btn a[href^="#"]').click( function( event ) {
			
			$.scrollTo( $(this).attr('href') , ut_scrollspeed, {  easing: ut_scrolleffect , offset: -brooklyn_scroll_offset , 'axis':'y' } );
			event.preventDefault();
			
		});
        
        
        /* Visual Composer
		================================================== */
        if ( $().lightGallery ) {
            
            $('.entry-content').lightGallery({
                selector: '.ut-vc-images-lightbox',
                hash: false
            });            
            
            $(document).ajaxComplete(function() {
                
                /* restart */    
                $('.vc_media_grid').lightGallery({
                    selector: '.ut-vc-ajax-images-lightbox',
                    exThumbImage: 'data-exthumbimage',
                    hash: false
                });
                
            
            });            
            
        }
                
        
        $('.nivoSlider').hover( function() {
            
            var $this = $(this);
            
            $this.find('.nivo-directionNav .nivo-prevNav').html('');
            $this.find('.nivo-directionNav .nivo-nextNav').html('');
            
        });
        
        
        /* Force Re Render of Section with fixed backgrounds
           Chrome flicker issue
		================================================== */        
        if( window.devicePixelRatio > 1 || /chrom(e|ium)/.test(navigator.userAgent.toLowerCase()) ){
            
            $.fn.redraw = function() {
                return this.stop(true,true).hide(0, function() {
                    $(this).show();
                });
            };
                
            $('#main-content section').each(function() {
                
                if ( $(this).css('background-attachment') === 'fixed' ) {
                    
                    $(this).addClass('ut-has-fixed-background');
                      
                }
                
            });        
            
            var $document = $(document);
            
            $document.scroll(function(){
                
                $document.find('.ut-has-fixed-background').redraw();
                
            });
		
        }
        
        
        /* United Themes Share
		================================================== */     
        
        /* Twitter
		================================================== */
        var utsharetwitter = function() {
            window.open( 'http://twitter.com/intent/tweet?text='+$(".page-title").text() +' '+window.location,
            "Twitter",
            "width=650,height=350" );
            return false;
        }
        
        /* Facebook
		================================================== */
        var utsharefacebook = function(){
            window.open( 'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),
            'facebook',
            'width=650,height=350');
            return false;
        }
        
        /* Google Plus
		================================================== */
        var utsharegoogle = function(){
            window.open( 'https://plus.google.com/share?url='+encodeURIComponent(location.href),
            'googleWindow',
            'width=500,height=500');
            return false;
        }
        
        /* Linkedin
		================================================== */
        var utsharelinkedin = function(){
            window.open( 'http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(location.href)+'$title='+$(".page-title").text(),
            'linkedinWindow',
            'width=650,height=450, resizable=1');
            return false;
        }
        
        /* Pinterest
		================================================== */
        var utsharepinterest = function(){
            window.open( 'http://pinterest.com/pin/create/bookmarklet/?media='+ $('.entry-content img').first().attr('src') + '&description='+jQuery('.page-title').text()+' '+encodeURIComponent(location.href),
            'pinterestWindow',
            'width=750,height=430, resizable=1');
            return false;
        }
        
        /* Xing
		================================================== */
        var utsharexing = function(){
            window.open( 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url='+encodeURIComponent(location.href),
            'deliciousWindow',
            'width=550,height=550, resizable=1');
            return false;
        }
        
         /* Button Script
		================================================== */
        $(document).on("click", ".ut-share-link", function(event){
                                    
            var social = $(this).data("social");
            
            switch (social) {
                case "utsharetwitter"   : utsharetwitter(); break;
                case "utsharefacebook"  : utsharefacebook(); break;
                case "utsharegoogle"    : utsharegoogle(); break;
                case "utsharelinkedin"  : utsharelinkedin(); break;
                case "utsharepinterest" : utsharepinterest(); break;
                case "utsharexing"      : utsharexing(); break;
            }
            
            event.preventDefault();
            
        });
        
		
	});
	
})(jQuery);
 /* ]]> */