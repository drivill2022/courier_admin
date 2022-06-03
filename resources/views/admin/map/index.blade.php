@extends('admin.layouts.main')
@section('title', 'Maps')
@section('content')
 <?php //echo gettype($riders); echo "<pre>";print_r($riders); die;?>
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Google maps</h4>

                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Map View</h4><br>

                                          <div class="mb-3">
                                                <label class="form-label" for="manufacturername">Hub :</label>
                                                <x-hubs-dropdown :selected="old('hub_id')" />
                                    
                                            </div>
                                        <div id="rider-markers" style="height: 500px;"></div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
    
                        </div> <!-- end row -->
        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
@endsection
@section('footer_scripts')
        <!-- google maps api -->
        <script src="https://maps.google.com/maps/api/js?key={{Setting::get('map_key')}}"></script> 
        <!-- Gmaps file --> 
        <script src="{{admin_asset('libs/gmaps/gmaps.min.js')}}"></script> 
        <!-- gmaps init --> 
        <script src="{{admin_asset('js/pages/gmaps.init.js')}}"></script>

        <script type="text/javascript">

            /*$(document).ready(function(){
                 
                  var map;
                   (map = new GMaps({
                                div: "#rider-markers",
                                lat: 48.895651,
                                lng: 2.290569,
                                map: map,
                                zoom:10,
                            }));

                  var riders = <?php //echo $riders;?>;
                  console.log(riders);
                  renderMarker(riders);

                $("#hub_id").on('change', function postinput(){
                     riders = [];
                    var hub_id = $(this).val(); // this.value
                    var url = "<?php //echo url('/').'/admin/rider-of-hub/';?>"
                    $.ajax({ 
                        url: url+hub_id,
                        type: 'GET'
                    }).done(function(responseData) {
                        var riders = [];
                        riders = responseData;
                        //map.deleteMarker();
                        renderMarker(riders);
                    }).fail(function() {
                        console.log('Failed');
                    });
                });


                  function renderMarker(riders)
               {
                jQuery.each( riders, function( index, value ){
                            console.log(value.latitude+""+value.address);
                            map.addMarker({
                                lat: value.latitude,
                                lng: value.longitude,
                                title: value.address,
                                click: function(a) {
                                    console.log && console.log(a), alert("You clicked in this marker")
                                }
                            })
                });
               }
            }); */

            $(document).ready(function(){ 
               
                 var locations = <?php echo json_encode($riders); ?>
                //console.log(locations);
                initMap(locations);

                $("#hub_id").on('change', function postinput(){
                     riders = [];
                    var hub_id = $(this).val(); // this.value
                    if(hub_id == '')
                    {
                        initMap(locations);
                    }
                    else
                    {
                       var url = "<?php echo url('/').'/admin/rider-of-hub/';?>"
                        $.ajax({ 
                            url: url+hub_id,
                            type: 'GET',
                            //dataType: 'json',
                        }).done(function(responseData) {
                            /*var responseData = $.parseJSON(responseData);
                            var location = riders = [];
                            location = responseData.location;
                            console.log(location);
                            riders = responseData.riders;
                            var html = '';*/

                             var riders = [];
                            riders = responseData;

                            initMap(riders);
                        }).fail(function() {
                            console.log('Failed');
                        });   
                    }
                       
                });

            });
            function initMap(riders) {
                console.log(riders);
                  var rider_length = riders.length;
                  if(rider_length != 0)
                  {
                     var center = {lat: riders[0].latitude, lng: riders[0].longitude};
                  }
                  else
                  {
                      //var center = {lat: 34.052235, lng: -118.243683};
                     var center = {lat: 21.7679, lng: 78.8718};
                  }
                
                  var locations = riders;
                var map = new google.maps.Map(document.getElementById('rider-markers'), {
                    zoom: 8,
                    center: center
                  });

                /* const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h1 id="firstHeading" class="firstHeading">Uluru</h1>' +
                    '<div id="bodyContent">' +
                    "<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large " +
                    "sandstone rock formation in the southern part of the " +
                    "Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) " +
                    "south west of the nearest large town, Alice Springs; 450&#160;km " +
                    "(280&#160;mi) by road. Kata Tjuta and Uluru are the two major " +
                    "features of the Uluru - Kata Tjuta National Park. Uluru is " +
                    "sacred to the Pitjantjatjara and Yankunytjatjara, the " +
                    "Aboriginal people of the area. It has many springs, waterholes, " +
                    "rock caves and ancient paintings. Uluru is listed as a World " +
                    "Heritage Site.</p>" +
                    '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">' +
                    "https://en.wikipedia.org/w/index.php?title=Uluru</a> " +
                    "(last visited June 22, 2009).</p>" +
                    "</div>" +
                    "</div>";

                var infowindow =  new google.maps.InfoWindow({
                    content: contentString,
                });*/

                  var infowindow =  new google.maps.InfoWindow({});
                var marker, count;
                for (count = 0; count < locations.length; count++) {

                    const image = {
                             url: locations[count]['picture'],
                             /*url: "http://drivill.indianshoppingbasket.com/public/rider-icon.jpg",*/
                             /*url: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",*/
                            // This marker is 20 pixels wide by 32 pixels high.
                            size: new google.maps.Size(50, 50),
                            // The origin for this image is (0, 0).
                          };
                    /*const shape = {
                        coords: [1, 1, 1, 20, 18, 20, 18, 1],
                        type: "poly",
                      };*/

                    marker = new google.maps.Marker({
                      position: new google.maps.LatLng(locations[count]['latitude'], locations[count]['longitude']),
                      map: map,
                     /* title: locations[count]['address']+' (Rider: '+locations[count]['rider_name']+')',*/
                      icon: image,
                      // shape: shape,
                    });

                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h1 id="firstHeading" class="firstHeading">'+locations[count]['rider_name']+'</h1>' +
                    '<div id="bodyContent">' +
                    "<p><b>Address:</b>" +locations[count]['address'] +
                    "</div>" +
                    "</div>";

                 google.maps.event.addListener(marker, 'click', (function (marker, count) {
                      return function () {
                        infowindow.setContent(contentString);
                        infowindow.setOptions({maxWidth:250}); 
                        infowindow.open(map, marker);
                      }
                    })(marker, count));

                    /* marker.addListener("click", () => {
                        infowindow.open({
                          anchor: marker,
                          map,
                          shouldFocus: false,
                        });
                      });*/
                  }
                }
           
          

            /*var riders = <?php print_r(json_encode($riders)) ?>;
            

           var map;
            $(document).ready(function() {
                (map = new GMaps({
                    div: "#rider-markers",
                    lat: 20.5937,
                    lng: 78.9629,
                    map: map
                }));

               jQuery.each( riders, function( index, value ){
                console.log(value.latitude+""+value.address);
                map.addMarker({
                    lat: value.latitude,
                    lng: value.longitude,
                    title: value.address,
                    click: function(a) {
                        console.log && console.log(a), alert("You clicked in this marker")
                    }
                })
             });
            }); */// This is just a sample script. Paste your real code (javascript or HTML) here.


  </script>
@endsection

 