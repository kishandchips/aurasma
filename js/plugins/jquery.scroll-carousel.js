(function( $ ){

    var data = {
        slider: {},
        options: {
            easing: 'easeOutQuart',
            speed: 600
        },
        currId: '0',
        totalItems: 0,
        canScroll: true,
        canAutoScroll: true,
        isScrolling: false,
        firstLoad: true,
        scrollOnce: true,
        snapInterval: '',
        autoScrollInterval: '',
        methods: {
            init : function( ) {
                data.slider = $(this);
                data.totalItems = $('.slide-item', data.slider).size();

                $('.slide-btn', data.slider).on('click', function(e){
                    e.preventDefault();
                    data.methods.goto($(this).attr('data-id'));
                });
                if(!Modernizr.touch){
                    $(window).mousewheel(function(e, delta){
                        e.preventDefault();
                        if(!data.isScrolling && data.canScroll){
                            if ( delta > 0 ) {
                                data.methods.gotoPrev();
                            } else if ( delta < 0 ) {
                                data.methods.gotoNext();
                            }
                        }
                    });
                }
                
                // data.slider.hover(function(){
                //     data.canAutoScroll = false;
                //     clearInterval(data.autoScrollInterval);
                // }, function(){
                //     data.canAutoScroll = true;
                //     data.autoScrollInterval = setInterval(data.methods.autoScroll, 8000);
                // });

                $(window).bind('scrollstop', function(){
                    setTimeout(function(){
                         data.canScroll = true;
                    }, 500);
                });

                $(window).scroll(function(){
                    data.canScroll = false;
                });

                $(document).keydown(function (e) {
                    
                    var keyCode = e.keyCode || e.which,
                        arrow = {up: 38, down: 40 };
                    switch (keyCode) {
                        case arrow.up:
                            data.methods.gotoPrev();
                            e.preventDefault();
                        break;
                        case arrow.down:
                            data.methods.gotoNext();
                            e.preventDefault();
                        break;
                    }
                });

                if(window.location.hash){
                    var url = window.location.hash.replace('#/', '');
                    if($('.slide-item[data-url="'+url+'"]', data.slider).length){
                      data.currId = $('.slide-item[data-url="'+url+'"]', data.slider).data('id');
                    } else {
                        data.currId = $('.slide-item:first', data.slider).data('id');
                    }
                } else {
                    data.currId = $('.slide-item:first', data.slider).data('id');
                }
                
                data.methods.setSlides();
                if(!Modernizr.touch){
                    $(window).load(function(){
                        data.snapInterval = setInterval(data.methods.snap, 500);
                        data.autoScrollInterval = setInterval(data.methods.autoScroll, 8000);

                        data.methods.goto(data.currId);
                        data.methods.setSlides();
                        data.firstLoad = false;
                    });
                }
                $(window).resize(function(){
                    data.methods.setSlides();
                });
                if(!Modernizr.touch){
                    $('.slide-navigation').show();
                }
            },
            goto: function(id){
                var speed = 1000,
                    currItem = $('.slide-item[data-id="'+data.currId+'"]', data.slider),
                    currItemI = parseInt(currItem.data('index')),
                    newItem = $('.slide-item[data-id="'+id+'"]', data.slider),
                    newItemI = parseInt(newItem.data('index')),
                    prevItem = newItem.prev(),
                    nextItem = newItem.next(),
                    newContent = $('.content', newItem),
                    prevContent = $('.content', prevItem),
                    nextContent = $('.content', nextItem),
                    iconOffset = parseInt(newContent.outerHeight() / 2),
                    offset = parseInt(newItem.outerHeight() * parseInt(newItemI)),
                    url = newItem.data('url');

                if(data.firstLoad || ((id !== data.currId) && (data.canScroll) || ($('html, body').scrollTop() !== offset))) {
                    data.isScrolling = true;
                    data.canScroll = false;
                    if(data.currId < id) {
                        newContent.css({ marginTop: 'auto', bottom: -newContent.height, top: '100%' });
                    } else if (data.currId > id) {
                        newContent.css({ bottom: 'auto', marginTop: -newContent.height, top: '38%' });
                    }
                    $('html, body').stop().animate(
                        { scrollTop: offset }, 
                        data.options.speed, data.options.easing, 
                        function(){
                            data.canScroll = true;
                            data.isScrolling = false;
                        }
                    );

                    if(nextContent){ 
                        setTimeout(function(){
                            nextContent.stop().animate(
                                { opacity: 0, bottom: 'auto', marginTop: newContent.height, top: '100%' },
                                data.options.speed,
                                data.options.easing
                            );
                        }, 300);
                    }
                    if(!data.firstLoad){
                        setTimeout(function(){
                            newContent.stop().animate(
                                { opacity: 1, marginTop: -iconOffset, top: '38%' }, 
                                data.options.speed,
                                data.options.easing
                            );
                        }, 300);
                    }

                    prevContent.stop().animate(
                        {  opacity: 0, marginTop: -newContent.outerHeight(), top: '0%' }, 
                        speed,
                        data.options.easing
                    );

                    $('.slide-navigation li').removeClass('current');
                    $('.slide-navigation li a[data-id="' + id + '"]').parent().addClass('current');
                    currItem.removeClass('current');
                    newItem.addClass('current');

                    data.methods.setSlides();
                    window.location.hash = '/' + url;
                    data.currId = id;
                    data.slider.trigger('onChange', [newItem]);
                }
            },
            gotoPrev: function(){
                var currItem = $('.slide-item[data-id="'+data.currId+'"]', data.slider),
                    currItemI = parseInt(currItem.data('index')),
                    newItemI = currItemI - 1;
                
                if(newItemI <= -1) return false;
                var newItem = $('.slide-item[data-index="'+newItemI+'"]', data.slider);
                data.methods.goto(newItem.data('id'));
            },
            gotoNext: function(){
                
                var currItem = $('.slide-item[data-id="'+data.currId+'"]', data.slider),
                    currItemI = parseInt(currItem.data('index')),
                    newItemI = currItemI + 1;
                
                if(newItemI == data.totalItems) return false;
                var newItem = $('.slide-item[data-index="'+newItemI+'"]', data.slider);
                data.methods.goto(newItem.data('id'));
            },
            snap: function(){
                if(data.canScroll){

                    var currItem = $('.slide-item[data-id="'+data.currId+'"]', data.slider),
                        offset = parseInt(currItem.outerHeight() * parseInt(currItem.data('index')));
                    if(offset !== $(window).scrollTop()){
                        var newI = Math.round($(window).scrollTop() / $('.slide-item', data.slider).height()),
                            newItem = $('.slide-item[data-index="'+newI+'"]', data.slider);
                        data.methods.goto(newItem.data('id'));
                    }

                }
            },
            autoScroll: function(){
                if(data.canAutoScroll){
                    var lastItem = $('.slide-item:last', data.slider),
                        firstItem = $('.slide-item:first', data.slider);
                    if(data.currId == lastItem.data('id')){
                        data.methods.goto(firstItem.data('id'));
                    } else {
                        data.methods.gotoNext();
   
                    }
                }
            },
            setSlides: function(){
                var currItem = $('.slide-item[data-id="'+data.currId+'"]', data.slider),
                    header = $('#header'),
                    // headerHeight = (parseInt(currItem.data('index')) !== 0) ? header.outerHeight() : 78,
                    headerHeight = header.outerHeight(),
                    scrollCarousel = $('#scroll-carousel'),
                    slideItems = $('.slide-item', data.slider),
                    slideHeight = parseInt($(window).height() - headerHeight),
                    slideWidth = parseInt($(window).width()),
                    bgImages = $('.bg img', slideItems);

                if(currItem.length > 0){

                    $('#slides-container', data.slider).css({ marginTop: headerHeight });
                    slideItems.css({'height': slideHeight});

                    bgImages.each(function(){
                        var img = $(this),
                            maxWidth = slideWidth,
                            maxHeight = slideHeight;

                        if(data.firstLoad){
                            img.data('init-ratio', (img.height() / img.width()));
                        }

                        if ( (maxHeight / maxWidth) < parseFloat(img.data('init-ratio')) ) {
                            img.css({width: '100%', height: 'auto'});
                        } else {
                            img.css({width: 'auto', height: '100%'});
                        }
                        if(img.width()) img.css('marginLeft', -((img.width() - maxWidth)/2));
                        if(img.height()) img.css('marginTop', -((img.height() - maxHeight)/2));
                        
                        //if(img.height()) img.css({marginTop: -((img.height() - slideHeight) / 2)});

                    });   
                }
            }
        }
    };

    $.fn.scrollCarousel= function( method ) {

        // Method calling logic
        if ( data.methods[method] ) {
            return data.methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return data.methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on $.scrollCarousel' );
        }

    };

})( $ );


(function(){
 
    var special = jQuery.event.special,
        uid1 = 'D' + (+new Date()),
        uid2 = 'D' + (+new Date() + 1);
 
    special.scrollstart = {
        setup: function() {
 
            var timer,
                handler =  function(evt) {
 
                    var _self = this,
                        _args = arguments;
 
                    if (timer) {
                        clearTimeout(timer);
                    } else {
                        evt.type = 'scrollstart';
                        jQuery.event.handle.apply(_self, _args);
                    }
 
                    timer = setTimeout( function(){
                        timer = null;
                    }, special.scrollstop.latency);
 
                };
 
            jQuery(this).bind('scroll', handler).data(uid1, handler);
 
        },
        teardown: function(){
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid1) );
        }
    };
 
    special.scrollstop = {
        latency: 300,
        setup: function() {
 
            var timer,
                    handler = function(evt) {
 
                    var _self = this,
                        _args = arguments;
 
                    if (timer) {
                        clearTimeout(timer);
                    }
 
                    timer = setTimeout( function(){
 
                        timer = null;
                        evt.type = 'scrollstop';
                        jQuery.event.handle.apply(_self, _args);
 
                    }, special.scrollstop.latency);
 
                };
 
            jQuery(this).bind('scroll', handler).data(uid2, handler);
 
        },
        teardown: function() {
            jQuery(this).unbind( 'scroll', jQuery(this).data(uid2) );
        }
    };
 
})();