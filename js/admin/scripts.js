$(document).ready(function() {
    var sitename = $.url('protocol') + '://' + $.url('hostname') + '/';

    function active_link(uhref) {
        var url = location.href.replace(/\/$/, '');  
        $(uhref).each(function() {
            var href = $(this).attr("href"); 
            if (href == url.replace(/\/$/, '')) {

                $(this).closest('li').addClass('active');
                $(uhref).not($(this).closest('li')).removeClass('active');
            }
        });
    }
    active_link('ul.sb_menu li a');

    $('#toggle-form').click(function(event){
        event.preventDefault();
        $('#content-add').slideToggle(100); 
    });

    $("#add_post").click(function(e) {
    $(".taggle_win:visible").fadeOut(200);
    $(".taggle_win:hidden").fadeIn(200);

    if ($('[data-map="multi"]').length>0) {
      initMap();
    }  
     
    if ($('[data-map="unique"]').length>0) {
      uniqueMap();
    } 

    if ($(this).find('.fa-plus').length > 0) {
      $(this).find('.fa-plus').addClass("fa-minus").removeClass("fa-plus");
    } else {
      $(this).find('.fa-minus').addClass("fa-plus").removeClass("fa-minus");
    }
    });
  
    $('#change-content a').click(function(){
        $('#change-content a').removeClass('active');
        $(this).addClass('active'); 
        var lang = $(this).attr('data-lang'); 
        //$('form').find('.lang-area').hide(); 
        $('form').find('.lang-area').each(function(){ 
            if ($(this).hasClass('field_'+lang)) {
              $(this).show();   
            } else{
              $(this).hide();
            }
        });  
    }); 
    $('#change-content a:first-child').click();
  
 });

  function getCenterPosition(tempdata){
    if (!tempdata) {return false} 
    var string='';
    result = jQuery.parseJSON(tempdata);
    $(result).each(function(){
      string+=string+this.coordonate+'|';
    });
    coords=string;

    var filteredtextCoordinatesArray = coords.split('|');    

    centerLatArray = [];
    centerLngArray = [];


    for (i=0 ; i < filteredtextCoordinatesArray.length ; i++) {

      var centerCoords = filteredtextCoordinatesArray[i]; 
      var centerCoordsArray = centerCoords.split(',');

      if (isNaN(Number(centerCoordsArray[0]))) {      
      } else {
        centerLatArray.push(Number(centerCoordsArray[0]));
      }

      if (isNaN(Number(centerCoordsArray[1]))) {
      } else {
        centerLngArray.push(Number(centerCoordsArray[1]));
      }                    

    }

    var centerLatSum = centerLatArray.reduce(function(a, b) { return a + b; });
    var centerLngSum = centerLngArray.reduce(function(a, b) { return a + b; });

    var centerLat = centerLatSum / filteredtextCoordinatesArray.length ; 
    var centerLng = centerLngSum / filteredtextCoordinatesArray.length ;                                    
 
    return [centerLat, centerLng];
  }

  var currentId = 0;
  var uniqueId = function() {
      return ++currentId;
  } 
 

  function addMarker(location) {  
      var data_icon = $('#coords').attr('data-icon');  
      var marker = new google.maps.Marker({
           position: location, 
           map: map,  
           zIndex: 999,
           animation: google.maps.Animation.DROP 
      });//добавление маркера

      marker.id = uniqueId();   
      markers.push(marker); 
      coordonates.push(location);

      google.maps.event.addListener(marker, "rightclick", function (e) { 
          var content = 'Вы хотите удалить метку?';
          content += "<br /><input type = 'button' value = 'Удалить' onclick = 'deleteOneMarker("+marker.id+");'/>";
          var infoWindow = new google.maps.InfoWindow({
              content: content
          });
          infoWindow.open(map, marker);
      }); 

      $('input#coords').val(JSON.stringify(coordonates)); 
      $('.delete_markers').show();
  }

  function addUniqueMarker(location) {  
       deleteMarkers();
       $('input#coords').attr('value', location);
       var marker = new google.maps.Marker({
           position: location,
           map: map,  
           zIndex: 999
       });//добавление маркера

       markers.push(marker); 
  }

  function setLocationTown(coordonate){
       var splitCoord = coordonate.split(',');  
       map.setZoom(12);
       map.setCenter({lat: parseFloat(splitCoord[0]), lng: parseFloat(splitCoord[1])}); 
  }

  function clearMarkers() {
    setMapOnAll(null);
  }

  function deleteOneMarker(id) {
    //Find and remove the marker from the Array
    for (var i = 0; i < markers.length; i++) {
        if (markers[i].id == id) {
            //Remove the marker from Map                  
            markers[i].setMap(null); 
 
            //Remove the marker from array.
            markers.splice(i, 1);
            coordonates.splice(i, 1);
            $('input#coords').val(JSON.stringify(coordonates)); 
            return;
        }
    }   
  }  

   function deleteMarkers() {
     clearMarkers();
     markers = [];
     coordonates=[];
     $('.delete_markers').hide();
     $('input#coords').val(null);
   }

   function setMapOnAll(map) {
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(map);
     }
   }

  var map; 
  var markers=[]; 
  function uniqueMap() {  
    var data_lat = $('#map').attr('data-lat');
    var data_long = $('#map').attr('data-long');

    if (data_lat && data_long ) { 
       var myLatLng = {lat: parseFloat(data_lat), lng: parseFloat(data_long)};

       map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: myLatLng
       });

       var marker = new google.maps.Marker({
          position: myLatLng,
          map: map 
       }); 

       markers.push(marker); 
    }else{
      var myLatLng = {lat: 47.01274217933916, lng: 28.80632534623146};

      map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: myLatLng
       });
    }  

    google.maps.event.addListener(map, 'click', function (event) {  
        addUniqueMarker(event.latLng);
    });//добавляем событие нажание мышки
  }

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}