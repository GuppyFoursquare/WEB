<?php include('header_start.php');?>
<meta name="keywords" content="<?php echo $placeDetails['plc_keywords'] ? stripslashes($placeDetails['plc_keywords']) : '';?>"/>
<meta name="description" content="<?php echo $placeDetails['plc_meta_description'] ? stripslashes($placeDetails['plc_meta_description']) : '';?>"/>
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
    <script src="js/organictabs.jquery.js"></script>
    
    <link rel='stylesheet' type='text/css'href='css/jquery.timepicker.css'/>
    <script type='text/javascript'src='js/jquery.timepicker.js'></script>
    
    <script type="text/javascript" src="js/jquery.qtip.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.css" />
    
    <script type="text/javascript" src="source_fexi/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="source_fexi/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="source_fexi/mediaelementplayer/mediaelementplayer.css" media="screen" />
    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source_fexi/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="source_fexi/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    
    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="source_fexi/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript" src="source_fexi/mediaelementplayer/mediaelement-and-player.min.js"></script>
    
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
    <script type="text/javascript" src="js/ContextMenu.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/style-dropdown.css" />
    
    <link rel="stylesheet" type="text/css" href="css/jquery.raty.css" />
    <link rel="stylesheet" type="text/css" href="css/labs.css" />
    <script type="text/javascript" src="js/jquery.raty.js"></script>
    <script type="text/javascript" src="js/labs.js"></script>
    
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>		
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    
    <script type='text/javascript' src="js/jquery.validate.js"></script>
    <script type='text/javascript' src="js/jquery.additional-methods.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
    <script type="text/javascript" src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    
    
    <script>
        $(function() {
             $('.fancybox').fancybox();
            $("#example-one").organicTabs();
            
            $("#rate_text").qtip({
                position: {
                    at: 'bottom left', // at the bottom right of...
                    target: $('.rating') // my target
                }
            });
            
            $(".phn_no_display_hide").click(function(){
                var width = $(window).width();
                if(width < 766)
                {
                    $(".phone_number_div").toggle("display");
                }
            });
            
            $(window).resize(function(){
                var width = $(window).width();
                if(width >= 766)
                {
                    $(".phone_number_div").hide();
                }
            });
            
            /*$("#example-two").organicTabs({
                "speed": 200
            });*/
            
            //$('#select_time').timepicki(); 
            
            var timepicker = $('#select_time').timepicker({
                timeFormat: 'H:mm',
                // year, month, day and seconds are not important
                minTime: new Date(0, 0, 0, 0, 0, 0),
                maxTime: new Date(0, 0, 0, 23, 30, 0),
                //scrollbar:true,
                // items in the dropdown are separated by at interval minutes
                interval: 30
                
            });
            
            
            $('#date_choose').datepicker();
            $('#date_choose').datepicker("option", "dateFormat", "M d, yy");
            $('#date_choose').datepicker("option", "showAnim", "slide");
            $('#date_choose').datepicker("option","changeYear",true);
            $('#date_choose').datepicker("option","changeMonth",true);
            $('#date_choose').datepicker("option","showMonthAfterYear",true);
            $('#date_choose').datepicker("option","showButtonPanel",true);
            $( "#date_choose" ).datepicker("option", "minDate", new Date('<?php echo date('M d, Y',time());?>') );
            $('#date_choose').datepicker("option","onSelect",function(selectedDate, inst ){$("#choose_date").val(selectedDate)});
            
            
//            $(".rating").click(function(){
//                $("#fieldset-dropdown").toggle(0);
//            });
            
            $(document).click(function(event){
                var target = $( event.target );
                if ( !(target.is( ".contact-inner" )) && !(target.is( ".contact-inner div img" )) && !(target.is( ".contact-inner div" )) && !(target.is( ".review_text" )) && !(target.is( ".review_text p" )) && !(target.is( ".star_rating" )) && !(target.is( ".star_rating img" )) && !(target.is( ".rating" )) && !(target.is( ".rating img" )) && !(target.is( ".contact-input" )) && !(target.is( "#Submit" )) && !(target.is( ".contact-input textarea" )) && !(target.is( ".contact-submit" ))) {
                    //target.css( "background-color", "red" );
                    $("#fieldset-dropdown").hide();
                 }
            });
            
            $('.star_rating').raty({
                path:'images/',
                score: 0,
                space:false
            });
            
            $('.rating').raty({
                path:'images/',
                score: <?php echo $calc_rating;?>,
                space:false,
                readOnly: true,
                number: 5
            });
            
            
            <?php while ($row1 = mysql_fetch_array($places2)) {?>
                $('#star_rating_reviews<?php echo $row1['places_rating_by'];?>').raty({
                    path:'images/',
                    score: <?php echo $row1['place_rating_rating'];?>,
                    space:false,
                    readOnly: true
                });

            <?php }?>
            
            $('#frmRating').validate({
                    ignore: "",
                    rules:{
                        rate_message:{required:true},
                        score:{required:true}
                    },
                    messages:{
                        rate_message:{required:"Please enter review."},
                        score:{required:"Please select rating."}
                    },
                     errorPlacement: function(error, element) {
                        if (element.attr("name") == "score") {
                        error.insertAfter("#star_rating");
                        } else {
                        error.insertAfter(element);
                        }
                    }
                });
            
            
            var i,
                    tags = document.getElementById("infotext").getElementsByTagName("*"),
                    total = tags.length;
                for ( i = 0; i < total; i++ ) {
                    if(tags[i].nodeName != "BR" && tags[i].nodeName != "STRONG" && tags[i].nodeName != "EM" && tags[i].nodeName != "IMG")
                        tags[i].setAttribute('class','whiteMark');
                }
                
                var $video_player, _videoHref, _videoPoster, _videoWidth, _videoHeight, _dataCaption, _player, _isPlaying = false;
                $(".fancy_video").fancybox({
                    // set type of content (remember, we are building the HTML5 <video> tag as content)
                    type       : "html",
                    scrolling  : "no",
                    // other API options
                    beforeLoad : function () {
                        // build the HTML5 video structure for fancyBox content with specific parameters
                        _videoHref   = this.href;
                        //alert(_videoHref);
                        // validates if data values were passed otherwise set defaults
                        _videoPoster = typeof this.element.data("poster")  !== "undefined" ? this.element.data("poster")  :  "";
                        _videoWidth  = typeof this.element.data("width")   !== "undefined" ? this.element.data("width")   : 360;
                        _videoHeight = typeof this.element.data("height")  !== "undefined" ? this.element.data("height")  : 360;
                        //_dataCaption = typeof this.element.data("caption") !== "undefined" ? this.element.data("caption") :  "";
                        // construct fancyBox title (optional)
                        this.title = _dataCaption ? _dataCaption : (this.title ? this.title : "");
                        // set fancyBox content and pass parameters
                        this.content = "<video id='video_player' src='" + _videoHref + "'  poster='" + _videoPoster + "' width='" + _videoWidth + "' height='" + _videoHeight + "'  controls='controls' preload='none' ></video>";
                        // set fancyBox dimensions
                        this.width = _videoWidth;
                        this.height = _videoHeight;
                    },
                    afterShow : function () {
                        // initialize MEJS player
                        var $video_player = new MediaElementPlayer('#video_player', {
                                defaultVideoWidth : this.width,
                                defaultVideoHeight : this.height,
                                success : function (mediaElement, domObject) {
                                    //mediaElement.play(); // autoplay video (optional)
                                } // success
                            });
                    }
                });
                
                $(window).load(function(){
                            $(".ratings_comments").mCustomScrollbar({
                                    //autoHideScrollbar:true,
                                    theme:"rounded"
                            });

                    });
                
        });
    </script>

   
    
    
    
    <script type="text/javascript">
    /* An InfoBox is like an info window, but it displays
    * under the marker, opens quicker, and has flexible styling.
    * @param {GLatLng} latlng Point to place bar at
    * @param {Map} map The map on which to display this InfoBox.
    * @param {Object} opts Passes configuration options - content,
    *   offsetVertical, offsetHorizontal, className, height, width
    */
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
                        img_str = "<img style='width:231px;' src='<?php echo SERVER_FRONT_PATH.PLACES_MEDIUM_IMAGE_PATH;?>"+result[0]+"' />"
                    }
                    else {
                        img_str = "<img style='width:231px;' src='<?php echo IMAGE_PATH.'no-img.jpg';?>' />";
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
                    
                    var place_name_div = document.createElement("div");
                    place_name_div.style.position = "absolute";
                    place_name_div.style.margin = "10px auto";
                    place_name_div.style.font = "15px Verdana";
                    place_name_div.style.color = "#fff";
                    place_name_div.style.textAlign = "right";
                    place_name_div.style.width = "96%";
                    place_name_div.innerHTML = result[1];
                    
                    var topDiv = document.createElement("div");
                    topDiv.style.textAlign = "right";
                    topDiv.style.cssFloat = "right";
                    
                    //topDiv.style.margin = "-5px 0 0 0";
                    var closeImg = document.createElement("img");
                    closeImg.style.width = "20px";
                    closeImg.style.height = "20px";
                    closeImg.style.cursor = "pointer";
                    closeImg.style.margin = "60px 0 0 -15px";
                    closeImg.style.position = "absolute";
                    closeImg.style.cssFloat = "right";
                    //closeImg.src = "http://gmaps-samples.googlecode.com/svn/trunk/images/closebigger.gif";
                    closeImg.src = "images/close-red.png";
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
    var myOptions = {
      zoom: 10,
      center: new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    var marker1 = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>),
        map: map,
        icon:'images/red_icon.png'
    });
    
    var circle4 = [], circle5 = [];
    
    $(window).on('resize', function() {
        var currCenter = map.getCenter();
        google.maps.event.trigger(map, 'resize');
        map.setCenter(currCenter);
    })
    $(window).resize();
    locations = $.parseJSON('<?php echo $lat_long_array;?>');
    //alert(locations);
    var circle1 = new google.maps.Circle({
        map:map,
        radius:100,
        center:new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>),
        //fillColor: "#ccc",
        fillOpacity: "0.25",
        strokeColor:"#fff",
        strokeWeight:"2"
    });
    
    
    var circle2 = new google.maps.Circle({
        map:map,
        radius:500,
        center:new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>),
        //fillColor: "#ccc",
        fillOpacity: "0.25",
        strokeColor:"#fff",
        strokeWeight:"2"
    });
    
    var circle3 = new google.maps.Circle({
        map:map,
        radius:800,
        center:new google.maps.LatLng(<?php echo $latitude;?>,<?php echo $longitude;?>),
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
                
            }
            marker.setIcon('images/red_icon.png');
            infoBox = new InfoBox({content:locations[i][3]+"--@--"+locations[i][0], latlng: marker.getPosition(), map: map});
            //infoBox.open(map, marker);
            
            }
        })(marker, i));
        
        
    }
    
    
  }
  
  
  
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
    
    
<!--===================================detial-slider=========================================--> 

   <script src="js/responsiveslides.min.js"></script>
  <script>
    // You can also use "$(window).load(function() {"
    $(function () {
      // Slideshow 3
      $("#slider3").responsiveSlides({
        manualControls: '#slider3-pager',
        maxwidth: 1100
      });
      
      $(".map_click").click(function(){
        setTimeout(function() {
                $(window).resize();
          }, 400); 
         
      });
      
      $(".click_to_scroll").click(function(){
            var self = $("#example-one");
            setTimeout(function() {
                    theOffset = $(self).offset();
                    $('body,html').animate({ scrollTop: theOffset.top - 10 });
            }, 600); // ensure the collapse animation is done
      });
      
      $('#table_query_form').validate({
            ignore:"",
            rules:{
                choose_date:{required:true},
                people:{required:true},
                select_time:{required:true},
                member_name:{required:true},
                member_email:{required:true, email:true},
                wishes:{required:true}
                
            },
            messages:{
                choose_date:{required:"Please choose a date."},
                people:{required:"Please select number of people."},
                select_time:{required:"Please select time."},
                member_name:{required:"Please enter member name"},
                member_email:{required:"Please enter member email.",email:"Please enter a valid email."},
                wishes:{required:"Please enter your special wishes."}
                
            }
        });
      
      
    });
  </script>
  
  
</head>
<body>
<div id="warper">
	<div id="warper-inner">
        <?php include('header_in.php'); ?>
            <input id="place_id" value="<?php echo $placeDetails['plc_id'];?>" type="hidden"/>
         <div class="detail_slider_box">
          <div class="detail_slider_box_in">
            <div class="detail_slider">
              <div class="detail_slider_in">
                <?php if($placeDetails['plc_name']):?>
                    <div class="heading">
                        <?php echo stripslashes($placeDetails['plc_name']);?>
                    </div>
                <?php else:?>
                    <div class="heading" style="height: 35px;">
                        <?php echo stripslashes($placeDetails['plc_name']);?>
                    </div>
                <?php endif?>
                <!--div class="favourite_rating"><img src="images/favourites.png" alt=""/></div-->
                
                  
                <!--div class="rating"><img src="images/ratting.png" alt=""/></div-->
<!--                  <div class="rating_outer">
                    <div class="rating"></div>
                    <div class="rate_text" id="rate_text" title="Please click on stars to rate."><img src="images/tooltip_icon.png" alt="arrow" /></div>
                  </div>-->
                
                
                <div class="detailslider">
                <div class="residentialdetailtoptext">
                 <!--<a href="javascript:void(0);" class="slider_restaurant_icon"></a>-->
                    <!-- Slideshow 3 -->
                        <ul class="rslides" id="slider3">
                            <?php 
                            if($galDetails){
                                foreach($galDetails as $gal){
                                    ?>
                                        <li>
                                            <img src="<?php echo PLACES_LARGE_IMAGE_PATH.$gal['plc_gallery_media'];?>" alt="">
                                            <a href="<?php echo PLACES_LARGE_IMAGE_PATH.$gal['plc_gallery_media'];?>" data-fancybox-group="gallery" class="zoom fancybox">
                                            </a>
                                        </li>
                                    <?php
                                }
                            }
                            else
                            {?>
                                        <li> 
                                <img src="<?php echo IMAGE_PATH.'no_image.jpg';?>" alt="No Images available">
                                        </li>
                       <?php }
                            ?>
                        </ul>
                            <!-- Slideshow 3 Pager  -->
                        <ul id="slider3-pager" >
                             <?php 
                             $indx = 0;
                             $gal_count = count($galDetails);
                             if($galDetails) {
                                foreach($galDetails as $gal){ $indx++;
                                    ?>
                                        <li class="<?php echo ($indx % 4 == 0 ? 'margin_0' : '');?>" <?php echo ($gal_count == 1 ? 'style="float: left;list-style: none;"' : '');?>>
                                            <a href="javascript:void(0);">
                                                <img src="<?php echo PLACES_SMALL_IMAGE_PATH.$gal['plc_gallery_media'];?>" alt="">
                                            </a>
                                        </li>
                                <?php
                                }
                             }
                             ?>
                        </ul>
                        
                            <ul class="rslides_tabs" id="vdo_slider">
                            <?php 
                             $indx = 0;
                             if($vdoDetails)
                                foreach($vdoDetails as $gal){ $indx++;
                                    ?>
                                    <li class="<?php echo ($indx % 4 == 0 ? 'margin_0' : '');?>" style="width: auto;" >
                                            <!--<video play height="60" width="72">
                                                <source src="<?php echo PLACES_VIDEO_PATH.$gal['plc_gallery_media'];?>" >
                                            </video>-->
                                            <a href="<?php echo PLACES_VIDEO_PATH.$gal['plc_gallery_media'];?>" data-fancybox-group="videoGallery" class="fancy_video" data-width="900" data-height="400" data-caption="First video">
                                                <!--<video play height="55" width="72">
                                                    <source src="<?php echo PLACES_VIDEO_PATH.$gal['plc_gallery_media'];?>" type="video/mp4; codecs=avc1.42E01E,mp4a.40.2">
                                                </video>-->
                                                <img src="images/play.jpg" alt="video" style="width:70px;height: 41px;"/>
                                            </a>
                                        </li>
                                <?php } ?>
                        </ul>
                            
                          
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            
            
            <div class="detail_middle_sec" id="example-one">
           <div class="box detail_mid_tab">
           <div class="detail_slider_box_in">
           <div class="detail_slider">
           <div class="detail_slider_in" >
              <div class="detail_middle_left_sec">
              <div class="box">
                  
                <?php if($placeDetails['plc_address']):?>
               
               <!--a href="javascript:void(0);" class="ph_box" style="width:100%;">
                    <div class="ph_box_right" style="margin-left: 0px;"><div class="box ph_box_text"><?php// echo stripslashes($placeDetails['plc_name']).', &nbsp;';?></div></div>
                </a-->
                <a href="javascript:void(0);" class="ph_box" style="width:100%;">
                    <div class="ph_box_right" style="margin-left: 0px;display: block;"><div class="box ph_box_text"><?php echo stripslashes(htmlentities($placeDetails['plc_address'])).', &nbsp;';?></div></div>
                </a>
                <a href="javascript:void(0);" class="ph_box" style="width:100%;">
                    <div class="ph_box_right" style="margin-left: 0px;display: block;">
                        <div class="ph_box_text" style="float: left;"><?php echo isset($placeDetails['plc_city']) ? stripslashes(htmlentities($placeDetails['plc_city'])): ' ';?></div>
                        <div class="ph_box_text" style="float: left;"><?php echo isset($placeDetails['state_abbr']) ? ', &nbsp;'.stripslashes(htmlentities($placeDetails['state_abbr'])): '';?></div>
                        <div class="ph_box_text" style="float: left;"><?php echo isset($placeDetails['plc_zip']) ? ', &nbsp;'.stripslashes(htmlentities($placeDetails['plc_zip'])): ' ';?></div>
                    </div>
                </a>
                <?php endif?>
               
               <?php if($placeDetails['plc_Hours']):?>
                    <a href="javascript:void(0);" class="ph_box" style="width:100%;">
                        <div class="ph_box_right" style="margin-left: 0px;display: block;">
                            <div class="box ph_box_text">
                                <label style="cursor: pointer;">Working hours: 24 Hours</label>
                            </div>
                        </div>
                    </a>
               
               <?php else:?>
                    <?php if($placeDetails['plc_intime'] != "00:00:00" && $placeDetails['plc_outtime'] != "00:00:00"):?>  
                        <a href="javascript:void(0);" class="ph_box" style="width:100%;">
                            <div class="ph_box_right" style="margin-left: 0px;display: block;">
                                <div class="box ph_box_text">
                                    <label style="cursor: pointer;">Working hours:</label>
                                    <?php echo date("H:i",strtotime(($placeDetails['plc_intime'])));?>  to  <?php echo date("H:i",strtotime(($placeDetails['plc_outtime'])));?>
                                </div>
                            </div>
                        </a>
                    <?php endif?>
                <?php endif?>
               
               
              <?php if($placeDetails['plc_contact']):?>
              <a href="javascript:void(0);" class="ph_box phn_no_display_hide">
                <div class="ph_box_left">call</div>
                <div class="ph_box_right"><div class="box ph_box_text"><?php echo stripslashes($placeDetails['plc_contact']);?></div></div>
                <div class="phone_number_div"><?php echo stripslashes($placeDetails['plc_contact']);?></div>
              </a>
              <?php endif?>
              <?php if($placeDetails['plc_email']):?>
              <a href="mailto:<?php echo stripslashes($placeDetails['plc_email']);?>" class="ph_box">
              <div class="em_box_left">mail</div>
              <div class="ph_box_right"><div class="box ph_box_text"><?php echo stripslashes($placeDetails['plc_email']);?></div></div>
              </a>
              <?php endif?>
              <?php if($placeDetails['plc_website']):?>
               <a href="<?php echo stripslashes($placeDetails['plc_website']);?>" target="_blank" class="ph_box">
              <div class="we_box_left">web</div>
              <div class="ph_box_right"><div class="box ph_box_text"><?php echo stripslashes($placeDetails['plc_website']);?></div></div>
              </a>
               <?php endif?>
              </div>
              <div class="box wifi_outer">
                  
              <?php foreach ($featureDetails as $individual_feature) {?>
                  <a href="javascript:void(0);" class="wifi_outer_icon" title="<?php echo $individual_feature['feature_title'];?>"><img style="height: 30px;width: 30px; " src="<?php echo FEATURE_ICON.$individual_feature['feature_icon'];?>" alt="<?php echo $individual_feature['feature_title'];?>"/></a>
              <?php    }?>
              <!--a href="javascript:void(0);" class="wifi_outer_icon"><img src="images/detail_wifi.png" alt=""/></a>
              <a href="javascript:void(0);" class="wifi_outer_icon"><img src="images/detail_sun.png" alt=""/></a>
              <a href="javascript:void(0);" class="wifi_outer_icon"><img src="images/detail_card.png" alt=""/></a>
              <a href="javascript:void(0);" class="wifi_outer_icon"><img src="images/detail_rest.png" alt=""/></a-->
              </div>
              </div>
       
             <div class="detail_middle_right_sec">
                 <ul class="nav">
                    <li class="nav-one click_to_scroll"><a href="#jqueryrate">RATE IT</a></li>
                    <li class="nav-two click_to_scroll"><a href="#jquerytable">QUERY</a></li> 
                    <li class="nav-three map_click click_to_scroll"><a  href="#jquerytuts">MAP</a></li>
                    <li class="nav-four click_to_scroll" ><a href="#core" >MENU</a></li>
                    <li class="nav-five last click_to_scroll"><a href="#featured" class="current">INFO</a></li>

                    <!--<li class="nav-one"><a href="#">MAP</a></li>
                    <li class="nav-two"><a href="#">MENU</a></li>
                    <li class="nav-three"><a href="#" class="current">INFO</a></li>-->

                </ul>
             </div>
            </div>
            </div>
            </div>
           </div>
           <div class="box detail_mid_sep"></div>
           <div class="box conbg">
           <div class="list-wrap">
               
               
           <ul id="jqueryrate" class="hide map">
                <li>
                <div class="detail_slider_box_in" >
                    <div class="detail_slider">
                    <div class="detail_slider_in detail_con_box" >
                    
                        <div class="infotext" style="font-size: 25px;"><h1 style="margin-top: 5px;">Reviews</h1></div>
                        <div class="rating"></div>
                        
                        
                        
                        <?php if(isset($_SESSION['user_id'])):?>
                            <?php if($_SESSION['review_added'] == 0):?>
                                    
                            <div class="form-ratings">
                                <form action="add_ratings.php" method="POST" id="frmRating">
                                    <div class="form-group">
                                        <label>Review</label>
                                        <textarea maxlength="100" rows="4" id="rate_message" name="rate_message" placeholder="Your review…" required></textarea>
                                    </div>
                                    
                                    <input type="hidden" id="current_place_id" name="current_place_id" value="<?php echo $placeDetails['plc_id'];?>"/>
                                    
                                    <div class="form-group bottom-margin-class-1" style="margin-bottom: 30px;">
                                        <label>Rating</label>
                                        <div class="star_rating" id="star_rating"></div>
                                    </div>
                                    <div class="form-group">
                                        <input class="rate_button_class" type="submit" value="Rate it" id="Submit" name="Submit"/>
                                    </div>
                                </form>
                            </div>
                            <?php else:?>
                                <?php if($_SESSION['comment_inactive'] == 1):?>
                                    <div class="infotext">
                                        Your comment awaits approval from web site administrator.
                                    </div>>
                                <?php endif?>
                             <?php endif?>

                        <?php else:?>
                            
                            <div class="infotext">Want to add a review? Please <a class="lnkLogin remove_background" style="text-decoration: underline;color: #fff;display: inline;" href="javascript:scrollToTop();">Login</a> first.</div>        
                            
                        <?php endif?>
                        
                        <?php if($places_ratings):?>
                            <div class="review-title-class"> <h1>Reviews by users </h1> </div>
                            <div class="ratings_comments" <?php if(!isset($_SESSION['user_id']) || $_SESSION['review_added'] == 1) {echo "style='width:100%;'";}?>>
                                <?php while ($row = mysql_fetch_array($places_ratings)) {?>
                                    <div class="infotext bottom-margin-class">
                                        <div class="date-rate-lbl-class">
                                            <label style="font-size: 15px;"><?php echo date('M d, Y',  strtotime($row['places_rating_created_date']));?></label>
                                            <div class="star_rating_reviews" id="star_rating_reviews<?php echo $row['places_rating_by'];?>" data-rating="<?php echo $row['place_rating_rating'];?>"></div>
                                        </div>
                                        <div>
                                            <?php echo stripslashes($row['place_rating_comment']);?>
                                        </div>
                                        <div class="user-name-class">
                                            <label style="font-weight: bold;"> - <?php echo stripslashes($row['usr_first_name'].' '.$row['usr_last_name']);?></label>
                                        </div>
                                    </div>
                                    
                                <?php }?>
                            </div>
                        <?php endif?>

                    </div></div>
                </div>
                </li>
            </ul>
               
           <ul id="jquerytable" class="hide map"  style="width:100%;height:400px;"  >
                
                <li>
                    <div class="detail_slider_box_in" >
                        <div class="detail_slider">
                            <div class="detail_slider_in detail_con_box" >
                                <form action="" method="POST" id="table_query_form">
                                <div class="header_text" >
                                    <div class="header_text_inner">
                                        <h1> SEND A REQUEST FOR TABLE</h1>
                                    </div>
                                    <div class="button_class">
                                        <input type="submit" value="SEND REQUEST" name="send_req" id="send_req"/>
                                    </div>
                                </div>
                                
                                
                                <div id="table_query_div">
                                    <div class="query_table_date_time">
                                        <div class="label_class"><label> Choose your date:</label></div>
                                        <div id="date_choose"></div>
                                        <input type="hidden" placeholder="Choose Date" id="choose_date" name="choose_date" value="<?php echo date('M d, Y',time());?>">
                                    </div>
                                    <div class="form_right">
                                        <div class="form_right_in">
                                            <div class="label_class"><label>How many people?</label></div>
                                            <select id="people" name="people">
                                                <option value="">select number of people</option>
                                                <?php for($z=1;$z<11;$z++){?>
                                                    <option value="<?php echo $z;?>"><?php echo $z;?> people</option>
                                                <?php }?>
                                            </select>
                                        </div>

                                        <div class="form_right_in margin_0">
                                            <div class="label_class"><label>Your Name</label></div>
                                            <input type="text" placeholder="my name..." value=""  id="member_name" name="member_name" >
                                        </div>
                                        
                                        <div class="form_right_in">
                                            <div class="label_class"><label>Choose your time</label></div>
                                            <input id="select_time" placeholder="choose time" name="select_time" readonly/>
                                        </div>
                                        
                                        <div class="form_right_in margin_0">
                                            <div class="label_class"><label>Your E-Mail</label></div>
                                            <input type="text" placeholder="my email..." value=""  id="member_email" name="member_email" >
                                        </div>

                                        <div class="form_right_textarea">
                                            <div class="label_class"><label>Special wishes?</label></div>
                                            <textarea placeholder="enter your text ..." id="wishes" name="wishes" rows="5"></textarea>
                                        </div>
                                    
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>    
               
            <ul id="featured" >
                <li>
                <div class="detail_slider_box_in" >
                    <div class="detail_slider">
                    <div class="detail_slider_in detail_con_box" >
                    <h1><?php echo stripslashes($placeDetails['plc_info_title']);?></h1>
                    <?php if($placeDetails['plc_info']):?>
                        <p id="infotext"><?php echo stripslashes($placeDetails['plc_info']);?></p>
                    <?php else:?>
                        <div id="infotext" style="color: #fff;min-height: 50px;text-align: center;padding: 20px 0;font-size: 18px;">No details for this place available.</div>
                    <?php endif?>
                    </div></div>
                </div>
                </li>
            </ul>
        		 
            <ul id="core" class="hide map">
                <li>
                <?php if($placeDetails['plc_menu']):?>
                <embed src="<?php echo PLACES_MENU_PDF.$placeDetails['plc_menu'].'#view=fitbh';?>" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                <?php else:?>
                <div style="color: #fff;min-height: 50px;text-align: center;padding: 20px 0;font-size: 20px;">Menu unavailable.</div>
                <?php endif?>
                </li>
            </ul>
        	
            
               
            <ul id="jquerytuts" class="hide map" style="width:100%;height:400px;"  >
                
                <li>
                    <div id="map_outer">
                        <div class="map">   
                            <div id="map_canvas" style="width:100%;height:400px;"></div>
                        </div>
                    </div>
                </li>
            </ul>
        		 
        		
        		 
           </div>
           </div>
</div>
            
	</div>
</div>
<?php include('footer.php');?>