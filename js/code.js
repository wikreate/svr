$(document).ready(function(e) {
	/* Инициализация */
	var winObj = $(window);

	/* menu */
	$('.m_ctrl').on('click', function() {
		$('.fog').show().animate({opacity:1}, 300);
	});
	$('.menu_wr').on('click', '.close', function() {
		$('.fog').animate({opacity:0}, 300, function() {
			$(this).hide();
		});
	});

	/* Языки */
	$('.lang_vis').on('click', function() {
		$(this).siblings('.lang_content').slideToggle(300);
	});

	/* open-close */
	$('.tab_content dl').on('click', 'dt', function() {
		if($(this).parent().children('dd').is(':visible')) {
			$(this).parent().removeClass('open');
			$(this).parent().children('dd').slideUp(300);
		}
		else {
			$(this).parent().addClass('open');
			$(this).parent().children('.dd').slideDown(300);
		}
	});

	$('.check_tab').click(function(){
        var space = $(this).attr('data-space');
		$('span[data-space="'+space+'"]').removeClass('active'); 
		$(this).addClass('active');
		$(this).find('input[type="radio"]').prop('checked', true);
		submitSurvey();
	});

	/* tabs */
	// $('.tabs').on('click', 'span', function() {
	// 	$(this).siblings('.active').removeClass();
	// 	$(this).addClass('active');
	// 	temp = $(this).index();
	// 	$('.tab_item:visible').stop().animate({opacity:0}, 300, function() {
	// 		$(this).hide();
	// 		$('.tab_content').children('.tab_item').eq(temp).show().stop().animate({opacity:1}, 300);
	// 	});
	// });
	//$('.tab_item').eq(0).show().css({"opacity" : "1"});

	/* popup */
	$('.trig_popup').on('click', function() {
		$('.fog').show().animate({opacity:1}, 300);
		$('.popup').show().animate({opacity:1}, 300);
	});
	$('.popup').on('click', '.close', function() {
		$('.fog').animate({opacity:0}, 300, function() {
			$(this).hide();
		});
		$('.popup').animate({opacity:0}, 300, function() {
			$(this).hide();
		});
	});


	$('form.onsubmit').on('submit', (function(e) {
        e.preventDefault();
        var form = $(this);
        var button = $(form).find('button#submit-btn');
        var button_width = $(button).width();
        var button_height = $(button).height();
        var data_bg = $(button).attr('data-bg') ? 'style="background:' + $(button).attr('data-bg') + '"' : '';
        var button_txt = $(button).text();
        var loader = '<div class="loader-inner ball-pulse">' +
            '<div ' + data_bg + '></div>' +
            '<div ' + data_bg + '></div>' +
            '<div ' + data_bg + '></div>' +
            '</div>';
        $(button).html(loader);
        $(button).width(button_width);
        $(button).height(button_height);

        setTimeout(function() {
            onsubmit(form, button, button_txt);
        }, 1000);
    }));  

    submitByChange('input');
    submitByChange('textarea');

    function submitByChange(item){
        $('.survey_form').find(item).change(function(){
            submitSurvey();
        });
    }

    function submitSurvey(){
        $('.survey_form').submit();
    }
    
    var confirmIcon = '<i class="fa fa-check" aria-hidden="true"></i>';
    var dangerIcon  = '<i class="fa fa-exclamation" aria-hidden="true"></i>';

    function onsubmit(form, button, button_txt) {

        var url = $(form).attr('action');
        var redirect = $(form).attr('data-redirect');

        $.ajax({
            url: url,
            type: 'POST',
            async: true,
            data: new FormData(form[0]),
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {},
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                if (XMLHttpRequest.status === 401) document.location.reload(true);
            },
            success: function(res, textStatus, request) {
                
                if (res.onlyStatus) {
                    if (res.check) {
                    	console.log('true');
                        $('#status').removeClass('dangerChapter').addClass('confirmChapter');
                        $('#status').html(confirmIcon);
                    }else{
                    	console.log('false');
                        $('#status').removeClass('confirmChapter').addClass('dangerChapter');
                        $('#status').html(dangerIcon);
                    }
                }else{
                    if (res.msg === 'error') {
                        $(form).find('#error-respond').fadeIn().html(res.cause);
                        setTimeout(function() {
                            $(form).find('#form-respond').fadeOut(700);
                        }, 1000);
     
                    } else {

                        redirect = !res.redirect ? redirect : res.redirect;

                        if (redirect) { 
                            function replace_page() {
                                window.location=redirect;
                            }
                            setTimeout(replace_page, 500);
                        } else {
                            $('.fog').hide();
                            $('.popup').hide();
                            $('.fog2').hide();
                            $(form).find('#error-respond').hide();
                            $('#success-respond').fadeIn(500).html(res.msg);

                            setTimeout(function() {
                                $('#success-respond').fadeOut(500);
                            }, 4000);

                            $(form).find('input').attr('style', '');
                            $(form)[0].reset();
                        }  
                    }
                }
                 
            },
            complete: function() {
                $(button).css({
                    'padding-left': '0',
                    'padding-right': '0'
                });
                $(button).text(button_txt);
            }
        });
    }

});