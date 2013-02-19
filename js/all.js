$(function(){

    // applies auraScroll "plugin" (le virgolette le ho già messe io, dj! :P) to latest campaigns ul
    
	if($.fn.auraScroll) $('#gallery').auraScroll();

	var scrollCarousel = $('#scroll-carousel');
	if($.fn.scrollCarousel)	{
		scrollCarousel.scrollCarousel();
		scrollCarousel.bind('onChange', function(e, newItem){

		});
	}



	// retrieves the extra url part for deeplinking items like single partners/campaigns, and loads content
	var hash = window.location.hash.replace('#','');
	if (hash == "category"){
		
	}
	else {
		if(window.location.hash){
	        var url = currUrl + window.location.hash.replace('#/', '') + '/?ajax=true';
	        if(url.indexOf('faq') != -1) {
	        	url = url.replace('partners/', '');
	        }
	        if($('#archive-partner').length > 0) {
	        	loadPartner(url);
			} else if ($('#archive-campaign').length > 0) {
				loadPopup(url);
			}
	    }
	}	    

	// smooth scroll for hash links
	$('a[href^=#].scroll-to-btn').click(function(){
		var target = $($(this).attr('href'));
		var offsetTop = (target.length != 0) ? target.offset().top : 0;
		$('html, body').animate({scrollTop: offsetTop}, 500);
		return false;

	});
    


	// opens details on single partner click

    $('#partners #category .post a:not(.no-click), #details .button, .button.ajax').live('click', function(e) {

		window.location.hash = '/' + $(this).data('url');
		$('div.post a').not(this).removeClass('selected');
		$(this).addClass('selected').blur();
		loadPartner($(this).attr('href'));
		e.preventDefault();

	});
    $('a.no-click').click(function(e){
    	e.preventDefault();
    });


    // closes div and removes div content on details close-button click

	$('#details .close-button').live('click', function(e){

		$details = $(this).closest('section');
		window.location.hash = '';
		$('div.post a').removeClass('selected').transition({ scale: 1 });
		$details.slideUp('slow', function(){

			$details.html('');

		});

		e.preventDefault();

		var offsetTop = $('#details').offset().top;
		$('body, html').animate({scrollTop: offsetTop}, 500);

	});





	// opens lightbox on links

	$('.lightbox-btn').live('click', function(e){
		if($(this).data('url')){
			window.location.hash = '/' + $(this).data('url');
		}
		loadPopup($(this).attr('href'));
		e.preventDefault();

	});



	// closes lightbox on overlay and close-button click

	$('.lightbox-overlay, .lightbox .close-button').live('click', function(e){
		if($('.lightbox').html() != ''){
			window.location.hash = '';
			$('.lightbox').fadeOut(function(){
				$('.lightbox-overlay').fadeOut('slow');	
				$('.lightbox').html('');

			});						 	
		}
	});



	$('.share-popup-btn').click(function(){
		var url = $(this).attr('href');
		var width = 640;
		var height = 305;
		var left = ($(window).width() - width) / 2;
		var top = ($(window).height() - height) / 2;
		window.open(url, 'sharer', 'toolbar=0,status=0,width='+width+',height='+height+',left='+left+', top='+top);
		return false;
	});
	

});


function toggleHeader(){
	// var header = $('#header'),
	// 	headerHeight = header.outerHeight(),
	// 	scrollTop = $(window).scrollTop(),
	// 	scrollCarousel = $('#scroll-carousel');
	// if(scrollTop > headerHeight - 70 && !header.hasClass('compact')){
	// 	header.addClass('compact');
	// 	if(scrollCarousel.index > 0) scrollCarousel.scrollCarousel('setSlides');
	// } else if(scrollTop < headerHeight - 70 && header.hasClass('compact')){
	// 	header.removeClass('compact');
	// 	if(scrollCarousel.index > 0) scrollCarousel.scrollCarousel('setSlides');
	// }
}

function loadPopup(url){
	var val = new RegExp('(\\?|\\&)ajax=.*?(?=(&|$))'),
	qstring = /\?.+$/;

	if (val.test(url)){
		url = url.replace(val, '$1ajax=true');
	} else if (qstring.test(url)) {
		url = url + '&ajax=true';
	} else {
		url = url + '?ajax=true';
	}
	
	$('.lightbox').css({'top': $(window).scrollTop() + 50});
	$('.lightbox-overlay').fadeIn('slow', function(){
		$('html,body').animate({scrollTop: $('.lightbox').offset().top}, 500);
		$('.lightbox').html('<div class="loader"><img src="' + themeUrl + '/images/icon_spinner.gif" /></div>');
		$('.lightbox').delay(100).fadeIn();
		$.ajax({
			url: url,
			dataType: 'html',
			success:function(data) {
				$('.lightbox').fadeOut(function(){
					$('.lightbox')
						.html(data)
						.delay(200)
						.fadeIn();
				});
			}
		});
	});
}

function loadPartner(url) {
	var details = $('#details'),
		mainDiv = $('#main'),
		mainOffsetTop = Math.floor(mainDiv.offset().top);
	
	if($('.content', details).length > 0){
		details.slideUp({duration: 600, easing: 'easeInOutQuad', complete: function(){
			$(this).html('');	
		}});
	}

	$('html, body').animate({scrollTop: mainOffsetTop}, 800);
	details.slideDown({duration: 600, easing: 'easeInOutQuad', complete: function(e){
		details.append('<div class="loader align-center"><img src="' + themeUrl + '/images/icon_spinner_dark.gif" /></div>');
		details.find('.loader').delay(100).fadeIn();

		$.ajax({

			url: url,
			dataType: 'html',
			success: function(data) {

				details.find('.loader').fadeOut(function(){

					details.append( $("<div></div>").addClass('content') );
					details.find('.content').html(data)
					.delay(200)
					.slideDown();
				});

			}

		});
	}});
}

$(function() {
   
// Create the dropdown base
$("<select />").appendTo("nav.main-navigation");

// Create default option "Go to..."
$("<option />", {
 "selected": "selected",
 "value"   : "",
 "text"    : "Menu"
}).appendTo("nav select");
$("<option />", {
 "value"   : "/",
 "text"    : "Home"
}).appendTo("nav select");

// Populate dropdown with menu items
$("nav ul li a").each(function() {
var el = $(this);
$("<option />", {
   "value"   : el.attr("href"),
   "text"    : el.text()
}).appendTo("nav select");
});

   // To make dropdown actually work
   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
$("nav select").change(function() {
window.location = $(this).find("option:selected").val();
});

$('.home-page-item .home-button').fadeIn(1000);
 
 });

