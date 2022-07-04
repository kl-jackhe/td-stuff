<div role="main" class="main">
	<section class="page-header no-padding sm-slide-fix">
        <div class="row">
            <div class="owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": false, "nav":false, "dots":true,"autoplay": false,"autoplayTimeout": 6000}'>
                <a href="#" class="banner slidebanner">
                    <img src="/assets/images/active_01.jpg" alt="Banner">
                </a>
                <a href="#" class="banner slidebanner">
                    <img src="/assets/images/active_02.jpg" alt="Banner">
                </a>
                <a href="{{url('active2')}}" class="banner slidebanner">
                    <img src="/assets/images/active_03.jpg" alt="Banner">
                </a>
            </div>
        </div>
    </section>
    <section class="form-section">
        <div class="container">
            <div class="searchbox collapse in " id="essearch">
                <!-- {{Form::open(['method' => 'post', 'url' => 'lunch/search'])}} -->
                <div class="row">
                    <div class="col-md-4 border-box">
                        <div class="row">
                            <div class="col-md-12">
                                <label>送達地點</label>
                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-control-custom dropdown-toggle">
                                            <!-- {{ Form::select('area_parent_id', $area_parents, '', array('id'=>'area_parent_id', 'onChange' => "getChildrenList(this.value, 'area', '#area_id')", 'placeholder' => '請選擇')) }} -->
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-control-custom dropdown-toggle">
                                            <!-- {{ Form::select('area_id', array(), '', array('id' => 'area_id', 'placeholder' => '請選擇')) }} -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border-box">
                        <div class="row">
                            <div class="col-md-12">
                                <label>送達時間</label>
                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-control-custom dropdown-toggle">
                                            <input type="text" id="from_date" name="from_date" class="form-control" placeholder="請選擇日期" data-provide="datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-control-custom dropdown-toggle">
                                            <input type="text" id="to_date" name="to_date" class="form-control" placeholder="請選擇日期" data-provide="datepicker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 border-box">
                        <label>商品分類</label>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-control-custom dropdown-toggle">
                                    <!-- {{ Form::select('type_id', $type_list, old('type_id'), array('placeholder' => '輸入類型')) }} -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="middle">
                            <button class="btn btn-block btn-rounder btn-info btn-block" >搜尋</button>
                        </div>
                    </div>
                    <hr class="xs-visible">
                </div>
                <!-- {{Form::close()}} -->
            </div>
            <!-- @include('admin.elements.success_message') -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-scroll">跨區熱門午餐</h3>
                    <div class="owl-carousel owl-theme stage-margin" stage-margin data-plugin-options='{"responsive": {"0": {"items": 1}, "479": {"items": 1}, "768": {"items": 2}, "979": {"items": 3}, "1199": {"items": 4}}, "loop": false, "autoHeight": true, "margin": 10, "nav": false, "stagePadding": 40}'>
                    @foreach($lunches as $lunch)
                        <div class="card" >
                            <div class="tag-over" id="cuttime_{{$lunch->id}}">{{$lunch->cut_time}}</div>

                            <img class="img-responsive" src="
                            {{asset($lunch->supplier->image)}}">

                            <h2><a href="{{url('shoppingcart/item/'.$lunch->id)}}" id="item_{{$lunch->id}}" class="link">{{$lunch->name}} </a></h2>
                            <p><i class="fa fa-map-marker"></i> &nbsp;{{$lunch->supplier->getAreaParentName()}}{{$lunch->supplier->getAreaName()}}{{$lunch->supplier->road}}</p>
                            <hr>
                            @if ($lunch->addresses->count() > 0) 
                            <h3>送達時間：{{$lunch->addresses->first()->deliver_time}}</h3>	
                            直送：
                            <ul class="add">
                                <li>[{{$lunch->addresses->first()->getAreaParentName()}}][{{$lunch->addresses->first()->getAreaName()}}]{{$lunch->addresses->first()->road}}</li>
                                <li class="last">總共{{$lunch->addresses()->count()}}個直送地點</li> 
                            </ul>
                            <hr>
                            @endif
                            <p>目前 {{$lunch->numberOfBuy()}} 人下單　已賣出 {{$lunch->soldQuantity()}} 份<br>剩下 {{$lunch->remainQuantity()}} 份</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3 class="title-scroll">熱門美食</h3>
                    <div class="owl-carousel owl-theme stage-margin" stage-margin data-plugin-options='{"responsive": {"0": {"items": 1}, "479": {"items": 1}, "768": {"items": 2}, "979": {"items": 3}, "1199": {"items": 4}}, "loop": false, "autoHeight": true, "margin": 10, "nav": false, "stagePadding": 40}'>
                        @foreach($hots as $hot)
                        <div class="card" >
                            <div class="tag-over" id="cuttime_{{$lunch->id}}_hot">{{$hot->cut_time}}</div>
                            <img class="img-responsive" src="{{asset($hot->supplier->image)}}">
                            <h2><a href="{{url('shoppingcart/item/'.$hot->id)}}" class="link">{{$hot->name}} </a></h2>
                            <p><i class="fa fa-map-marker"></i> &nbsp;{{$hot->supplier->getAreaParentName()}}{{$hot->supplier->getAreaName()}}{{$hot->supplier->road}}</p>
                            <hr>
                            @if ($hot->addresses->count() > 0) 
                            <h3>送達時間：{{$hot->addresses->first()->deliver_time}}</h3>  
                            直送：
                            <ul class="add">
                                <li>[{{$hot->addresses->first()->getAreaParentName()}}][{{$hot->addresses->first()->getAreaName()}}]{{$hot->addresses->first()->road}}</li>
                                <li class="last">總共{{$hot->addresses()->count()}}個直送地點</li> 
                            </ul>
                            <hr>
                            @endif
                            <p>目前 {{$hot->numberOfBuy()}} 人下單　已賣出 {{$hot->soldQuantity()}} 份<br>剩下 {{$hot->remainQuantity()}} 份</p>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </section>
</div>