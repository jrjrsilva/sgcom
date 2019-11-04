@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Painel de CVLI</h1>
    <p>{{$cvlis}}</p>
@stop

@section('content')
        <div class="container-fluid" style="width:100%; height:800px;">
                <div class="content" id="map" style="width:100%; height:100%; border: solid 1px;">

                    </div>
        </div>
@stop

@section('js')

<script>
function getJSONMarkers() {
          const markers = [
            {title:"15ª CIPM",
              name:  "Rixos The Palm",
              location: [25.1212, 55.1535]
            },
            {title:"15ª CIPM",
              name: "Shangri-La Hotel",
              location: [25.2084, 55.2719]
            },
            {
              title:"15ª CIPM",
              name: "Rua Aristídes Milton - Itapuã",
              location: [-12.949724, -38.365158]
            }
          
          ];
          return markers;
        }

  function initMap() { // The location of Uluru
  var uluru = {lat: -12.991010, lng: -38.466069};
   
  // The map, centered at Uluru
  var map = new google.maps.Map(
    document.getElementById('map'), {zoom: 12, center: uluru});

    const hotelMarkers = getJSONMarkers();

  // The marker, positioned at Uluru
 // var marker = new google.maps.Marker({position: uluru, map: map});

    // Initialize Google Markers
    for(hotel of hotelMarkers) {
            let marker = new google.maps.Marker({
              map: map,
              position: new google.maps.LatLng(hotel.location[0], hotel.location[1]),
              title: hotel.name
            })
          }
}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script async defer
  src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap">
    </script>


@stop