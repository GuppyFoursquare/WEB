<?php include('header_start.php');?>
<!--===================================menu=========================================--> 
<link rel="stylesheet" type="text/css" href="css/component.css" />
<script type='text/javascript' src="js/modernizr.custom.js"></script>

<!-- MENU END -->
<!-- script type='text/javascript' src='js/youblur.min.js'></script -->

<!--===================================top-slider=========================================-->
    <script src="js/foggy.min.js"></script>
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/slippry.css">
    <script type='text/javascript' src="js/slippry.js"></script>
    <script type='text/javascript' src="js/jquery.validate.js"></script>
    <script type='text/javascript' src="js/jquery.additional-methods.min.js"></script>
    
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.css">
    
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
    
    <script type="text/javascript" src="js/jquery.qtip.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.qtip.css" />
    
    <script type='text/javascript'>
        $(function() {
            var demo1 = $("#demo1").slippry({
                        // transition: 'fade',
                        // useCSS: true,
                        // speed: 1000,
                        // pause: 3000,
                        // auto: true,
                        // preload: 'visible',
                        // autoHover: false
                });
                $('.stop').click(function () {
                        demo1.stopAuto();
                });
                
                $(".edit_profile").qtip({
                    position: {
                        at: 'bottom left', // at the bottom right of...
                        target: $('.edit_profile') // my target
                    }
                });
                
                $('.start').click(function () {
                        demo1.startAuto();
                });

                $('.prev').click(function () {
                        demo1.goToPrevSlide();
                        return false;
                });
                $('.next').click(function () {
                        demo1.goToNextSlide();
                        return false;
                });
                $('.reset').click(function () {
                        demo1.destroySlider();
                        return false;
                });
                $('.reload').click(function () {
                        demo1.reloadSlider();
                        return false;
                });
                $('.init').click(function () {
                        demo1 = $("#demo1").slippry();
                        return false;
                });
                
                $("#ddlCountrySelect").val("<?php echo $_SESSION['usr_country'];?>");
                $("#ddlStateSelect").val("<?php echo $_SESSION['usr_state'];?>");
                
                $('#frmRegister').validate({
                    rules:{
                        mem_first_name:{required:true},
                        mem_last_name:{required:true},
                        mem_email:{required:true, email:true},
                        mem_user_name:{required:true},
                        mem_mob:{required:true,minlength:10,maxlength:10},
                        ddlCountrySelect:{required:true},
                        ddlStateSelect:{required:true},
                        txtCity:{required:true},
                        txtAddress:{required:true}
                    },
                    messages:{
                        mem_first_name:{required:"Please enter first name."},
                        mem_last_name:{required:"Please enter last name."},
                        mem_email:{required:"Please enter email.", email:"Please enter valid email."},
                        mem_user_name:{required:"Please enter user name."},
                        mem_mob:{required:"Please enter your contact number.",minlength:"Please enter valid contact.",maxlength:"Please enter valid contact."},
                        ddlCountrySelect:{required:"Please select your country."},
                        ddlStateSelect:{required:"Please select your state."},
                        txtCity:{required:"Please enter your city name."},
                        txtAddress:{required:"Please enter your address."}
                    }
                });
                
                $("#ddlCountrySelect").change(function(){
                     var country=$("#ddlCountrySelect").val();
                     
                     $.ajax({
                        type:"post",
                        url:"getStates.php",
                        data:"country="+country,
                        success:function(data){
                              $("#ddlStateSelect").html(data);
                        }
                     });
                     
               });
               
               $("#ddlCountrySelect").val("<?php echo $_SESSION['usr_country'];?>");
               $("#ddlCountrySelect").change();

               setTimeout(function(){
                   $("#ddlStateSelect").val("<?php echo $_SESSION['usr_state'];?>");
               }, 1000);
               
               
               $("#logout_button").click(function(){
                   window.location.href = $("#site_path").val()+"logout.php";
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


<?php if($rows > 0):?>

function initialize() {
    
    locations = $.parseJSON('<?php echo $lat_long_array;?>');
    
    var myOptions = {
      zoom: 10,
      center: new google.maps.LatLng(locations[0][1],locations[0][2]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
    var circle4 = [], circle5 = [];
    
    $(window).on('resize', function() {
        var currCenter = map.getCenter();
        google.maps.event.trigger(map, 'resize');
        map.setCenter(currCenter);
    })
    $(window).resize();

    
    google.maps.event.addListener(map, 'zoom_changed', function() {
        zoomLevel = map.getZoom();
        if(zoomLevel >= 11)
        {
            var multiplier = (22-zoomLevel)/10;
            for (var i = 0; i < locations.length; i++) {
                circle5[i].setRadius(multiplier*300);
                circle4[i].setRadius(multiplier*150);
            }
          
            if(zoomLevel >= 15)
            {
                var multiplier = (22-zoomLevel)/10;
                for (var i = 0; i < locations.length; i++) {
                    circle5[i].setRadius(multiplier*40);
                    circle4[i].setRadius(multiplier*25);
                }
                
                if(zoomLevel >= 17)
                {
                    var multiplier = (22-zoomLevel)/10;
                    for (var i = 0; i < locations.length; i++) 
                    {
                        circle5[i].setRadius(multiplier*20);
                        circle4[i].setRadius(multiplier*10);
                    }
                }
            }
        }
    });
    
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
  
  <?php else:?>
    
      $(document).ready(function(){
          $("#map_canvas")
                    .html("<div style='text-align: center;color: #fff;font-size: 16px;'> No record(s) found.</div>")
                    .attr("style","height:80px;");
          
          $("#image_click").click(function(){
              alert();
          });
          
      });
    
  <?php endif?>
  
</script>

    <style>
        .whiteMark{
            color:#fff!important;
            background: none repeat scroll 0 0 transparent!important;
        }
       
    </style>
</head>
<body>
<div id="warper">
	<div id="warper-inner">
        <?php include('header_in.php');?>
            
            <input type="file" style="display: none;" id="image_click" name="image_click"/>
            
            <div id="continer_outer" style="margin-bottom: 0px;">
        	<div id="continer_in">
            	<div id="continer">
                    <div class="col_left" style="width: 100%;">
                    	<div class="category_box" >
                            <div class="category_box_in" >
                                <div class="view_profile_div">
                                    <div class="view_profile_div_1">
                                        <img src="<?php echo $_SESSION['usr_profile_picture'] != '' ? PROFILE_IMAGE.$_SESSION['usr_profile_picture'] : PROFILE_IMAGE.'default.png';?>" style="width:230px;"/>
                                        <div class="cam_icon" style="display: none;">
                                            <div class="cam_icon_inner">
                                                <a href="javascript:void(0);" id="image_click" style="color: rgb(250,217,78);font-size: 10px;"><i class="fa fa-camera fa-2x" ></i></a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="view_profile_div_outer">
                                        
                                        <div class="view_profile_welcome_text">
                                            <div class="view_profile_welcome_text_in">
                                                <h1> Hello <?php echo stripslashes($_SESSION['usr_first_name']);?>, <a class="edit_profile" href="javascript:void(0);" style="color: rgb(250,217,78)" title="Edit profile"><i class="fa  fa-pencil fa-1x" ></i></a></h1> 
                                            </div>
                                            
                                             <div class="logout_button_div no_margin">
                                                <input type="button" name="logout_button" id="logout_button" class="logout_button logout_button1" value="LOGOUT"/>
                                            </div>
                                            
                                        </div>
                                        <div class="view_profile_div_2">
                                            
                                            <div class="detail_box no_margin">
                                                <label class="label_class"> First name </label>
                                                <label class="label_class1"> <?php echo stripslashes($_SESSION['usr_first_name']);?> </label>
                                            </div>

                                            <div class="detail_box">
                                                <label class="label_class"> Last name </label>
                                                <label class="label_class1"> <?php echo stripslashes($_SESSION['usr_last_name']);?> </label>
                                            </div>

                                            <div class="detail_box">
                                                <label class="label_class"> Date of birth </label>
                                                <label class="label_class1"> <?php echo date('M d, Y',  strtotime($_SESSION['usr_dob']));?> </label>
                                            </div>

                                            <div class="detail_box">
                                                <label class="label_class"> Year of birth </label>
                                                <label class="label_class1"> <?php echo date('Y',  strtotime($_SESSION['usr_dob']));?> </label>
                                            </div>

                                        </div>
                                        <div class="view_profile_div_3 ">
                                        
                                       
                                        
                                        <div class="detail_box no_margin">
                                            <label class="label_class"> City </label>
                                            <label class="label_class1"> <?php echo stripslashes($_SESSION['usr_city']);?> </label>
                                        </div>
                                        
                                        <div class="detail_box">
                                            <label class="label_class"> Country </label>
                                            <label class="label_class1"> <?php echo stripslashes($countries['country_name']);?> </label>
                                        </div>
                                        
                                        <div class="detail_box">
                                            <label class="label_class"> E-mail </label>
                                            <label class="label_class1"> <?php echo stripslashes($_SESSION['usr_email']);?> </label>
                                        </div>
                                        
                                        <div class="detail_box">
                                            <label class="label_class"> Phone number </label>
                                            <label class="label_class1"> <?php echo stripslashes($_SESSION['usr_contact']);?> </label>
                                        </div>
                                        
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="view_favourites_div">
                                    
                                     <div class="view_profile_favourites_text">
                                        <div class="view_profile_favourites_text_in">
                                            <h1> MY FAVORITES </h1>
                                        </div>
                                         <div class="bg_texture" style="width: 84%;">
                                            &nbsp;
                                        </div>
                                    </div>
                                    
                                     <?php if($rows > 0): $i=1;?>
                                    <?php while ($place = mysql_fetch_array($my_comments)) {?>
                                    
                                    <?php if($i % 4 != 0):?>
                                    <div class="favourites_wrapper">
                                        <div class="list_tiles col_1 ">
                                            <div class="col_img">
                                                <div class="col_img_over">
                                                    <div data-link="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>" class="over">
                                                        <a href="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>">MORE INFORMATION</a>
                                                    </div>
                                                    <div style="margin-bottom: -3px;" class="foggyimg">
                                                        <img alt="<?php echo htmlentities(stripslashes($place['plc_name']));?>" src="<?php echo (!empty($place['plc_gallery_media']) ? PLACES_MEDIUM_IMAGE_PATH.$place['plc_gallery_media'] : DEFAULT_IMAGE_PATH);?>">
                                                    </div>
                                                </div>
                                                <div class="col-text">
                                                    <div class="cap_text1" title="<?php echo htmlentities(stripslashes($place['plc_name']));?>"><?php echo htmlentities(strlen($place['plc_name']) > 15 ? substr(stripslashes($place['plc_name']),0,15).'...' : stripslashes($place['plc_name']));?></div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    <?php else:?>
                                    <div class="favourites_wrapper margin_0">
                                        <div class="list_tiles col_2 ">
                                            <div class="col_img">
                                                <div class="col_img_over">
                                                    <div data-link="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>" class="over">
                                                        <a href="<?php  echo SITE_PATH.'places/'. base64_encode($place['plc_id']);?>">MORE INFORMATION</a>
                                                    </div>
                                                    <div style="margin-bottom: -3px;" class="foggyimg">
                                                        <img alt="<?php echo htmlentities(stripslashes($place['plc_name']));?>" src="<?php echo (!empty($place['plc_gallery_media']) ? PLACES_MEDIUM_IMAGE_PATH.$place['plc_gallery_media'] : DEFAULT_IMAGE_PATH);?>">
                                                    </div>
                                                </div>
                                                <div class="col-text">
                                                    <div class="cap_text1" title="<?php echo htmlentities(stripslashes($place['plc_name']));?>"><?php echo htmlentities(strlen($place['plc_name']) > 15 ? substr(stripslashes($place['plc_name']),0,15).'...' : stripslashes($place['plc_name']));?></div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>
                                    <?php endif?>
                                    <?php $i++; }?>
                                    <?php else:?>
                                        <div style="text-align: center;color: #fff;font-size: 16px;">No record(s) found.</div>
                                    <?php endif?>
                                </div>
                                
                                
                                <div class="view_profile_map_div">
                                    <div class="view_profile_favourites_text">
                                        <div class="view_profile_favourites_text_in">
                                            <h1> MY PLACES </h1>
                                        </div>
                                        <div class="bg_texture">
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div id="map_outer">
                                        <div class="map">   
                                            <div id="map_canvas" style="width:100%;height:400px;">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                </div>
                
            </div>
        </div>
     </div>
        
	</div>
</div>
<?php include('footer.php');?>
