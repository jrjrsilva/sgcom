var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];

function initialize() {
    var latlng = new google.maps.LatLng(-12.991010,-38.466069);
    var options = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(latlng);
            map.setZoom(14);
        });
    }

    map = new google.maps.Map(document.getElementById("map"), options);
}

$(document).ready(function () {

    initialize();
    $("#map").height($(window).height()-320);

    function abrirInfoBox(id, marker) {
        if (typeof (idInfoBoxAberto) == 'number' && typeof (infoBox[idInfoBoxAberto]) == 'object') {
            infoBox[idInfoBoxAberto].close();
        }
        infoBox[id].open(map, marker);
        idInfoBoxAberto = id;
    }

    function carregarPontos() {
        $.getJSON('/cvli/json', function (pontos) {
            var latlngbounds = new google.maps.LatLngBounds();
            $.each(pontos, function (index, ponto) {
                var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
                '<div id="bodyContent">'+
                '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
                'sandstone rock formation in the southern part of the '+
                'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
                'south west of the nearest large town, Alice Springs; 450&#160;km '+
                '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
                'features of the Uluru - Kata Tjuta National Park. Uluru is '+
                'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
                'Aboriginal people of the area. It has many springs, waterholes, '+
                'rock caves and ancient paintings. Uluru is listed as a World '+
                'Heritage Site.</p>'+
                '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
                'https://en.wikipedia.org/w/index.php?title=Uluru</a> '+
                '(last visited June 22, 2009).</p>'+
                '</div>'+
                '</div>';
    
            var infowindow = new google.maps.InfoWindow({
              content: contentString
            });
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(
                            ponto.lat,
                            ponto.lng),
                    title: ponto.name,
                    icon: '../images/marcador.png'
                });
                marker.addListener('click', function() {
                   // infowindow.open(map, marker);
                  });

                var myOptions = {
                    content: ponto.name,
                    pixelOffset: new google.maps.Size(-150, 0)
                };
                infoBox[ponto.id] = new InfoBox(myOptions);
                infoBox[ponto.id].marker = marker;
                infoBox[ponto.id].listener = google.maps.event.addListener(marker, 'click', function (e) {
                  //  abrirInfoBox(ponto.id, marker);
                  infowindow.open(map, marker);
                });
                markers.push(marker);
                latlngbounds.extend(marker.position);
            });
            var markerCluster = new MarkerClusterer(map, markers);
            map.fitBounds(latlngbounds);
        });
    }

    carregarPontos();

});