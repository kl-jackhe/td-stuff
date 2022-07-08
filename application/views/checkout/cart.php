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
</style>
<div role="main" class="main">
    <section class="form-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-8 px-4">
                    <h1>您共選擇 ( 1 項目 )</h1>
                    <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col" class="text-nowrap">商品</th>
                              <th scope="col" class="text-nowrap">價格</th>
                              <th scope="col" class="text-nowrap">數量</th>
                              <th scope="col" class="text-nowrap">小計</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td>貼布</td>
                              <td class="text-danger">NT$199</td>
                              <td>1</td>
                              <td class="text-danger">NT$199</td>
                            </tr>
                            <tr>
                              <th scope="row">2</th>
                              <td>杯子</td>
                              <td class="text-danger">NT$300</td>
                              <td>2</td>
                              <td class="text-danger">NT$600</td>
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end">
                        <button class="btn-primary btn font-weight-bold">清除全部</button>
                        <button class="btn-primary btn mx-4 font-weight-bold">更新購物車</button>
                    </div>
                </div>
                <div class="col-12 col-md-4 px-5">
                    <h1>購物車總計</h1>
                    <div class="row">
                        <hr style="border-top: 1px solid gray;width: 100%;">
                        <div class="col-6">
                            小計
                        </div>
                        <div class="col-6 text-right text-danger">
                            NT$799
                        </div>
                        <hr style="border-top: 1px solid gray;width: 100%;">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            運送方式
                        </div>
                        <div class="col-12">
                            超商取貨
                        </div>
                    </div>
                    <div class="row">
                        <hr style="border-top: 1px solid gray;width: 100%;">
                        <div class="col-6">
                            總計
                        </div>
                        <div class="col-6 text-right text-danger">
                            NT$799
                        </div>
                        <hr style="border-top: 1px solid gray;width: 100%;">
                    </div>
                    <div class="col-12 btn-primary btn font-weight-bold">前往結帳</div>
                    <div class="col-12 btn-primary btn my-4 font-weight-bold">繼續選購商品 <i class="fa-solid fa-arrow-right-long"></i></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function getLiffUserID() {
        if (LIFF_userID != "") {
            alert(LIFF_userID);
        } else {
            console.log("等候LIFF加載...");
            setTimeout("getLiffUserID()", 300);
        }
    };

    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
        'countySel'   : '<?php if (!empty($users_address)) {echo $users_address['county'];} else {echo $this->input->get('county');}?>',
        'districtSel' : '<?php if (!empty($users_address)) {echo $users_address['district'];} else {echo $this->input->get('district');}?>',
        'hideCounty' : [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
        'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
    });
</script>