@extends('adminlte::page')

@section('title', 'SGCOM')

@section('content_header')
    <h1>Painel de CVLI</h1>
@stop

@section('content')
        <div class="container-fluid" style="width:100%; height:800px;">
                <div class="content" id="map" style="width:100%; height:100%; border: solid 1px;">
                </div>
        </div>
@stop

@section('js')

<script type="text/javascript" src="/js/jquery-ui.custom.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}"></script>
<script type="text/javascript" src="/js/mapa_pontos.js"></script>
<script type="text/javascript" src="/js/infobox.js"></script>
<script type="text/javascript" src="/js/markerclusterer.js"></script>

@stop