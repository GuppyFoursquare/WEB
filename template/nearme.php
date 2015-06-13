<?php include('header_start.php'); ?>
<!--===================================menu=========================================--> 
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script type='text/javascript' src="js/modernizr.custom.js"></script>

<!-- MENU END -->
<!-- script type='text/javascript' src='js/youblur.min.js'></script -->

<!--===================================top-slider=========================================-->

<link rel="stylesheet" href="css/demo.css">
<link rel="stylesheet" href="css/slippry.css">
<script type='text/javascript' src="js/slippry.js"></script>
<script src="js/foggy.min.js"></script>

<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script type="text/javascript" src="js/ContextMenu.js"></script>

<script type="text/javascript">
    /* An InfoBox is like an info window, but it displays
     * under the marker, opens quicker, and has flexible styling.
     * @param {GLatLng} latlng Point to place bar at
     * @param {Map} map The map on which to display this InfoBox.
     * @param {Object} opts Passes configuration options - content,
     *   offsetVertical, offsetHorizontal, className, height, width
     */
    function makeRequest(url, callback) {
        var request;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
            request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback(request);
            }
        }
        request.open("GET", url, true);
        request.send();
    }
   
    var newMarkers = [];
    function InfoBox(opts) {
        google.maps.OverlayView.call(this);
        this.latlng_ = opts.latlng;
        this.map_ = opts.map;
        this.offsetVertical_ = -270;
        this.offsetHorizontal_ = 7;
        this.height_ = 270;
        this.width_ = 253;
        this.content_ = opts.content;
                  
        var me = this;
        this.boundsChangedListener_ =
            google.maps.event.addListener(this.map_, "bounds_changed", function() {
            return me.panMap.apply(me);
        });

        // Once the properties of this OverlayView are initialized, set its map so
        // that we can display it.  This will trigger calls to panes_changed and
        // draw.
        this.setMap(this.map_);
    }

    /* InfoBox extends GOverlay class from the Google Maps API
     */
    InfoBox.prototype = new google.maps.OverlayView();

    /* Creates the DIV representing this InfoBox
     */
    InfoBox.prototype.remove = function() {
        if (this.div_) {
            this.div_.parentNode.removeChild(this.div_);
            this.div_ = null;
        }
    };

    /* Redraw the Bar based on the current projection and zoom level
     */
    InfoBox.prototype.draw = function() {
        // Creates the element if it doesn't exist already.
        this.createElement();
        if (!this.div_) return;
        // Calculate the DIV coordinates of two opposite corners of our bounds to
        // get the size and position of our Bar
        var pixPosition = this.getProjection().fromLatLngToDivPixel(this.latlng_);
        if (!pixPosition) return;
                  
        // Now position our DIV based on the DIV coordinates of our bounds
        this.div_.style.width = this.width_ + "px";
        this.div_.style.left = (pixPosition.x + this.offsetHorizontal_) + "px";
        this.div_.style.height = this.height_ + "px";
        this.div_.style.top = (pixPosition.y + this.offsetVertical_) + "px";
        this.div_.style.display = 'block';
    };

    /* Creates the DIV representing this InfoBox in the floatPane.  If the panes
     * object, retrieved by calling getPanes, is null, remove the element from the
     * DOM.  If the div exists, but its parent is not the floatPane, move the div
     * to the new pane.
     * Called from within draw.  Alternatively, this can be called specifically on
     * a panes_changed event.
     */
    InfoBox.prototype.createElement = function() {
        var panes = this.getPanes();
        var div = this.div_;
        if (!div) {
            // This does not handle changing panes.  You can set the map to be null and
            // then reset the map to move the div.
            var img_str = '';
            var str = this.content_;
            var result = str.split("--@--");
            if(result[0]) {
                if(result[2] != -999)
                    img_str = "<img style='width:231px;' src='<?php echo SERVER_FRONT_PATH . PLACES_MEDIUM_IMAGE_PATH; ?>"+result[0]+"' />"
                else
                    //img_str = "<img style='width:231px;' src='<?php echo IMAGE_PATH . 'no-img.jpg'; ?>' />";
                img_str = '';
            }
            else {
                img_str = "<img style='width:231px;' src='<?php echo IMAGE_PATH . 'no-img.jpg'; ?>' />";
            }
                        
            div = this.div_ = document.createElement("div");
            div.style.border = "0px none";
            div.style.position = "absolute";
            //div.style.background = "url('http://gmaps-samples.googlecode.com/svn/trunk/images/blueinfowindow.gif')";
            div.style.background = "url('images/map-bg.png') no-repeat";
            div.style.width = this.width_ + "px";
            div.style.height = this.height_ + "px";
            var contentDiv = document.createElement("div");
            contentDiv.style.padding = "70px 20px 0"
            contentDiv.innerHTML = img_str;
                    
            if(result[2] != -999)
            {
                var link_str = "<?php echo SITE_PATH . 'places/' ?>"+result[2];
            }
            else
            {
                var link_str = "javascript:void(0);";
            }
                    
            var place_name_div = document.createElement("div");
            place_name_div.style.position = "absolute";
                    
            if(result[2] != -999)
            {
                place_name_div.style.margin = "10px auto";
            }
            else
            {
                place_name_div.style.margin = "140px auto 0";
            }
                    
            place_name_div.style.font = "15px Verdana";
            place_name_div.style.color = "#fff";
            place_name_div.style.textAlign = "right";
            place_name_div.style.width = "96%";
            if(result[2] != -999)
            {
                place_name_div.innerHTML = "<a style='color:#fff' href='"+link_str+"'>"+result[1]+"</a>";
            }
            else
            {
                place_name_div.innerHTML = "<span style='color:#fff;'>"+result[1]+"</span>";
            }
                    
                    
            var topDiv = document.createElement("div");
            topDiv.style.textAlign = "right";
            topDiv.style.cssFloat = "right";
                    
            //topDiv.style.margin = "-5px 0 0 0";
            var closeImg = document.createElement("img");
            closeImg.style.width = "20px";
            closeImg.style.height = "20px";
            closeImg.style.cursor = "pointer";
            if(result[2] != -999)
            {
                closeImg.style.margin = "60px 0 0 -15px";
            }
            else
            {
                closeImg.style.margin = "190px 0 0 -15px";
            }
            closeImg.style.position = "absolute";
            closeImg.style.cssFloat = "right";
            //closeImg.src = "http://gmaps-samples.googlecode.com/svn/trunk/images/closebigger.gif";
            closeImg.src = "images/close-red.png";
            if(result[2] == -999)
            {
                closeImg.id = "-999"
            }
            topDiv.appendChild(closeImg);

            function removeInfoBox(ib) {
                return function() {
                    /*var marker2 = new google.maps.Marker({
                         position: ib.latlng_,
                         map: ib.map_,
                         icon:'images/yellow_icon.png'
                     });
                        
                     google.maps.event.addListener(marker2, "click", function(e) {
                          
                       marker2.setIcon('images/red_icon.png');
                       var infoBox = new InfoBox({content:ib.content_, latlng: ib.latlng_, map: ib.map_});
                     });*/
                        
                    $.each(newMarkers, function(index, individual_marker) {
                        individual_marker.setIcon('images/yellow_icon.png');
                    });
                    ib.setMap(null);
                        
                    newMarkers[0].setIcon('images/blue_icon.png');
                        
                };
            }

            google.maps.event.addDomListener(closeImg, 'click', removeInfoBox(this));

            div.appendChild(topDiv);
            div.appendChild(contentDiv);
            div.appendChild(place_name_div);
            div.style.display = 'none';
            panes.floatPane.appendChild(div);
            this.panMap();
        } else if (div.parentNode != panes.floatPane) {
            // The panes have changed.  Move the div.
            div.parentNode.removeChild(div);
            panes.floatPane.appendChild(div);
        } else {
            // The panes have not changed, so no need to create or move the div.
        }
    }

    /* Pan the map to fit the InfoBox.
     */
    InfoBox.prototype.panMap = function() {
        // if we go beyond map, pan map
        var map = this.map_;
        var bounds = map.getBounds();
        if (!bounds) return;

        // The position of the infowindow
        var position = this.latlng_;

        // The dimension of the infowindow
        var iwWidth = this.width_;
        var iwHeight = this.height_;

        // The offset position of the infowindow
        var iwOffsetX = this.offsetHorizontal_;
        var iwOffsetY = this.offsetVertical_;

        // Padding on the infowindow
        var padX = 40;
        var padY = 40;

        // The degrees per pixel
        var mapDiv = map.getDiv();
        var mapWidth = mapDiv.offsetWidth;
        var mapHeight = mapDiv.offsetHeight;
        var boundsSpan = bounds.toSpan();
        var longSpan = boundsSpan.lng();
        var latSpan = boundsSpan.lat();
        var degPixelX = longSpan / mapWidth;
        var degPixelY = latSpan / mapHeight;

        // The bounds of the map
        var mapWestLng = bounds.getSouthWest().lng();
        var mapEastLng = bounds.getNorthEast().lng();
        var mapNorthLat = bounds.getNorthEast().lat();
        var mapSouthLat = bounds.getSouthWest().lat();

        // The bounds of the infowindow
        var iwWestLng = position.lng() + (iwOffsetX - padX) * degPixelX;
        var iwEastLng = position.lng() + (iwOffsetX + iwWidth + padX) * degPixelX;
        var iwNorthLat = position.lat() - (iwOffsetY - padY) * degPixelY;
        var iwSouthLat = position.lat() - (iwOffsetY + iwHeight + padY) * degPixelY;

        // calculate center shift
        var shiftLng =
            (iwWestLng < mapWestLng ? mapWestLng - iwWestLng : 0) +
            (iwEastLng > mapEastLng ? mapEastLng - iwEastLng : 0);
        var shiftLat =
            (iwNorthLat > mapNorthLat ? mapNorthLat - iwNorthLat : 0) +
            (iwSouthLat < mapSouthLat ? mapSouthLat - iwSouthLat : 0);

        // The center of the map
        var center = map.getCenter();

        // The new map center
        var centerX = center.lng() - shiftLng;
        var centerY = center.lat() - shiftLat;

        // center the map to the new shifted center
        map.setCenter(new google.maps.LatLng(centerY, centerX));

        // Remove the listener after panning is complete.
        google.maps.event.removeListener(this.boundsChangedListener_);
        this.boundsChangedListener_ = null;
    };




    function initialize() {
        

    
    
<?php if (isset($_SESSION['user_id'])): ?>

        var myOptions = {
            zoom: 10,
            center: new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
         var marker1 = new google.maps.Marker({
             position: new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
             map: map,
             icon:'images/blue_icon.png'
         });
         newMarkers.push(marker1);
         google.maps.event.addListener(marker1, "click", (function(marker1, i) {
             return function() {

                 if(infoBox){
                   
                     $.each(newMarkers, function(index, individual_marker) {
                         individual_marker.setIcon('images/yellow_icon.png');
                     });
                     infoBox.setMap(null);
                    
                 }
                 marker1.setIcon('images/red_icon.png');
                 infoBox = new InfoBox({content:"test"+"--@--"+"Your Location"+"--@--"+"-999", latlng: marker1.getPosition(), map: map});
                 //infoBox.open(map, marker);

             }
         })(marker1, i));
        
         var rectangle1 = new google.maps.Rectangle({
             map:map,
             bounds:new google.maps.LatLngBounds(
             new google.maps.LatLng(<?php echo $latitude - 0.009; ?>,<?php echo $longitude - 0.015; ?>),
             new google.maps.LatLng(<?php echo $latitude + 0.009; ?>,<?php echo $longitude + 0.015; ?>)
         ),
             strokeColor: '#9AA0FF',
             strokeOpacity: 0.8,
             strokeWeight: 2,
             fillColor: '#9AA0FF',
             fillOpacity: 0.35

             //center:new google.maps.LatLng(locations[i][1],locations[i][2]),
             //fillColor: "#fdd",
             //fillOpacity: "0.25",
             //strokeColor:"#fff",
             // strokeWeight:"2"
         });
        
         var circle4 = [], circle5 = [];
        
         locations = $.parseJSON('<?php echo $lat_long_array; ?>');
         //alert(locations);
         var circle1 = new google.maps.Circle({
             map:map,
             radius:100,
             center:new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
             //fillColor: "#ccc",
             fillOpacity: "0.25",
             strokeColor:"#fff",
             strokeWeight:"2"
         });
        
        
         var circle2 = new google.maps.Circle({
             map:map,
             radius:500,
             center:new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
             //fillColor: "#ccc",
             fillOpacity: "0.25",
             strokeColor:"#fff",
             strokeWeight:"2"
         });
        
         var circle3 = new google.maps.Circle({
             map:map,
             radius:800,
             center:new google.maps.LatLng(<?php echo $latitude; ?>,<?php echo $longitude; ?>),
             fillColor: "#fdd",
             fillOpacity: "0.25",
             strokeColor:"#fff",
             strokeWeight:"2"
         });
        
         google.maps.event.addListener(map, 'zoom_changed', function() {
             zoomLevel = map.getZoom();
             if(zoomLevel >= 11)
             {
                 var multiplier = (22-zoomLevel)/10;
                 rectangle1.setMap(null);  
                 for (var i = 0; i < locations.length; i++) {
                     circle5[i].setRadius(multiplier*300);
                     circle4[i].setRadius(multiplier*150);
                 }
                
                 circle3.setRadius(multiplier*300);
                 circle2.setRadius(multiplier*150);
                 circle1.setRadius(multiplier*80);
                
                
                 if(zoomLevel >= 15)
                 {
                     var multiplier = (22-zoomLevel)/10;
                     for (var i = 0; i < locations.length; i++) {
                         circle5[i].setRadius(multiplier*40);
                         circle4[i].setRadius(multiplier*25);
                     }
                    
                     circle3.setRadius(multiplier*40);
                     circle2.setRadius(multiplier*25);
                     circle1.setRadius(multiplier*15);
                    
                      
                    
                     if(zoomLevel >= 17)
                     {
                         var multiplier = (22-zoomLevel)/10;
                         for (var i = 0; i < locations.length; i++) {
                             circle5[i].setRadius(multiplier*20);
                             circle4[i].setRadius(multiplier*10);
                         }
                        
                         circle3.setRadius(multiplier*20);
                         circle2.setRadius(multiplier*10);
                         circle1.setRadius(multiplier*5);
                     }
                 }
             }
             else if(zoomLevel <= 10)
             {
                 var multiplier = (22-zoomLevel)/10;
                 rectangle1.setMap(map);
                 rectangle1.setBounds(
                 new google.maps.LatLngBounds(
                 new google.maps.LatLng(<?php echo $latitude - 0.009; ?>,<?php echo $longitude - 0.015; ?>),
                 new google.maps.LatLng(<?php echo $latitude + 0.009; ?>,<?php echo $longitude + 0.015; ?>)
             )
             );
                 circle3.setRadius((multiplier+1)*1000);
                 circle2.setRadius((multiplier+1)*600);
                 circle1.setRadius((multiplier+1)*500);
                
                 if(zoomLevel == 10)
                 {
                     circle3.setRadius(800);
                     circle2.setRadius(500);
                     circle1.setRadius(100);
                    
                 }
                
             }
         });
        
        
         /*google.maps.event.addListener(marker1, "click", function(e) {
       if(infoBox){

         infoBox.setMap(null);

      }
       marker1.setIcon('images/red_icon.png');
       var infoBox = new InfoBox({latlng: marker1.getPosition(), map: map});
     });*/
         //google.maps.event.trigger(marker, "click");
        
        
        
         var infoBox = null;
         for (var i = 0; i < locations.length; i++) {
             datatext = locations[i][0];
            
             marker = new google.maps.Marker({
                 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                 map: map,
                 title: datatext,
                 icon:'images/yellow_icon.png'
             });
            
             circle4[i] = new google.maps.Circle({
                 map:map,
                 radius:500,
                 center:new google.maps.LatLng(locations[i][1],locations[i][2]),
                 fillColor: "#fdd",
                 fillOpacity: "0.25",
                 strokeColor:"#fff",
                 strokeWeight:"2"
             });

             circle5[i] = new google.maps.Circle({
                 map:map,
                 radius:800,
                 center:new google.maps.LatLng(locations[i][1],locations[i][2]),
                 fillColor: "#fdd",
                 fillOpacity: "0.25",
                 strokeColor:"#fff",
                 strokeWeight:"2"
             });
            
             newMarkers.push(marker);
             google.maps.event.addListener(marker, "click", (function(marker, i) {
                 return function() {
                
                     if(infoBox){
                   
                         $.each(newMarkers, function(index, individual_marker) {
                             individual_marker.setIcon('images/yellow_icon.png');
                         });
                         infoBox.setMap(null);
                         newMarkers[0].setIcon('images/blue_icon.png');
                     }
                     marker.setIcon('images/red_icon.png');
                     infoBox = new InfoBox({content:locations[i][3]+"--@--"+locations[i][0]+"--@--"+locations[i][5], latlng: marker.getPosition(), map: map});
                     //infoBox.open(map, marker);
                
                 }
             })(marker, i));
            
            
         }
        
<?php else: ?>
             if(navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(function(position) {
                     var pos = new google.maps.LatLng(position.coords.latitude,
                     position.coords.longitude);

                     var login_lat = position.coords.latitude;
                     var login_long = position.coords.longitude;
              
                     var myOptions = {
                        zoom: 10,
                        center: new google.maps.LatLng(login_lat,login_long),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }
                    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        
        
                     makeRequest('getLocations.php?lat='+login_lat+'&long='+login_long, function(data) {
            
                         locations = JSON.parse(data.responseText);
                         //alert(locations);
            
                         var marker1 = new google.maps.Marker({
                             position: pos,
                             map: map,
                             icon:'images/blue_icon.png'
                         });
                         var i;
                         newMarkers.push(marker1);
                         google.maps.event.addListener(marker1, "click", (function(marker1, i) {
                             return function() {

                                 if(infoBox){

                                     $.each(newMarkers, function(index, individual_marker) {
                                         individual_marker.setIcon('images/yellow_icon.png');
                                     });
                                     infoBox.setMap(null);

                                 }
                                 marker1.setIcon('images/red_icon.png');
                                 infoBox = new InfoBox({content:"test"+"--@--"+"Your Location"+"--@--"+"-999", latlng: marker1.getPosition(), map: map});
                                 //infoBox.open(map, marker);

                             }
                         })(marker1, i));

                         var rectangle1 = new google.maps.Rectangle({
                             map:map,
                             bounds:new google.maps.LatLngBounds(
                             //            new google.maps.LatLng(<?php // echo $latitude-0.009; ?>,<?php // echo $longitude-0.015; ?>),
                             //            new google.maps.LatLng(<?php // echo $latitude+0.009; ?>,<?php // echo $longitude+0.015; ?>)
                             new google.maps.LatLng(login_lat-0.009,login_long-0.015),
                             new google.maps.LatLng(login_lat+0.009,login_long+0.015)
                         ),
                             strokeColor: '#9AA0FF',
                             strokeOpacity: 0.8,
                             strokeWeight: 2,
                             fillColor: '#9AA0FF',
                             fillOpacity: 0.35
                         });
                         var circle4 = [], circle5 = [];
                         var infoBox = null;
                         for (var i = 0; i < locations.length; i++) {
                             datatext = locations[i][0];

                             marker = new google.maps.Marker({
                                 position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                 map: map,
                                 //place:new google.maps.Place({location:new google.maps.LatLng(locations[i][1], locations[i][2]),query:'Curry leaves,Jehan circle,India,Maharashtra,Nashik'}),
                                 title: datatext,
                                 icon:'images/yellow_icon.png'
                             });

                             circle4[i] = new google.maps.Circle({
                                 map:map,
                                 radius:500,
                                 center:new google.maps.LatLng(locations[i][1],locations[i][2]),
                                 fillColor: "#fdd",
                                 fillOpacity: "0.25",
                                 strokeColor:"#fff",
                                 strokeWeight:"2"
                             });

                             circle5[i] = new google.maps.Circle({
                                 map:map,
                                 radius:800,
                                 center:new google.maps.LatLng(locations[i][1],locations[i][2]),
                                 fillColor: "#fdd",
                                 fillOpacity: "0.25",
                                 strokeColor:"#fff",
                                 strokeWeight:"2"
                             });

                             newMarkers.push(marker);
                             google.maps.event.addListener(marker, "click", (function(marker, i) {
                                 return function() {

                                     if(infoBox){

                                         $.each(newMarkers, function(index, individual_marker) {
                                             individual_marker.setIcon('images/yellow_icon.png');
                                         });
                                         infoBox.setMap(null);
                                         newMarkers[0].setIcon('images/blue_icon.png');
                                     }
                                     marker.setIcon('images/red_icon.png');
                                     infoBox = new InfoBox({content:locations[i][3]+"--@--"+locations[i][0]+"--@--"+locations[i][5], latlng: marker.getPosition(), map: map});
                                     //infoBox.open(map, marker);

                                 }
                             })(marker, i));


                         }
        
                         var circle1 = new google.maps.Circle({
                             map:map,
                             radius:100,
                             center:new google.maps.LatLng(login_lat,login_long),
                             //fillColor: "#ccc",
                             fillOpacity: "0.25",
                             strokeColor:"#fff",
                             strokeWeight:"2"
                         });
        
        
                         var circle2 = new google.maps.Circle({
                             map:map,
                             radius:500,
                             center:new google.maps.LatLng(login_lat,login_long),
                             //fillColor: "#ccc",
                             fillOpacity: "0.25",
                             strokeColor:"#fff",
                             strokeWeight:"2"
                         });
        
                         var circle3 = new google.maps.Circle({
                             map:map,
                             radius:800,
                             center:new google.maps.LatLng(login_lat,login_long),
                             fillColor: "#fdd",
                             fillOpacity: "0.25",
                             strokeColor:"#fff",
                             strokeWeight:"2"
                         });
        
                         google.maps.event.addListener(map, 'zoom_changed', function() { 
                             zoomLevel = map.getZoom();
                             if(zoomLevel >= 11)
                             {
                                 var multiplier = (22-zoomLevel)/10;
                                 rectangle1.setMap(null);  
                                 for (var i = 0; i < locations.length; i++) {
                                     circle5[i].setRadius(multiplier*300);
                                     circle4[i].setRadius(multiplier*150);
                                 }
                
                                 circle3.setRadius(multiplier*300);
                                 circle2.setRadius(multiplier*150);
                                 circle1.setRadius(multiplier*80);
                
                
                                 if(zoomLevel >= 15)
                                 {
                                     var multiplier = (22-zoomLevel)/10;
                                     for (var i = 0; i < locations.length; i++) {
                                         circle5[i].setRadius(multiplier*40);
                                         circle4[i].setRadius(multiplier*25);
                                     }
                    
                                     circle3.setRadius(multiplier*40);
                                     circle2.setRadius(multiplier*25);
                                     circle1.setRadius(multiplier*15);
                    
                      
                    
                                     if(zoomLevel >= 17)
                                     {
                                         var multiplier = (22-zoomLevel)/10;
                                         for (var i = 0; i < locations.length; i++) {
                                             circle5[i].setRadius(multiplier*20);
                                             circle4[i].setRadius(multiplier*10);
                                         }
                        
                                         circle3.setRadius(multiplier*20);
                                         circle2.setRadius(multiplier*10);
                                         circle1.setRadius(multiplier*5);
                                     }
                                 }
                             }
                             else if(zoomLevel <= 10)
                             {
                                 var multiplier = (22-zoomLevel)/10;
                                 rectangle1.setMap(map);
                                 rectangle1.setBounds(
                                 new google.maps.LatLngBounds(
                                 new google.maps.LatLng(<?php echo $latitude - 0.009; ?>,<?php echo $longitude - 0.015; ?>),
                                 new google.maps.LatLng(<?php echo $latitude + 0.009; ?>,<?php echo $longitude + 0.015; ?>)
                             )
                             );
                                 circle3.setRadius((multiplier+1)*1000);
                                 circle2.setRadius((multiplier+1)*600);
                                 circle1.setRadius((multiplier+1)*500);
                
                                 if(zoomLevel == 10)
                                 {
                                     circle3.setRadius(800);
                                     circle2.setRadius(500);
                                     circle1.setRadius(100);
                    
                                 }
                
                             }
                         });
        
                     });
                     map.setCenter(pos);
                 }, function() {
              
                 });
             } else {
                 // Browser doesn't support Geolocation
             }
<?php endif ?>
    
    
     }
  
     google.maps.event.addDomListener(window, 'load', initialize);
</script>

</head>
<body>

    <div id="warper">
        <div id="warper-inner">
            <?php include('header_in.php'); ?>

            <div id="map_outer">
                <div class="map">   
                    <div id="map_canvas" style="width:100%;height:550px;"></div>
                </div>

            </div>


        </div>
    </div>
    <?php include('footer.php'); ?>