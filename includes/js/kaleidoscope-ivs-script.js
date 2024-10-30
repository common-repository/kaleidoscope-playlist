// Closure for my variables to be private.
(async function( $ ) {
	// default 
	var ivs_data = {
		width:  640,
		height: 360,
		caption : ''
	}

	var ivs_navigation = {
		navigation: 'block'
	}

	// ajax request to get slideshow height and width, Navigation
	await $.ajax({
        url: kaleidoscope_ajax_object.ajax_url,
        type: 'post',
        dataType: 'json',
        data: {'action': 'ivs_action', 'getData': '1'},
        success: function (response) {
			if(response.width && response.height) {
				ivs_data = {
					height: response.height,
					width:  response.width,
				}
				if(response.caption) {
					ivs_data.caption = response.caption
				}
			} else {
				ivs_data = {
					width:  640,
					height: 360,
				}
				if(response.caption) {
					ivs_data.caption = response.caption
				}
			}
			ivs_navigation = {
				navigation: response.navigation
			}
        }
    });

	
	// Default options
	var slider;

	var defaultOpt = {
		slideShow: false,
		interval: 3000,
		animation: "slide"
	}

	// Plugin definition.
	$.fn.kaleidoscopeSlider = function( options ) {
		// Merging options
		var options = $.extend({}, defaultOpt, options);

		// Initializing slider
		kaleidoscopeInitSlider(options, this);

		// Adding click events
		kaleidoscopeAddEvents();

		// Autoplay if true
		if (options.slideShow == true) {
			 var autoSlide = setInterval(slider.autoPlay.bind(slider), options.interval);
			 $('.kaleidoscope-prev').click(function () {
				clearInterval(autoSlide);
				autoSlide = setInterval(slider.autoPlay.bind(slider), options.interval);
			});
			
			$('.kaleidoscope-next').click(function () {
				clearInterval(autoSlide);
				autoSlide = setInterval(slider.autoPlay.bind(slider), options.interval);
			});

			$('.kaleidoscope-dots').children().each(function (index, value) {
				$(value).click(function () {
					clearInterval(autoSlide);
					autoSlide = setInterval(slider.autoPlay.bind(slider), options.interval);
				});
			});
		
		}

		return $(".kaleidoscope-slider");
	};

	// Function responsibe for slider generation
	function kaleidoscopeInitSlider(options, element) {
		// Scraping main information about our slider
		var slides = [];
		$(element[0]).children().each(function() {
			var li = $( this );
            var obj = {};

            obj['data-url'] = li.attr("data-url");
			// obj['data-url-small'] = li.attr("data-url-small");
			obj['data-url-large'] = li.attr("data-url-large");
			obj['data-type'] = li.attr("data-type");
			obj['data-caption'] = li.attr("data-caption")
			obj['data-link'] = li.attr("data-link")


			slides.push(obj);
        });

		// Replacing the <ul> with the newly generated slider
		$(element[0]).replaceWith(function () {
			var i;
			var elements = "";
			for (var i = 0; i < slides.length; i++) {
				var active = i == 0 ? 'active' : '';
				if (slides[i]['data-type'] == "UserImage" || slides[i]['data-type'] == "Image" || slides[i]['data-type'] == "UserLayout" || slides[i]['data-type'] == "Layout") { // Template for images
					elements += "<div class='kaleidoscope-slide " + 'kaleidoscope_'+options.animation + " " + active +"'>\n";
					if(slides[i]['data-link']) {
						elements += "<a target='blank' href='"+slides[i]['data-link']+"'><picture><source media='(max-width:767px)' srcset='"+ slides[i]['data-url'] + "'><source media='(min-width:768px)' srcset='"+ slides[i]['data-url-large'] + "'><img src='"+ slides[i]['data-url-large'] + "'></picture></a>\n";
					} else {
						elements += "<picture><source media='(max-width:767px)' srcset='"+ slides[i]['data-url'] + "'><source media='(min-width:768px)' srcset='"+ slides[i]['data-url-large'] + "'><img src='"+ slides[i]['data-url-large'] + "'></picture>\n";
					}
					// elements += "<picture><source media='(max-width:767px)' srcset='"+ slides[i]['data-url'] + "'><source media='(min-width:768px)' srcset='"+ slides[i]['data-url-large'] + "'><img src='"+ slides[i]['data-url-large'] + "'></picture>\n";
					if(slides[i]['data-caption'] && ivs_data.caption=="yes") {
						elements += "<p>"+ slides[i]['data-caption'] +"</p>"	
					}
					elements += "</div>\n";
				} else if (slides[i]['data-type'] == "UserVideo") { // Template for videos
					elements += "<div class='kaleidoscope-slide "+ 'kaleidoscope_'+options.animation + " " + active +"'>\n";
					elements += "<video width='100%' height='500px'>\n";
					elements += "<source src='" + slides[i]['data-url'] + "'>\n"
					elements += "</video>\n";
					elements += "<span class='play-button'>&#9654;</span>";
					if(slides[i]['data-caption'] && ivs_data.caption=="yes") {
						elements += "<p>"+ slides[i]['data-caption'] +"</p>"	
					}
					elements += "</div>\n";
				}
			}
			elements += "<a class='kaleidoscope-prev'>&#10094;</a>\n"; // Previous button
			elements += "<a class='kaleidoscope-next'>&#10095;</a>\n"; // Next button

			var list = "<div class='kaleidoscope-wrapper' style='max-width:"+ivs_data.width+"px;'><div class='kaleidoscope-slider' style='height:"+ivs_data.height+"px; max-width:"+ivs_data.width+"px;'>" + elements + '</div>\n';
			// Navigation dots
			list += "<div style=' max-width:"+ivs_data.width+"px; display:"+ivs_navigation.navigation+";' class='kaleidoscope-dots'>\n";
			for (var i = 0; i < slides.length; i++) {
				var active = i == 0 ? 'selected' : '';
				list += "<span class='kaleidoscope-dot " + active + "' data-kaleidoscope-dot-index='"+ i +"'></span>\n"
			}
			list += "</div></div>";
			return list;
		});

		// Creating new Slider object, which will contain main information about our slider
		slides.forEach(function (slide, index) {
			slide.ref = $($('.kaleidoscope-slider')[0]).children()[index];
		});
		slider = new kaleidoscopeSlider(options, slides);
	}

	function kaleidoscopeAddEvents() {
		$('.kaleidoscope-dots').children().each(function (index, value) {
			$(value).click(function () {
				var n = $(this).attr('data-kaleidoscope-dot-index');
				n *= 1;
				slider.active = n;
				slider.showSlide();
			});
		});
		$('.kaleidoscope-prev').click(function () {
			slider.active--;
			slider.showSlide();
		});
		$('.kaleidoscope-next').click(function () {
			slider.active++;
			slider.showSlide();
		});
		slider.slides.forEach(function (value, index) {
			if (value['data-type'] == 'UserVideo') {
				$($(value['ref']).find(".play-button")[0]).click(function () {
					slider.resumeVideo(index);
				});
			}
		});
	}

	// Defining Slider class
	function kaleidoscopeSlider(options, slides) {
		this.active = 0;
		this.options = options;
		this.slides = slides;
		this.playing = false;

		this.showSlide = function () {
			var i;
			var dots = $('.kaleidoscope-dots').children();
			if (this.active > this.slides.length-1) {
				this.active = 0;
			}; 
			if (this.active < 0) {this.active = this.slides.length-1};
			for (i = 0; i < this.slides.length; i++) {
				if (this.slides[i]['data-type'] == "video") {
					$(this.slides[i]['ref']).find("video")[0].pause();
					$(this.slides[i]['ref']).find("video")[0].currentTime = 0;
					$(this.slides[i]['ref']).find(".play-button").css("display", "block");
				}
				$(this.slides[i]['ref']).removeClass("active");
			}
			dots.each(function (index, value) {
				$(value).removeClass("selected");
			});

			$(this.slides[this.active]['ref']).addClass('active'); 
			$(dots[this.active]).addClass('selected');
		}

		this.autoPlay = function() {
			if (this.options.slideShow == true && this.playing == false) {
				this.active++;
				this.showSlide();
				//  autoPlayFunction =  setTimeout(this.autoPlay.bind(this), this.options.interval);
			}
		}

		this.resumeVideo = function (n) {
			var video = $(this.slides[n]['ref']).find("video")[0];
			var button = $($(this.slides[n]['ref']).find(".play-button")[0]);
			video.play();
			button.css("display", "none");
			this.playing = true;
			var that = this;
			$(video).click(function () {
				video.pause();
				button.css("display", "block");
				$(video).unbind("click");
				that.playing = false;
				setTimeout(that.autoPlay.bind(that), options.interval);
			});
			$(video).bind("ended", function() {
				video.currentTime = 0;
				button.css("display", "block");
				$(video).unbind("ended");
				that.playing = false;
				setTimeout(that.autoPlay.bind(that), options.interval);
			});
		}
	}

	
	jQuery(document).ready(function ($) {
		$.ajax({
			url: kaleidoscope_ajax_object.ajax_url,
			type: 'post',
			dataType: 'json',
			data: {'action': 'my_action', 'getData': '1'},
			success: function (response) {
				$('.kaleidoscope-slider').kaleidoscopeSlider({
					slideShow: response.autoplay,
					interval: response.interval,
					animation: response.animation
				});
				
				if(response.bg_color) {
					var opacity = response.bg_transparent;
					var color = response.bg_color;
					var rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';
				} else {
					var opacity = 0.05;
					var rgbaCol = 'rgba(' + 0 + ',' + 0 + ',' + 0 + ',' + opacity + ')';
				}

				$('.kaleidoscope-slider').css('background-color', rgbaCol)

				if(response.border=='yes' && !response.border_color) {
					$('.kaleidoscope-slider').css('border', '4px solid black')
				}

				if(response.border=='yes' && response.border_color) {
					var border_color = response.border_color;
					var rgbColor = 'rgb(' + parseInt(border_color.slice(-6, -4), 16) + ',' + parseInt(border_color.slice(-4, -2), 16) + ',' + parseInt(border_color.slice(-2), 16) +  ')';
					$('.kaleidoscope-slider').css('border', '4px solid '+ rgbColor)
				}

				$('.kaleidoscope-slider .kaleidoscope-slide img').css('object-fit', response.image_fit)  
			}
		});
	});

// End of the closure.
 
})( jQuery );
