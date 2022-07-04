<h4>　</h4>
<?php $count=1; ?>
<?php if(!empty($delivery_place)) { foreach($delivery_place as $data) { ?>
<?php if($count<4){ ?>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <div class="form-check" onclick="set_delivery_place('<?php echo $data['delivery_place_id'] ?>');setMapToCenter(<?php echo $data['delivery_place_lat'] ?>,<?php echo $data['delivery_place_lng'] ?>)">
                <input type="radio" class="form-check-input" id="materialChecked<?php echo $data['delivery_place_id'] ?>" name="delivery_place" <?php if($this->session->userdata('delivery_place')==$data['delivery_place_id']) {echo 'checked';} ?>>
                <label class="form-check-label fs-13 color-59757 font-normal" for="materialChecked<?php echo $data['delivery_place_id'] ?>">
                    <?php echo $data['delivery_place_name'] ?></label>
            </div>
        </div>
    </div>
    <div class="col-md-4 delivery_place_distance_text_area">
        <span class="text-info fs-10 color-00BFD5 bold" id="delivery_place_distance_text<?php echo $data['delivery_place_id'] ?>">
            <?php echo $data['distance'] ?>公尺
            <?php echo round($data['distance']/60) ?>分鐘</span>
    </div>
</div>
<?php } ?>
<?php $count++; ?>
<?php } } ?>