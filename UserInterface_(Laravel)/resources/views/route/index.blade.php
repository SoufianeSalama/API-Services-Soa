@extends('layouts.master')
@section('title', 'Route')
@section('inhoud')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Route</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div style="width: 100%; height: 480px" id="mapContainer"></div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var platform = new H.service.Platform({
            'app_id': 'oSsODJwa07j3aRlglwdm',
            'app_code': 'Tfy6aNzAEfkDkXx79SAaRQ'
        });
        var maptypes = platform.createDefaultLayers();
        var map = new H.Map(
            document.getElementById('mapContainer'),
            maptypes.normal.map,
            {
                zoom: 13,
                center: { lng: 5.392200, lat: 50.925823 } //uhasselt
            });
        var ui = H.ui.UI.createDefault(map, maptypes, 'nl-NL');
        var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
        var objRoutingParameters={};
        getRecords();
        var records;
        function getRecords(){
            var API = "http://soacloud-userinterface.us-east-1.elasticbeanstalk.com"
            var apiURL = API + "/recordsapi/";

            $.get(apiURL, function(data, status){
                records = jQuery.parseJSON(data);

                index = "";
                value = "";
                coordinaten = "";
                objRoutingParameters["mode"] = "fastest;car";
                coordStartEindpunt = "geo!50.925823,5.392200" // Uhasselt
                objRoutingParameters["waypoint0"] = coordStartEindpunt;
                for(i=1;i<=records.length;i++){
                    index = "waypoint" + (i);
                    value = "geo!" + records[i-1]["sClientaddress"];
                    objRoutingParameters[index] = value;
                }
                index = "waypoint" + (i);
                objRoutingParameters[index] = coordStartEindpunt;
                objRoutingParameters["representation"] = "display";
                console.log(objRoutingParameters);

                // Get an instance of the routing service:
                var router = platform.getRoutingService();

                // Call calculateRoute() with the routing parameters,
                // the callback and an error callback function (called if a
                // communication error occurs):
                router.calculateRoute(objRoutingParameters, onResult,
                    function(error) {
                        alert(error.message);
                    });


            }).fail(function() {
                records = {};
                alert('Verbindings problemen met de server');
            });
            return records;
        }

        var onResult = function(result) {
            var route,
                routeShape,
                startPoint,
                endPoint,
                linestring;
            if(result.response.route) {
                // Pick the first route from the response:
                route = result.response.route[0];
                // Pick the route's shape:
                routeShape = route.shape;

                // Create a linestring to use as a point source for the route line
                linestring = new H.geo.LineString();

                // Push all the points in the shape into the linestring:
                routeShape.forEach(function(point) {
                    var parts = point.split(',');
                    linestring.pushLatLngAlt(parts[0], parts[1]);
                });

                // Retrieve the mapped positions of the requested waypoints:
                startPoint = route.waypoint[0].mappedPosition;
                endPoint = route.waypoint[1].mappedPosition;

                // Create a polyline to display the route:
                routeLine = new H.map.Polyline(linestring, {
                    style: { lineWidth: 10 },
                    arrows: { fillColor: 'white', frequency: 2, width: 0.8, length: 0.7 }
                });

                var markerList=[];
                var startAddressIcon = new H.map.Icon('img/UHasselt_logo.png', {size: {w: 50, h: 35}});
                markerList.push(new H.map.Marker({
                    lat: '50.925823',
                    lng: '5.392200'
                }, { icon: startAddressIcon }));

                for(i=0;i<records.length;i++){
                    var coordinaten = records[i]["sClientaddress"].split(',');
                    console.log(coordinaten);
                    markerList.push(new H.map.Marker({
                        lat: coordinaten[0],
                        lng: coordinaten[1]
                    }));
                }

                /*// Create a marker for the start point:
                var startMarker = new H.map.Marker({
                    lat: startPoint.latitude,
                    lng: startPoint.longitude
                });

                // Create a marker for the end point:
                var endMarker = new H.map.Marker({
                    lat: endPoint.latitude,
                    lng: endPoint.longitude
                });*/

                // Add the route polyline and the two markers to the map:
                markerList.push(routeLine);
                //console.log(markerList);
                //map.addObjects([startMarker, endMarker, routeLine ]);
                map.addObjects(markerList);

                // Set the map's viewport to make the whole route visible:
                map.setViewBounds(routeLine.getBounds());
                getLocation();
            }
        };

        function getLocation(){
            //https://www.w3schools.com/html/html5_geolocation.asp
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPositionoOnMap);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPositionoOnMap(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;

            var driverIcon = new H.map.Icon('img/UHasselt_logo.png', {size: {w: 50, h: 35}});
            var driverMarker = new H.map.Marker({
                lat: position.coords.latitude,
                lng: position.coords.longitude
            }, { icon: driverIcon });
            map.addObjects(driverMarker);
        }







    </script>
<@stop
