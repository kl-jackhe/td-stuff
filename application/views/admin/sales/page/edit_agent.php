<div class="row">
    <div class="col-md-12" style="padding-bottom: 10px;">
        <?if ($SingleSalesDetail['status'] != 'Closure' && $SingleSalesDetail['status'] != 'Finish') {?>
        <span class="btn btn-primary" data-toggle="modal" data-target="#createAgent">
            建立代言人數量 <i class="fa-solid fa-plus"></i>
        </span>
        <span class="btn btn-info" data-toggle="modal" data-target="#selectAgentImport" style="margin-left: 10px;">
            匯入現有代言人 <i class="fa-solid fa-file-import"></i>
        </span>
        <?}?>
    </div>
    <div class="col-md-12" style="overflow-x: auto;">
        <table class="table table-bordered table-striped table-hover" style="border-radius: 10px;margin-top: 20px;" id="data-table">
            <thead>
                <tr class="info">
                    <th>排序</th>
                    <th>網站名稱 / 外觀</th>
                    <th>銷售網址</th>
                    <th>代言人ID / 名稱</th>
                    <th>利潤百分比</th>
                    <th>狀態</th>
                </tr>
            </thead>
            <tbody>
                <? if (!empty($SingleSalesAgentDetail)) {
                $count = 0;
                foreach ($SingleSalesAgentDetail as $row) {
                    $json = json_decode($row['single_sales_agent_name_style']);
                    $count++;?>
                <tr>
                    <td>
                        <input type="hidden" name="single_sales_agent_id[]" value="<?=$row['single_sales_agent_id']?>">
                        <input type="hidden" id="agent_id_<?=$row['single_sales_agent_id']?>" value="<?=$row['agent_id']?>">
                        <?=$count?>
                    </td>
                    <td>
                        <input type="text" id="single_sales_agent_name_<?=$row['single_sales_agent_id']?>" value="<?=$row['single_sales_agent_name']?>" class="form-control">
                        <div class="input-group">
                            <span class="input-group-addon">字體顏色</span>
                            <input type="color" id="color_style_<?=$row['single_sales_agent_id']?>" value="<?=(isset($json->color_style) ? ($json->color_style != '' ? $json->color_style : '#000000') : '#000000')?>" class="form-control">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">字體大小</span>
                            <select class="form-control" id="font_size_style_<?=$row['single_sales_agent_id']?>">
                                <option value="">請選擇</option>
                                <?$font_size = 18;
                                for ($i=0;$i<7;$i++) {
                                    $font_size += 2;
                                    $font_size_srt = $font_size . 'px';
                                    if (isset($json->font_size_style)) {
                                        if ($json->font_size_style == $font_size_srt) {?>
                                <option value="<?=$font_size_srt?>" selected>
                                    <?=$font_size?> px</option>
                                <?} else {?>
                                <option value="<?=$font_size_srt?>">
                                    <?=$font_size?> px</option>
                                <?}
                                } else {?>
                                <option value="<?=$font_size_srt?>">
                                    <?=$font_size?> px</option>
                                <?}
                                }?>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">底色</span>
                            <input type="color" id="background_color_style_<?=$row['single_sales_agent_id']?>" value="<?=(isset($json->background_color_style) ? ($json->background_color_style != '' ? $json->background_color_style : '#000000') : '#000000')?>" class="form-control">
                        </div>
                        <!-- <div><span style="<?=$row['single_sales_agent_name_style']?>"><?=$row['single_sales_agent_name']?></span></div> -->
                        <div class="input-group">
                            <span class="input-group-addon">時間文字</span>
                            <input type="text" id="time_description_<?=$row['single_sales_agent_id']?>" value="<?=$row['time_description']?>" class="form-control" placeholder="預設文字〔剩餘時間〕">
                        </div>
                    </td>
                    <td>
                        <?if (!empty($SingleSalesDetail)) {?>
                        <!-- <p class="m-0"><?=$SingleSalesDetail['url'] . '?aid=' . $row['agent_id']?></p> -->
                        <a href="<?=$SingleSalesDetail['url'] . '?aid=' . $row['agent_id']?>" class="copy-link" onclick="copyLink(event)">點擊這裡複製連結&emsp;<i class="fa-regular fa-copy"></i></a>
                        <?}?>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <?=$row['agent_id']?></span>
                            <input type="text" id="agent_name_<?=$row['single_sales_agent_id']?>" value="<?=$row['agent_name']?>" class="form-control">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="number" max="100" min="0" id="profit_percentage_<?=$row['single_sales_agent_id']?>" value="<?=($row['profit_percentage'] > 0 ? format_number($row['profit_percentage']) : format_number($SingleSalesDetail['default_profit_percentage']))?>" class="form-control">
                            <span class="input-group-addon">%</span>
                        </div>
                    </td>
                    <td>
                        <p>狀態：
                            <?=($row['status'] == true ? '啟用中' : '停用中')?>
                        </p>
                        <p>建立時間：
                            <?=$row['created_at']?>
                        </p>
                        <p>更新時間：
                            <?=$row['updated_at']?>
                        </p>
                    </td>
                </tr>
                <?}
                } else { ?>
                <tr>
                    <td colspan="15">
                        <center>
                            <?php echo $this->lang->line('no_data') ?>
                        </center>
                    </td>
                </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
</div>