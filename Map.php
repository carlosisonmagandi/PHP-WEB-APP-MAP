<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Place the geocoder input outside the map</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
<style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>
</head>
<body>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">

<style>
    .geocoder {
        position: absolute;
        z-index: 1;
        width: 50%;
        left: 50%;
        margin-left: -25%;
        top: 10px;
    }
    .mapboxgl-ctrl-geocoder {
        min-width: 100%;
    }
    #map {
        margin-top: 75px;
    }
    .coordinates{
        background-color:#000;
        color:#FFF;
        position:absolute;
        bottom:40px;
        left:10px;
        padding: 5px 10px;
        margin:0;
        font-size:12px;
        line-height:18px;
        display:none;
    }
</style>

<!-- added -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.js"></script>
<div id="map"></div>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.3.1/mapbox-gl-directions.css" type="text/css">
<!--  -->

<div id="geocoder" class="geocoder"></div>
<div id="coordinates" class="coordinates"></div>
<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoiY200NzcyNSIsImEiOiJjbHc4MWd4cGgxbXEzMmt0OWhqbTlvcHY4In0.bJ3Gb8OgbBs6KEw3xCSF_g';
    var lng=0;
    var lat=0;

    const map = new mapboxgl.Map({
        container: 'map',
        // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [120.9842,14.5995],
        zoom: 13
    });

    // addedCustoms
    // map.addControl(
    //     new MapboxDirections({
    //         accessToken: mapboxgl.accessToken
    //     }),
    //     'top-left'
    // );

    //map click
    map.on('click', function(e){
        console.log(e.lngLat.wrap());

        var markers =document.querySelectorAll('.mapboxgl-marker');
        markers.forEach(function(el, indx){
            el.style.display ='none';
        })

        var coordinates=document.querySelector('#coordinates');
        lng=e.lngLat.lng;
        lat=e.lngLat.lat;

        //display the coordinate div 
        coordinates.style.display='block';
        coordinates.innerHTML=`Longitude: ${lng} <br/> Latitude: ${lat}`; 

        var marker= new mapboxgl.Marker({
            draggable:true
        }).setLngLat([lng,lat]).addTo(map);

        marker.on('dragend',onDragEnd);

        function onDragEnd(){
            console.log('drag was ended');
            var lngLat= marker.getLngLat();

            lng=lngLat.lng;
            lat=lngLat.lat;
            coordinates.style.display='block';
            coordinates.innerHTML=`Longitude: ${lng} <br/> Latitude: ${lat}`; 
        }

    });

    // Add the control to the map.
    const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });

    document.getElementById('geocoder').appendChild(geocoder.onAdd(map));
</script>

</body>
</html>