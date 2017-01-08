(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var app = {

    init: function() {
        $(document).ready(function() {
            var $body = $('body');
            var page = $body.data('page');
            var template = null;
            if ($body.attr('data-template')) {
                template = $body.data('template');
            }
            if('home' === page) {
                app.loadTwitter();
            }
        });
    },

    loadTwitter: function () {

        var i = 0;
        $.get('/dynamic-content/twitter-posts', function(tweets) {
            console.log('retetet', tweets);

            function updateContent(){
                if(Array.isArray(tweets)) {
                    var tweet = tweets[i];
                    $('#tweet-text').html(tweet.message);
                    $('#tweet-time').html(tweet.time);
                    tweet.user;
                    i++;
                    if(i >= tweets.length) i = 0;
                }
            }
            updateContent();
            setInterval(function() {
                updateContent();
            }, 10000);

        });

    }
};

module.exports = app.init();

require('./prototype/app.js').init();
require('./load-more.js').init();



},{"./load-more.js":2,"./prototype/app.js":3}],2:[function(require,module,exports){
load = {
    url: null,
    init: function() {
        $(document).ready(function($) {
            load.more();
            load.filter();
        });
    },

    more: function(){
        $('.load-more').click(function(){
            var btn = $(this),
            params  = btn.data('params'),
            url     = load.url? load.url: btn.data('url'),
            target  = btn.data('target'),
            parentForm = btn.data('filter-form'),
            keyVal = load.getfilters($(parentForm).find('.wpf-filter'));
            
            $.get(url, keyVal, function( data ) {
                var params = data.params;
                (!params.has_next)? btn.hide(): btn.show();
                load.url = null;
                btn.data('url', (url = params.next_url));
                $.when($(target).append(data.items)).then(function(){
                    $('html, body').animate({
                    scrollTop: $("#load-more-item-id-" + params.first_id).offset().top
                    }, 1000);
                });
            });
        });
    },

    filter: function(){
         $('.wpf-filter').bind("change keyup", function(){
            var el = $(this),
            parentForm = el.closest('form'),
            url = parentForm.data('url'),
            target = parentForm.data('target'),
            loadMoreBtn = parentForm.data('load-more'),
            keyVal = load.getfilters(parentForm.find('.wpf-filter'));
            keyVal.page = 1;
            
            $(target).fadeTo(500, 0.6);

            $.get(url, keyVal, function( data ) {
                
                var params = data.params;

                (!params.has_next)? $(loadMoreBtn).hide() :$(loadMoreBtn).show();

                // When we filter we revert back to page one. 
                // Therefore our next url will be on page two
                load.url = url + '?page=2';

                $.when($(target).html(data.items)).then(function(){
                    $(target).fadeTo(200, 1);
                });
            });
        });
    },

    getfilters: function(filterables) {
        var keyVal = {};
        $(filterables).each(function(i, el){
            var value = $(this).val();
            if(value){
                keyVal[$(this).attr('name')] = $(this).val();
            }
        });
        return keyVal;
    }
};

module.exports = load;
},{}],3:[function(require,module,exports){
'use strict';

module.exports = {

 init: function() {
	vHeight();
	vHeightHalf();
	divsEqualH();
	centerV();
	labelFile();
	labelFileCV();
	labelFileUniversal();
	labelFileUniversalChange();
	cvFile();
	scrollTo();
	hotSkills();
	mobileBtn();
	parentH(50, 150);
	filterOpen(250);
	$(".owl-carousel").owlCarousel({
		loop: false,
		items: 1,
		autoplay: true,
		autoplayTimeout: 4000,
    	autoplayHoverPause: true,
    	dots: true,
    	mouseDrag: false,
    	// autoHeight: true
	});
	// applyForm();

	// smartsupp('theme:set', 'flat');
	// // setup your colors
	// smartsupp('theme:colors', {
	// 	primary: '#50e3c2',
	// 	primaryText: '#ffffff',
	// 	widget: '#43c1a5',
	// 	widgetText: '#ffffff',
	// 	banner: '#333333'
	// });

	$(window).on('load resize', function(){
		parentH(50, 150);
		vHeight();
		vHeightHalf();
		divsEqualH()
		equalH();
		centerV();
		if($(window).width() >= 800) {
			$('.filter-opener').next().css('display', 'block');
		}
		asideStick();
	});

	$(document).on('scroll', function(){
		menuStick();
	});

	function scrollTo(){
		$('.scrollTo').on('click touchstart', function(e){
			e.preventDefault();
			$('html, body').animate({
		        scrollTop: $('.'+$(this).attr('data-to')).offset().top - 120
		    }, 750);
		});
	}

	function vHeight(){
		$('.vheight').height($(window).height());
	}

	function vHeightHalf(){
		$('.vheight-half').height($(window).height()*0.5);
	}

	function centerV(){
		$('.centerV').each(function(){
			$(this).css({'margin-top' : '-'+$(this).height()/2+'px'});
		});
	}

	function parentH( $time1, $time2 ){
		$('.parentH').each(function(){
			var $this = $(this);
			var $thisH = $this.height();
			var $child = $this.children();
			var $childH = $child.height();

			$child.outerHeight('auto');
			if($(window).width() >= 800) {
				setTimeout(function() {
					$child.outerHeight($thisH);	
				}, $time1);
				setTimeout(function() {
					$child.outerHeight($thisH);	
				}, $time2);
			}

		});
	}

	function menuStick(){
		if($(window).scrollTop() >= 34){
			$('nav.main-navigation').addClass('stick');
		} else{
			$('nav.main-navigation').removeClass('stick');
		}
	}

	function divsEqualH(){
		var maxHeight = -1;

		$('.footer-section').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		if($(window).width() >= 1024) {
			$('.footer-section').each(function() {
				$(this).height(maxHeight);
			});
		} else {
			$('.footer-section').each(function() {
				$(this).height('auto');
			});
		}
	}

	function equalH(){
		var maxHeight = -1;

		$('.equalH').each(function() {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		$('.equalH').each(function() {
			$(this).height(maxHeight);
		});
	}

	function asideStick(){
		if($(window).width() >= 800) {
			if($(window).height() - $('.main-navigation').height() > $('.job-filters, .job-details').find('aside').outerHeight()){
				$('.job-filters, .job-details').find('aside').addClass('sticky');
			} else {
				$('.job-filters, .job-details').find('aside').removeClass('sticky');
			}
		}
		if($(window).width() > 1920 && $('.job-filters, .job-details').find('aside').hasClass('sticky')) {
			$('.job-filters, .job-details').find('aside').css({'left' : ''+($(window).width() - 1920)/2+'px'});
		} else {
			$('.job-filters, .job-details').find('aside').css({'left' : '0'});
		}
	}

	function labelFile(){
		$('form').find('.photoLabel').on('click touchstart', function(){
			$(this).parent().find('.photo-file').trigger('click');
		});
	}

	function labelFileCV(){
		$('form').find('.cvLabel').on('click touchstart', function(){
			$(this).parent().find('.cv').trigger('click');
		});
	}

	function labelFileUniversal(){
		$('form').find('label.file').on('click touchstart', function(){
			$('form').find('input.file').trigger('click');
		});
	}

	function labelFileUniversalChange(){
		$('form').find('input.file').on('change', function(input){
			$('form').find('label.file').text($('form').find('input.file').val().replace("C:\\fakepath\\", ""));
		});
	}

	function readURL(input){
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $('#labelP').css('background-image', 'url('+e.target.result+')');
	            $('.photoLabel').text('');
	            $('.apply-form').find('input.photo-url').val('');
	        };
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	function cvFile(){
		$('label.cvLabel').prev().on('change', function(input){
			$(this).next().text($(this).val().replace("C:\\fakepath\\", ""));
		});
	}

	function hotSkills(){
		$('footer').find('.hot-skills').find('a').on('click touchstart', function(e){
			e.preventDefault();
			var str = $(this).attr('href');
			var $search = str.replace( " ", "+" );
			window.location.href = 'https://www.searchitrecruitment.com/?s=' + $search;
		});
	}

	function mobileBtn(){
		$('.mobile-menu-btn').on('click', function(e) {
			e.preventDefault();
			$(this).toggleClass('active');
			$('ul.main-menu').toggleClass('active');
		});
	}

	function filterOpen( $time ){
		$('.filter-opener').on('click', function() {
			$(this).next().slideToggle( $time );
		});
	}

 }

};
},{}]},{},[1]);
