$.fn.scroller = function(options) {
	
	var defaults = {
		autoScroll: false,
		scrollAll: false,
		easing: 'easeInOutExpo'
	};
	options = $.extend({}, defaults, options);
	
	var scroller = $(this);
	var currItem = $('.scroll-item:eq(0)', scroller);
	if($('.scroll-item', scroller).hasClass('current')){
		currItem = $('.scroll-item.current', scroller);
	}
	var speed = 800;
	var easing = options.easing;
	var canAutoScroll = true;
	var canScroll = true;
	var firstLoad = true;
	var totalItems = $('.scroll-item', scroller).size();
	
	function gotoItem(id, direction){
		var nextItem = $('.scroll-item[data-id='+id+']', scroller);
		var nextI = nextItem.index();
		var currI = currItem.index();
		var scrollWidth = nextItem.outerWidth(true);
		canScroll = (firstLoad || id !== currItem.data('id'));
		
		if(canScroll && !$('.scroll-item', scroller).is(':animated') && !$('.scroll-items-container', scroller).is(':animated')){
			canScroll = false;
			var targetX = 0;
			if(options.scrollAll){
				if(currI < nextI){
					targetX = scrollWidth * (nextI - currI);
				} else {
					targetX = -scrollWidth * (currI - nextI);
				}

				
				if(!firstLoad){
					// $('> .overlay', currItem).fadeIn();
					// $('> .overlay', nextItem).fadeOut();
					$('.description', currItem).fadeOut();
					$('.description', nextItem).fadeIn();
					if(currI < nextI){
						$('.scroll-items-container:not(:animated)', scroller).animate({left: -targetX}, speed, easing, function(){
							var nextII = nextI - 1;
							var nextItemTemp = $('.scroll-item:lt('+nextII+')', scroller);
							$('.scroll-item:last', scroller).after(nextItemTemp);
							$('.scroll-items-container', scroller).css({left: 0 + 'px' });
							nextItemTemp.hide().fadeIn();
							currItem = nextItem;
							canScroll = false;
						});
					} else {
						$('.scroll-item:first', scroller).before($('.scroll-item:last', scroller));
						$('.scroll-items-container', scroller).css({left: -scrollWidth + 'px' });
						$('.scroll-items-container:not(:animated)', scroller).animate({left: 0}, speed, easing, function(){
							currItem = nextItem;
							canScroll = false;
						});
					}
				} else {
					$('.description', nextItem).fadeIn();
					$('.scroll-item:first', scroller).before($('.scroll-item:last', scroller));
					$('.scroll-items-container', scroller).css({left: -scrollWidth + 'px' });
					$('.scroll-items-container:not(:animated)', scroller).css({left: 0});
					currItem = nextItem;
					canScroll = false;
				}
			} else {
				if(currI < nextI){
					targetX = scrollWidth;
				} else {
					targetX = -scrollWidth;
				}

				if(direction){
					switch(direction){
						case 'next':
							targetX = scrollWidth;
							break;
						case 'prev':
							targetX = -scrollWidth;
							break;
					}
				}
				if(!firstLoad){
					currItem.animate({'left': -targetX}, speed, easing, function(){
						$(this).removeClass('current');
					});
					nextItem.css({'left': targetX}).addClass('current').animate({'left': 0}, speed, easing, function(){
						currItem = nextItem;
						canScroll = false;
					});
				} else {
					nextItem.addClass('current');
					currItem = nextItem;
					canScroll = false;
				}
			}
			
			$('.scroller-pagination li', scroller).removeClass('current');
			$('.scroller-pagination li a[data-id='+nextItem.data('id')+']', scroller).parent().addClass('current');
			
			scroller.animate({height: nextItem.outerHeight()});
			scroller.trigger('onChange', [nextItem]);
			
		}
	}
	
	function gotoNextItem(){
		if(canAutoScroll){
			var nextItem = currItem.next();
			if(nextItem.length === 0){
				nextItem = $('.scroll-item:eq(0)', scroller);
			}
			gotoItem(nextItem.data('id'), 'next');
		}
	}
	
	function init(){
		if(totalItems > 1){
			$('.scroller-pagination a', scroller).on('click', function(){
				gotoItem($(this).data('id'));
			});
			
			$('.prev-btn', scroller).on('click', function(){
				var prevItem = currItem.prev();
				if(prevItem.length === 0){
					var lastI = totalItems - 1;
					prevItem = $('.scroll-item:eq('+lastI+')', scroller);
				}
				gotoItem(prevItem.data('id'), 'prev');
			});
			
			$('.next-btn', scroller).on('click', function(){
				var nextItem = currItem.next();
				if(nextItem.length === 0){
					nextItem = $('.scroll-item:eq(0)', scroller);
				}

				gotoItem(nextItem.data('id'), 'next');
			});

			if(options.autoScroll){
				var scrollInterval;
				scroller.hover(function(){
					canAutoScroll = false;
				}, function(){
					canAutoScroll = true;
				});
				scrollInterval = setInterval(gotoNextItem, 4000);
			}
			var initId = currItem.data('id');
			gotoItem(initId);
		} else {
			$('.scroller-navigation', scroller).hide();
			$('.scroller-pagination', scroller).hide();
		}

		$(window).load(function(){
			scroller.animate({height: currItem.outerHeight()});
		});
		
		firstLoad = false;
	}
	
	init();
	return scroller;
};