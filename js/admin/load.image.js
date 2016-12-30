 
/* Загрузка изображении с полем описания */
function multiImageDescription(input){
    if (input.files && input.files[0]) {   

        $(input.files).each(function(i) { 
            var fileExtension = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            var fileType = this["type"];
            var fileName = this["name"];
            var fileSize = parseInt(this["size"]) / 1000;
            var content = $('#multi-image');

            if (jQuery.inArray(fileType, fileExtension) == -1) {
                alert('Error file extension');
                return;
            } 

            var reader = new FileReader();
            reader.readAsDataURL(this);

            reader.onload = function(e) { 
                content.show();   

                var dscp = parseInt($('#multi-image tbody tr').length); 
 
                    var open_lang = $('#change-content').find('.active').attr('data-lang');
                   
                    var textarea = "";
                    for (var i = _LANG.length - 1; i >= 0; i--) {
                        var none = _LANG[i] == open_lang ? 'display:block;' : 'display:none;';
                        textarea += '<textarea style="height:100px; '+none+'" class="lang-area form-control" id="field_'+_LANG[i]+'" name="mini_description['+_LANG[i]+']['+parseInt(dscp)+']" class="form-control" id="dscp" rows="3"></textarea>';               
                    };

                    var row = '<tr>'+
                                    '<td>'+
                                       '<a href="'+reader.result+'" class="fancybox-button" data-rel="fancybox-button">'+
                                       '<img class="img-responsive" src="'+reader.result+'" alt="">'+
                                       '<input type="hidden" id="hidden_related" name="multi_image[]" value="'+reader.result+'">'+
                                       '</a>'+
                                    '</td>'+
                                    '<td>'+ 
                                    textarea+
                                    '</td>'+  
                                    '<td>'+
                                        '<a href="javascript:;" onclick="deleteLoadItem(this)" class="btn default btn-sm">'+
                                        '<i class="fa fa-times"></i> Delete </a> '+
                                    '</td>'+
                                 '</tr>';

                $("#multi-image tbody").append(row); 
                i++;
            }  

            $('.clear-multi').click(function(e){ 
                e.preventDefault();  
                $(input).val(null);
                $("#multi-image tbody tr").remove();
                $('#multi-image').hide(); 
            }); 
             
        });
    } 
}



 
/* Загрузка системы уведомления */
 

function addNotifications(item){
    
    var content = $('#put-wrapper'); 
 
    lang = [];
    $.each(langs, function(key,value) {
        lang.push(value); 
    }); 
  
    $(content).show(); 
 
    var dscp  = parseInt($('#put-wrapper tbody tr').length);  
    var ck    = parseInt($('.ckeditor').length);  
     
    var open_lang = $('#change-content').find('.active').attr('data-lang'); 

    var textarea = ""; 
    for (var i = 0; i < lang.length; i++) {
        var ck_num = i+1;
        var ck_id = 'ckeditor_'+ (ck+ck_num); 
        var none = lang[i] == open_lang ? 'display:block;' : 'display:none;'; 
        textarea += '<div class="lang-area field_'+lang[i]+'" style="'+none+'"><textarea style="height:100px;" class="form-control ckeditor" id="'+ck_id+'" name="notify_text['+lang[i]+']['+parseInt(dscp)+']" class="form-control" rows="3"></textarea></div>';               
   
    };

    var select = ''; 
    $.each(notificationsStatus, function(key,value) {
         select += '<option value="'+value.id+'">'+value.name+'</option>'
    });

    var selectStatus = "<select name='notify_status["+parseInt(dscp)+"]' class='form-control'>"+select+"</select>";
 
    var row = '<tr>'+ 
                    '<td>'+ 
                    textarea+
                    '</td>'+ 
                     '<td>'+ 
                    '<div class="input-group input-medium date c-picker" data-date-format="dd.mm.yyyy" data-date="" data-date-viewmode="years">'+
                      '<input type="text" class="form-control" name="notify_date['+parseInt(dscp)+']" value="" readonly>'+
                      '<span class="input-group-btn">'+
                      '<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>'+
                      '</span>'+
                    '</div> '+
                    '</td>'+ 
                     '<td>'+ 
                    selectStatus+
                    '</td>'+  
                    '<td>'+
                        '<a href="javascript:;" onclick="deleteLoadItem(this)" class="btn default btn-sm">'+
                        '<i class="fa fa-times"></i> Delete </a> '+
                    '</td>'+
                 '</tr>';

    $("#put-wrapper tbody").append(row); 

    $('.c-picker').datepicker({
        rtl: Metronic.isRTL(),
        orientation: "left",
        dateFormat: 'dd.mm.yyyy',
        autoclose: true,
        startDate: startDateNotify,
        endDate: endDateNotify, 
        language: 'ru-RU' 
    });  
    for (var i = 1; i <= 2; i++) { 
        var ck_id = 'ckeditor_'+ (ck+i);  
        CKEDITOR.replace(ck_id, {});  
    };
      
} 


/* Load Question Content */
function addChoice(item){
    var content = $('#put-wrapper'); 
    $('#multiple_choice').find('#put-wrapper').show();  
    lang = [];
    $.each(langs, function(key,value) {
        lang.push(value); 
    }); 
  
     
    var dscp  = parseInt($('#put-wrapper tbody tr').length); 
    var open_lang = $('#change-content').find('.active').attr('data-lang'); 

    var input = ""; 
    for (var i = 0; i < lang.length; i++) { 
        var none = lang[i] == open_lang ? 'display:block;' : 'display:none;'; 
        input += '<div class="lang-area field_'+lang[i]+'" style="'+none+'">'+  
                     '<input type="text" class="form-control" value="" name="choice['+lang[i]+']['+parseInt(dscp)+']">'+ 
                 '</div> ';  
    };


    var row = '<tr>'+ 
                    '<td>'+ 
                    input+
                    '</td>'+  
                    '<td>'+
                        '<a href="javascript:;" onclick="deleteLoadItem(this)" class="btn default btn-sm">'+
                        '<i class="fa fa-times"></i> Delete </a> '+
                    '</td>'+
                 '</tr>';
 

    $("#put-wrapper tbody").append(row); 
}
 
function cons(data){
    console.log(data);
}
 

/* Загрузка акции */
function multiActionContent(input){
    if (input.files && input.files[0]) {   

        $(input.files).each(function(i) { 
            var fileExtension = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            var fileType = this["type"];
            var fileName = this["name"];
            var fileSize = parseInt(this["size"]) / 1000;
            var content = $('#multi-action');

            if (jQuery.inArray(fileType, fileExtension) == -1) {
                alert('Error file extension');
                return;
            } 

            var reader = new FileReader();
            reader.readAsDataURL(this);

            reader.onload = function(e) { 
                content.show();   

                var dscp = parseInt($('#multi-action tbody tr').length); 

                  
                    var open_lang = $('#change-content').find('.active').attr('data-lang');
                   
                    var textarea = ""; 
                    for (var i = _LANG.length - 1; i >= 0; i--) {
                        var none = _LANG[i] == open_lang ? 'display:block;' : 'display:none;';
                        textarea += '<textarea style="height:100px; '+none+'" class="lang-area form-control" id="field_'+_LANG[i]+'" name="action_description['+_LANG[i]+']['+parseInt(dscp)+']" class="form-control" id="dscp" rows="3"></textarea>';               
                    };

                    var row = '<tr>'+
                                    '<td>'+
                                       '<a href="'+reader.result+'" class="fancybox-button" data-rel="fancybox-button">'+
                                       '<img class="img-responsive" src="'+reader.result+'" alt="">'+
                                       '<input type="hidden" id="hidden_related" name="action_image[]" value="'+reader.result+'">'+
                                       '</a>'+
                                    '</td>'+
                                    '<td>'+ 
                                    textarea+
                                    '</td>'+ 
                                     '<td>'+ 
                                    '<div class="input-group input-large a-picker input-daterange" data-date-format="dd.mm.yyyy">'+
                                      '<input type="text" class="form-control" name="action_date_from['+dscp+']">'+
                                      '<span class="input-group-addon">'+
                                      'по </span>'+
                                      '<input type="text" class="form-control" name="action_date_to['+dscp+']">'+
                                    '</div> '+
                                    '</td>'+  
                                    '<td>'+
                                        '<a href="javascript:;" onclick="deleteLoadItem(this)" class="btn default btn-sm">'+
                                        '<i class="fa fa-times"></i> Delete </a> '+
                                    '</td>'+
                                 '</tr>';

                $("#multi-action tbody").append(row); 

                $('.a-picker').datepicker({
                    rtl: Metronic.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    weekStart: 1,
                    language: 'en-EN' 
                });

                i++;
            }  
  
        });
    } 
}   
 
function deleteLoadItem(item){
    var hideBlock = false;
    if ($(item).closest('tbody').find('tr').length == 1) {
        $(item).closest('table').hide();
    }

    $(item).closest('tr').remove();
}

var loader = '<div class="loader-inner ball-pulse">'+
                          '<div></div>'+
                          '<div></div>'+
                          '<div></div>'+
                        '</div>'; 

$('button.start-load').click(function(e){ 
    e.preventDefault();
    var button_txt = $('button.start-load').text(); 
    var button_width = $('button.start-load').width();
    $('button.start-load').html(loader);  
    $('button.start-load').width(button_width);
    setTimeout(function(){
        xlsLoad(button_txt);
    }, 1000); 
});

 
function xlsLoad(button_txt){   
    var form = $('form.onsubmit')[0]; 
   
    $.ajax({
        url: '/cp/loadEmailFile/',
        type: 'POST',
        async: true,
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {},
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 401) document.location.reload(true);
        },
        success: function(res, textStatus, request) {
            if (res.msg === 'error') {
                alert(res.cause);
            } else { 
                var id = $('textarea[name="emails"]').val(res.emails); 
                if (res.existing) {
                    $('.existing_emails').show();
                    $('.existing_emails p').html(res.existing);
                }else{
                    $('.existing_emails').hide();
                    $('.existing_emails p').html('');
                }
                $('input[name="file_characteristics"]').val(null);
            }
        },
        complete: function() {
            $('button.start-load').text(button_txt);
        }
    }); 
 
}   
 