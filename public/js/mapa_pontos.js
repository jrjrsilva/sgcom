var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];

function initialize() {
    var latlng = new google.maps.LatLng(-13.849313, -38.8866439);
    var options = {
        zoom: 5,
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
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(
                            ponto.lat,
                            ponto.lng),
                    title: ponto.name,
                   // icon: '../images/marcador.png'
                });
                var myOptions = {
                    content: ponto.name,
                    pixelOffset: new google.maps.Size(-150, 0)
                };
                infoBox[ponto.id] = new InfoBox(myOptions);
                infoBox[ponto.id].marker = marker;
                infoBox[ponto.id].listener = google.maps.event.addListener(marker, 'click', function (e) {
                    abrirInfoBox(ponto.id, marker);
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