<style>
select.county {
  width: 48%!important;
  float: left;
}
select.district {
  width: 48%!important;
  float: left;
  margin-left: 4%;
}
input.zipcode{
  width:33%;
  display: none;
}
.owl-theme .owl-nav [class*='owl-']:hover {
    background: transparent;
}
.owl-prev {
    color: #DCDEDD!important;
}
.owl-prev:hover {
    color: #585755!important;
}
.owl-prev:focus {
    border: none!important;
    outline: none!important;
}
.owl-next {
    color: #DCDEDD!important;
}
.owl-next:hover {
    color: #585755!important;
}
.owl-next:focus {
    border: none!important;
    outline: none!important;
}
.owl-dots{
    /*left: 50%!important;*/
    /*margin-left: -35px;*/
    width: 100%;
}
.date_btn {
    cursor: pointer;
}
.date_btn:hover {
    color: #FFB718;
}
@media (max-width: 480px){
    select.county {
        width: 49%!important;
    }
    select.district {
        width: 49%!important;
        margin-left: 2%!important;
    }
}
</style>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix" style="padding-left: 4%; padding-right: 4%;">
        <div class="row">
            <div class="col-md-12 owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": true, "nav":true, "dots":true,"autoplay": true,"autoplayTimeout": 6000}'>
                <?php if(!empty($banner)) { foreach($banner as $data) { ?>
                    <a href="<?php echo $data['banner_link'] ?>" target="<?php echo ($data['banner_link']=='#')?('_self'):('_new') ?>" class="banner slidebanner">
                        <!-- <img class="lazy" data-src="/assets/uploads/<?php echo $data['banner_image'] ?>"> -->
                        <img src="/assets/uploads/<?php echo $data['banner_image'] ?>">
                    </a>
                <?php }} ?>
            </div>
        </div>
    </section>
    <section class="form-section">
        <div class="container" id="main_area">
            <div class="text-center">
                <h2 style="border: none; color: black;">Cross-regional Lunch</h2>
                <h4>午餐吃得好，心情沒煩惱</h4>
                <br>
            </div>
            <div class="searchbox collapse in " id="essearch">
                <?php $attributes = array('class' => 'store_form', 'id' => 'store_form', 'method' => 'get'); ?>
                <?php echo form_open('store#main_area' , $attributes); ?>
                <div class="row">
                    <div class="col-md-4 border-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fs-13 color-595757">送達地點</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="twzipcode" class="form-group"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 border-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fs-13 color-595757">您的所在地</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-custom dropdown-toggle">
                                            <input type="text" id="address" name="address" class="form-control" placeholder="請輸入地址" value="<?php if(!empty($this->input->get('address'))){ echo $this->input->get('address'); } else { echo $users_address['address']; } ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="middle text-center">
                            <label></label>
                            <button type="submit" class="btn btn-info" style="padding:6px 20px;">搜尋</button>
                        </div>
                    </div>
                    <hr class="xs-visible">
                </div>
                <?php echo form_close() ?>
            </div>
            <?php if(empty($this->input->get('county')) && empty($this->input->get('district')) && empty($this->input->get('address'))) { ?>
            <div class="searchbox" style="margin-top: 50px; padding: 40px 0px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="fs-12 color-595757">請先輸入您的所在地，我們將告訴您有什麼美味選擇</h4>
                    </div>
                </div>
            </div>
            <div style="margin-top: 0px; padding: 40px 0px;">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <img src="/assets/images/store/no-address.png" class="img-responsive">
                    </div>
                </div>
            </div>
            <?php } ?>
            <!--  -->
            <?php if(!empty($this->session->userdata('county')) && !empty($this->session->userdata('district')) && !empty($this->session->userdata('address')) && empty($store_order_time)) { ?>
            <div class="searchbox" style="margin-top: 50px; padding: 40px 0px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4 class="fs-12 color-595757">您所輸入的地址暫無服務</h4>
                    </div>
                </div>
            </div>
            <div style="margin-top: 0px; padding: 40px 0px;">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 text-center">
                        <img src="/assets/images/store/no-server.png" class="img-responsive">
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(!empty($this->session->userdata('county')) && !empty($this->session->userdata('district')) && !empty($this->session->userdata('address')) && !empty($store_order_time)) { ?>
            <?php // if(!empty($store_order_time)){ ?>
            <div class="searchbox" style="margin-top: 50px; padding: 50px 15px 15px 15px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="fs-14 color-595757">想在哪裡取餐呢？</h4>
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <!-- <div id="pano" style="width: 100%; height: 400px; margin-top: 10px;"></div> -->
                    </div>
                    <div class="col-md-6">
                        <?php // require('index-delivery-place.php') ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <h4>&nbsp;</h4>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" checked>
                                        <label class="form-check-label fs-13 color-59757 font-normal">
                                            <?php echo $this->session->userdata('county').$this->session->userdata('district').$this->session->userdata('address') ?>
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" id="custom_address" name="custom_address" value="<?php echo $this->session->userdata('county').$this->session->userdata('district').$this->session->userdata('address') ?>">
                            </div>
                            <!-- <div class="col-md-4 delivery_place_distance_text_area">
                                <span class="text-info fs-10 color-00BFD5 bold" id="delivery_place_distance_text<?php // echo $data['delivery_place_id'] ?>">
                                    <?php // echo $data['distance'] ?>公尺
                                    <?php // echo round($data['distance']/60) ?>分鐘</span>
                            </div> -->
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>配送地址</label>
                                    <input type="text" class="form-control" id="custom_address" name="custom_address" value="<?php echo $this->session->userdata('county').$this->session->userdata('district').$this->session->userdata('address') ?>" placeholder="請輸入完整地址..." onchange="set_custom_address()">
                                </div>
                            </div>
                        </div> -->
                        <div class="row" id="delivery_place_notice" style="display: none;">
                            <div class="col-md-12">
                                <p class="fs-10 bold" style="color: #CB141C;">請選擇取餐地點</p>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 col-md-offset-9">
                        <img src="/assets/images/store/select-store.png" class="img-responsive pointer" onclick="check_delivery_place()">
                    </div> -->
                </div>
            </div>
            <div class="searchbox" id="store_list_area" style="margin-top: 50px; margin-bottom: 50px; <?php //if(!empty($this->session->userdata('delivery_place'))) {echo 'display: block;';}else{echo 'display: none;';} ?>">
                <div class="">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center fs-16 color-595757">
                                美味精選
                                <br>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="carousel-example" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">

                                    <?php $active=0; ?>
                                    <?php $display=''; ?>
                                    <?php if(!empty($store_order_time_date)) { foreach($store_order_time_date as $sotd) { ?>
                                    <?php // for ($i=0; $i <=7 ; $i++) {  ?>

                                        <?php // if($active==''){$active='active';}else{$active='';} ?>
                                        <?php // if($i==0){$active='active';}else{$active='';} ?>
                                        <?php
                                        // if(strtotime(date('Y-m-d') . "+".$i." days")==strtotime(date('Y-m-d')) && strtotime(date('H:i:s'))>strtotime('10:00:00')){
                                        //     $display='hide';
                                        //     $active=0;
                                        // }else{
                                        //     $display='show';
                                        //     $active++;
                                        // }
                                        if(strtotime($sotd['store_order_time'])==strtotime(date('Y-m-d')) && strtotime(date('H:i:s'))>strtotime('10:30:00')){
                                            $display='hide';
                                            $active=0;
                                        }else{
                                            $display='show';
                                            $active++;
                                        }
                                        ?>

                                        <?php if($display=='show'){ ?>
                                            <div class="item <?php echo ($active==1?'active':''); ?>">
                                                <div class="row">
                                                    <div class="col-xs-3 col-sm-3 col-md-3 text-center">
                                                        <a class="left fa fa-chevron-left btn nomargin" href="#carousel-example" data-slide="prev" style="color: gray; font-size: 20px;"></a>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
                                                        <h3 style="margin-top: 0px; margin-bottom: 30px;">
                                                            <?php // echo date('m月d日',strtotime($sot['store_order_time'])) ?>
                                                            <?php // $date = strtotime(date('Y-m-d') . "+".$i." days") ?>
                                                            <?php $date = strtotime($sotd['store_order_time']); ?>
                                                            <?php // echo date('Y-m-d', $date) ?>
                                                            <?php echo date('m月d日', $date).'('.get_chinese_weekday($sotd['store_order_time']).')' ?>
                                                        </h3>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3 text-center">
                                                        <a class="right fa fa-chevron-right btn nomargin" href="#carousel-example" data-slide="next" style="color: gray; font-size: 20px;"></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                <?php if(!empty($store_order_time)) { foreach($store_order_time as $sot) { ?>
                                                    <?php //if($sot['store_order_time']==date('Y-m-d', $date) && strtotime(date('H:i:s'))<strtotime($sot['store_close_time'])) { ?>
                                                    <?php if(strtotime($sot['store_order_time'])==$date){ ?>
                                                        <?php if($sot['store_order_time']==date('Y-m-d') && strtotime(date('H:i:s'))>strtotime($sot['store_close_time'])){ $show='hide'; } else { $show='show'; } ?>
                                                            <div class="col-xs-6 col-sm-6 col-md-4 <?php echo $show; ?>" style="margin-top: 30px;">
                                                                <div class="col-item">
                                                                    <div class="photo" style="display: flex;">
                                                                        <a href="/store/view/<?php echo $sot['store_order_time_id'] ?>?delivery_date=<?php echo $sot['store_order_time'] ?>">
                                                                            <?php // if ($active==1){ ?>
                                                                                <img src="/assets/uploads/<?php echo $sot['store_image'] ?>" class="img-responsive">
                                                                            <?php // } else { ?>
                                                                                <!-- <img data-src="/assets/uploads/<?php // echo $sot['store_image'] ?>" class="img-responsive lazy"> -->
                                                                            <?php // } ?>
                                                                        </a>
                                                                    </div>
                                                                    <div class="info">
                                                                        <h3 class="fs-16 text-left" style="margin-top: 5px;">
                                                                            <a href="/store/view/<?php echo $sot['store_order_time_id'] ?>?delivery_date=<?php echo $sot['store_order_time'] ?>" class="link color-595757 text-left"><?php echo $sot['store_name'] ?>
                                                                            </a>
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php //} ?>
                                                    <?php } ?>
                                                <?php }} ?>
                                                </div>
                                            </div>
                                        <?php } ?>


                                    <?php }} ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 hide" style="margin-top: 15px;">
                            <!-- Controls -->
                            <div class="controls text-center">
                                <a class="left fa fa-chevron-left btn btn-success" href="#carousel-example" data-slide="prev"></a>
                                <a class="right fa fa-chevron-right btn btn-success" href="#carousel-example" data-slide="next"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php // } ?>
            <!--  -->
        </div>
    </section>
</div>
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
// $(function() {
//     $('.lazy').lazy();
// });

$('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel'   : '<?php if(!empty($this->input->get('county'))){ echo $this->input->get('county'); } else { echo $users_address['county']; } ?>',
    'districtSel' : '<?php if(!empty($this->input->get('district'))){ echo $this->input->get('district'); } else { echo $users_address['district']; } ?>',
    'hideCounty' : [<?php if(!empty($hide_county)){ foreach($hide_county as $hc){ echo '"'.$hc.'",'; }} ?>],
    'hideDistrict': [<?php if(!empty($hide_district)){ foreach($hide_district as $hd){ echo '"'.$hd.'",'; }} ?>]
});

$('#carousel-example').carousel({
    interval: false,
    wrap: false,
});

function initMap111() {
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: { lat: 37.77, lng: -122.447 }
    });
    directionsDisplay.setMap(map);

    calculateAndDisplayRoute(directionsService, directionsDisplay);
    document.getElementById('mode').addEventListener('change', function() {
        calculateAndDisplayRoute(directionsService, directionsDisplay);
    });
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
    var selectedMode = 'DRIVING';
    directionsService.route({
        origin: { lat: 37.77, lng: -122.447 }, // Haight.
        destination: { lat: 37.768, lng: -122.511 }, // Ocean Beach.
        // Note that Javascript allows us to access the constant
        // using square brackets and a string value as its
        // "property."
        travelMode: google.maps.TravelMode[selectedMode]
    }, function(response, status) {
        if (status == 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            // For each route, display summary information.
            alert('距離: ' + route.legs[0].distance.text);
            alert('時間: ' + route.legs[0].duration.text);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
}

var map;
var panorama;

function initMap() {

    var directionsDisplay = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    var my_address = '<?php echo $this->input->get('county').$this->input->get('district').$this->input->get('address') ?>';
    var geocoder = new google.maps.Geocoder();

    // var berkeley = {lat: 37.869085, lng: -122.254775};
    var sv = new google.maps.StreetViewService();

    // 街景圖先拿掉，如要復原請把下列註解移除
    // panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'));
    // var myLatLng = {lat: 25.030908, lng: 121.431631};

    // Set up the map.
    map = new google.maps.Map(document.getElementById('map'), {
        //center: berkeley,
        zoom: 17,
        streetViewControl: false
    });

    // Set the initial Street View camera to the center of the map
    // sv.getPanorama({location: berkeley, radius: 50}, processSVData);

    // Look for a nearby Street View panorama when the map is clicked.
    // getPanorama will return the nearest pano when the given
    // radius is 50 meters or less.
    map.addListener('click', function(event) {
        sv.getPanorama({ location: event.latLng, radius: 50 }, processSVData);
    });

    // Start 我的位置
    geocoder.geocode({ 'address': my_address }, function(results, status) {
        if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map,
                icon: '<?php echo base_url() ?>assets/images/store/my-localtion2.png',
                title: 'my_localtion',
            });
            var infowindow = new google.maps.InfoWindow({
                content: '你的位置'
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
    // End 我的位置

    // var myLatLng1 = {lat: 25.068854, lng: 121.588722};
    // var marker1 = new google.maps.Marker({
    //     position: myLatLng1,
    //     map: map,
    //     icon : '<?php //echo base_url() ?>assets/images/store/point1.png',
    //     title: 'Hello'
    // });

    // Start 取餐點位置
    <?php $count=1; ?>
    <?php if(!empty($delivery_place)) { foreach($delivery_place as $data) { ?>
    <?php if($count<=4) { ?>
    var address = '<?php echo $data['delivery_place_county'].$data['delivery_place_district'].$data['delivery_place_address'] ?>';
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            // resultsMap.setCenter(results[0].geometry.location);
            var map<?php echo $data['delivery_place_id']; ?> = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map,
                icon: '<?php echo base_url() ?>assets/images/store/point1.png'
            });
            var infowindow<?php echo $data['delivery_place_id']; ?> = new google.maps.InfoWindow({
                content: '<?php echo $data['delivery_place_name']; ?>'
            });
            map<?php echo $data['delivery_place_id']; ?>.addListener('click', function(event) {
                sv.getPanorama({ location: event.latLng, radius: 50 }, processSVData);
                infowindow<?php echo $data['delivery_place_id']; ?>.open(map, map<?php echo $data['delivery_place_id']; ?>);
            });
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });

    // Start 兩地距離
    // function Distance() {
    // var start = "<?php echo $this->input->get('county').$this->input->get('district').$this->input->get('address') ?>";
    // var end = "<?php echo $data['delivery_place_county'].$data['delivery_place_district'].$data['delivery_place_address'] ?>";
    // var request = {
    //     origin: start,
    //     destination: end,
    //     travelMode: google.maps.DirectionsTravelMode.DRIVING
    // };
    // //宣告
    // var directionsService = new google.maps.DirectionsService();
    // directionsService.route(request, function (response, status) {
    //     var strTmp = "";
    //     if (status == google.maps.DirectionsStatus.OK) {
    //         var route = response.routes[0];
    //         for (var i = 0; i < route.legs.length; i++) {
    //             var routeSegment = i + 1;
    //             strTmp += route.legs[i].distance.text;
    //         }
    //         // 取得距離(正整數，公尺)
    //         // var dist = parseInt(parseFloat(strTmp) * 1000).toString();
    //         // 取得距離(正整數，公里)
    //         var dist = parseFloat(strTmp).toString();
    //         // alert(dist+'公里');
    //         // $('#delivery_place_distance_text<?php echo $data['delivery_place_id']?>').text(dist+'公里');
    //     }
    // });
    // }
    // End 兩地距離

    // Start 導航時間
    // var selectedMode = 'DRIVING';
    // directionsService.route({
    //     origin: {lat: 37.77, lng: -122.447},  // Haight.
    //     destination: {lat: 37.768, lng: -122.511},  // Ocean Beach.
    //     travelMode: google.maps.TravelMode[selectedMode]
    // }, function(response, status) {
    //     if (status == 'OK') {
    //         directionsDisplay.setDirections(response);
    //         var route = response.routes[0];
    //         // For each route, display summary information.
    //         // alert('距離: '+route.legs[0].distance.text);
    //         // alert('時間: '+route.legs[0].duration.text);
    //         var dist = route.legs[0].duration.text;
    //         $('#delivery_place_distance_text<?php // echo $data['delivery_place_id']?>').text(dist);
    //     } else {
    //         window.alert('Directions request failed due to ' + status);
    //     }
    // });
    // End 導航時間
    <?php $count++; ?>
    <?php } ?>
    <?php } } ?>
    // End 取餐點位置
}

function setMapToCenter(lat, lng) {
    map.setCenter(new google.maps.LatLng(lat, lng));
}

function processSVData(data, status) {
    if (status === 'OK') {
        // var marker = new google.maps.Marker({
        //     position: data.location.latLng,
        //     map: map,
        //     title: data.location.description
        // });

        panorama.setPano(data.location.pano);
        panorama.setPov({
            heading: 270,
            pitch: 0
        });
        panorama.setVisible(true);

        marker.addListener('click', function() {
            var markerPanoID = data.location.pano;
            // Set the Pano to use the passed panoID.
            panorama.setPano(markerPanoID);
            panorama.setPov({
                heading: 270,
                pitch: 0
            });
            panorama.setVisible(true);
        });
    } else {
        alert('這個位置找不到街景服務圖');
        // console.error('Street View data not found for this location.');
    }
}

function geocodeAddress(geocoder, resultsMap, address, id) {
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === 'OK') {
            // alert(results[0].geometry.location);
            // resultsMap.setCenter(results[0].geometry.location);
            var id = new google.maps.Marker({
                position: results[0].geometry.location,
                map: resultsMap,
                icon: '<?php echo base_url() ?>assets/images/store/point1.png'
            });
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

function show_store(data) {
    $('.store_item').hide()
    $('#' + data).fadeIn('fast');

    $('.date_btn').css('color', '#595757');
    $('#' + data + '_btn').css('color', '#FFB718');
}

function check_delivery_place() {
    var delivery_place = '<?php echo $this->session->userdata('delivery_place ') ?>';
    if (delivery_place != '') {
        $('#delivery_place_notice').fadeIn();
    } else {
        $('#delivery_place_notice').fadeOut();
        // $('#store_list_area').fadeIn();
    }

}

function set_delivery_place(id) {
    // $('#store_list_area').hide();
    // var delivery_place = $('#delivery_place').val();
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_delivery_place",
        method: "POST",
        data: { delivery_place: id },
        success: function(data) {
            // $('#delivery_place_notice').fadeIn();
        }
    });
}

function set_custom_address() {
    var custom_address = $('#custom_address').val();
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_custom_address",
        method: "POST",
        data: { custom_address: custom_address },
        success: function(data) {
            // $('#delivery_place_notice').fadeIn();
        }
    });
}

function set_delivery_date(id) {
    // var delivery_place = $('#delivery_place').val();
    $.ajax({
        url: "<?php echo base_url(); ?>cart/add_delivery_date",
        method: "POST",
        data: { delivery_date: id },
        success: function(data) {
            // $('#delivery_place_notice').fadeIn();
        }
    });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzfMl1G0OrMw6cdVydIA4vxiGFmX9P-TI&callback=initMap" type="text/javascript"></script>