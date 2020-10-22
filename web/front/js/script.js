$(document).ready(function() {
// START

// LOADER PAGES
	$('#loadPage img').fadeOut(900);
	setTimeout(function(){
	  $('#loadPage').fadeOut(400);
	}, 1000);

// HARMONIZE
	//$('.harmonize').matchHeight();

// MENU
	$(function() {
        $('.toggleLi').on('click', function( event ){
            var
                element = $(this),
                ul = element.next('ul'),
                count = ul.length;

            $('.toggleLi').not($(this)).removeClass('active');
			$(this).toggleClass('active');
            $('.subNav').slideUp();

            if(count > 0 && !ul.is(':visible')){
                ul.slideDown();
                event.preventDefault();
            }else{
            	event.preventDefault();
            	ul.slideUp();
            }
        });
    });

	$(document).click(function(event) { 
		if(!$(event.target).closest('.toggleLi').length && !$(event.target).closest('.subNav').length && !$(event.target).closest('#navMobile').length){
			$('.subNav').slideUp();
            $('.toggleLi').not($(this)).removeClass('active');
		} 
	});

// MENU MOBILE
	$('#navBtn').click(function() {
		$(this).toggleClass('active');
		$('#navMobile').toggleClass('active');
	});

// SCROLL
	$('.scrollTo').click( function() { // Au clic sur un élément
		var page = $(this).attr('href'); // Page cible
		var speed = 750; // Durée de l'animation (en ms)
		$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
		return false;
	});

// PADDING-TOP SLIDER ou BODY
	$(window).on('resize scroll load', function(){ //'resize scroll load'
    	$('#paddingTop').css({
       		'padding-top': $('header').outerHeight()
		});
	});

// SLIDER

  var swiper = new Swiper('.swiper-slide-home', {
    slidesPerView: 1,
    spaceBetween: 0,
    speed: 1000,
    loop: true,
    pagination: {
      el: '.swiper-slide-home-pagination',
      type: 'bullets',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-slide-home-next',
      prevEl: '.swiper-slide-home-prev',
    }
  });

// FIXED-HEADER
	if ($('#header').length > 0 /*&& $(window).width() < 992*/ ) {
        if ($('#header').offset().top > 0) {
            $('body').addClass('fixed-header');
        } else {
            $('body').removeClass('fixed-header');
        }

        /* Scroll Function */
        $(window).scroll(function () {
            /* Fixed Navigation */
            if ($('#header').offset().top > 0) {
                $('body').addClass('fixed-header');
            } else {
                $('body').removeClass('fixed-header');
            }
        });
    }

// DATA-ANIMATE
	var $isMobile = false;
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp| netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck| ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c| k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50| p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]| c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) $isMobile = true;

	// isInViewport
	$.fn.isInViewport = function(){
	   var eT = $(this).offset().top,
	       eB = eT + $(this).outerHeight(),
	       vT = $(window).scrollTop()-80,
	       vB = vT + $(window).height();
	   return eB > vT && eT < vB;
	};

   	window.animateReveal = function(){
       if($isMobile == false){
           $('[data-animate]').each(function(){
               var t = $(this);
                   d = t.data('duration');
                   y = t.data('delay');
               t.css({"animation-duration" : d + "s", "-webkit-animation-duration" : d + "s", "-moz-animation-duration" : d + "s", "-o-animation-duration" : d + "s", "-ms-animation-duration" : d + "s","animation-delay" : y + "s", "-webkit-animation-delay" : y + "s", "-moz-animation-delay" : y + "s", "-o-animation-delay" : y + "s", "-ms-animation-delay" : y + "s"});
               t.addClass('animated paused ' + t.data('animate'));
               if(t.isInViewport()){
                   t.removeClass('paused').removeAttr('data-animate');
               }
           });
       }
   }
   $(window).on('resize scroll load', function(){
       animateReveal();
   });

// DATA-LINK
	$("[data-link]").each(function(){
		var a = $(this).find('a'),
		h = a.attr("href"),
		tr = a.attr("target");
		t = a.attr("title");
		$(this).attr('title', t);
		$(this).on('click', function(e){
			e.preventDefault();            
			if(tr == 'blank'){
				window.open(h, "_blank");
			}else{
				if(h != undefined && h != null && h != '#' && h != '' && tr != '_blank' && tr != 'blank'){
					document.location.href = h;
				}
			}
		});
	});

// DATA-BACKGROUND
    $('[data-background]').each(function(){
        var i = $(this).data('background');
        if(i){ $(this).css('background-image', 'url('+ i +')');}
    });

// DATA-MAIL
	$('[data-mail]').each(function(){
        var $t = $(this),
            m = $t.data('mail'),
            d = $t.data('domain'),
            mail = m + '@' + d,
            dis = m + '<i class="at-mail"></i>' + d;
        $t.append(dis).on('click', function(){
            location.href = "mailto:" + mail;
            !1;
        });
    });

// END
});