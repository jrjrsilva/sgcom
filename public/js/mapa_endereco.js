var geocoder;
var map;
var marker;

function initialize() {
    var latlng = new google.maps.LatLng(-12.991010, -38.466069);
    var options = {
        zoom: 5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            map.setCenter(latlng);
            map.setZoom(15);
            marker.setPosition(latlng);
        });
    }

    map = new google.maps.Map(document.getElementById("map"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
    });

    marker.setPosition(null);
}

$(document).ready(function () {

    initialize();

    function carregarNoMapa(endereco) {
        geocoder.geocode({'address': endereco}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    $('#pesquisar').val(results[0].formatted_address);
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);

                    for (i = 0; i < 10; i++) {
                        switch (results[0].address_components[i].types[0]) {
                            case "street_number":
                                $('#numero').val(results[0].address_components[i].long_name);
                                break;
                            case "route":
                                $('#logradouro').val(results[0].address_components[i].long_name);
                                break;
                            case "political":
                                $('#bairro').val(results[0].address_components[i].long_name);
                                break;
                            case "administrative_area_level_2":
                                $('#municipio').val(results[0].address_components[i].long_name);
                                break;
                            case "administrative_area_level_1":
                                $('#estado').val(results[0].address_components[i].long_name);
                                break;
                            case "country":
                                $('#pais').val(results[0].address_components[i].long_name);
                                break;
                            case "postal_code":
                                $('#cep').val(results[0].address_components[i].long_name);
                                break;
                        }
                    }

                    var location = new google.maps.LatLng(latitude, longitude);
                    marker.setPosition(location);
                    map.setCenter(location);
                    map.setZoom(16);
                }
            }
        });
    }

    $("#btnEndereco").click(function () {
        if ($(this).val() != "")
            $("#campos-endereco").show();
        $("#numero").focus();
        carregarNoMapa($("#pesquisar").val());
    });

    $("#pesquisar").blur(function () {
        if ($(this).val() != "")
            carregarNoMapa($(this).val());
    });

    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#pesquisar').val(results[0].formatted_address);
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude ').val(marker.getPosition().lng());

                    for (i = 0; i < 10; i++) {
                        switch (results[0].address_components[i].types[0]) {
                            case "street_number":
                                $('#numero').val(results[0].address_components[i].long_name);
                                break;
                            case "route":
                                $('#logradouro').val(results[0].address_components[i].long_name);
                                break;
                            case "political":
                                $('#bairro').val(results[0].address_components[i].long_name);
                                break;
                            case "administrative_area_level_2":
                                $('#municipio').val(results[0].address_components[i].long_name);
                                break;
                            case "administrative_area_level_1":
                                $('#estado').val(results[0].address_components[i].long_name);
                                break;
                            case "country":
                                $('#pais').val(results[0].address_components[i].long_name);
                                break;
                            case "postal_code":
                                $('#cep').val(results[0].address_components[i].long_name);
                                break;
                        }
                    }
                }
            }
        });
    });

    $("#pesquisar").autocomplete({
        source: function (request, response) {
            geocoder.geocode({'address': request.term}, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        select: function (event, ui) {
            $("#latitude").val(ui.item.latitude);
            $("#longitude").val(ui.item.longitude);
            var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
            marker.setPosition(location);
            map.setCenter(location);
            map.setZoom(16);
        }
    });
});