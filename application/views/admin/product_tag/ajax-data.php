<?php echo $this->ajax_pagination->create_links(); ?>
<style>
.modal-backdrop {
    z-index: -1;
}
.modal.in .modal-dialog {
    margin: 10% auto;
}
.tabbable .nav-tabs>li.active>a, .tabbable .nav-tabs>li.active>a:hover, .tabbable .nav-tabs>li.active>a:focus {
    z-index: 0;
}
</style>
<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead>
        <tr class="info">
            <th><?=$this->lang->line('current_name') . ' ' . $this->lang->line($this->language);?></th>
            <?if (count($language_list) > 1) {?>
                <th><?=$this->lang->line('other_lang')?></th>
            <?}?>
            <th><?=$this->lang->line('product_count')?></th>
            <th class="text-center"><?=$this->lang->line('sort')?></th>
            <th class="text-center"><?=$this->lang->line('status')?></th>
        </tr>
    </thead>
    <?if (!empty($product_tag)) {
        foreach ($product_tag as $data) {
            $productTagContentList = $this->product_tag_model->getProductTagContentList($data['id']);
            $productNameList = '';
            if (!empty($productTagContentList)) {
                foreach ($productTagContentList as $ptcl_row) {
                    $productNameList .= get_lang('product_name', $ptcl_row['product_id'], $this->language);
                    if (count($productTagContentList) > 1) {
                        $productNameList .= '<br>';
                    }
                }
            }?>
            <tr>
                <td>
                    <span class="product_tag_edit_style" onclick="updateProductTagModal('<?=$data['id']?>','<?=$data['sort']?>')">
                        <?=getProductTagName($data['id'],$this->language)?>
                        <i class="fas fa-edit"></i>
                    </span>
                </td>
                <?if (count($language_list) > 1) {?>
                    <td>
                        <?$count = 0;
                        foreach ($language_list as $lang_row) {
                            if ($this->language != $lang_row) {
                                if ($count > 0) {
                                    echo '<br>';
                                }
                                if (getProductTagName($data['id'],$lang_row) != '') {
                                    echo $this->lang->line($lang_row) . ' - ' . getProductTagName($data['id'],$lang_row);
                                }
                                $count++;
                            }
                        }?>
                    </td>
                <?}?>
                <td>
                    <div class="row">
                        <div class="col-md-6">
                            <?if ($productNameList != '') {?>
                                <span data-html="true" data-container="body" data-toggle="tooltip" data-placement="right" data-original-title="<?=$productNameList?>">
                                    <?=count($productTagContentList)?> <i class="fa-solid fa-circle-info"></i>
                                </span>
                            <?}?>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="product_tag_edit_style" onclick="updateProductTagContentModal('<?=$data['id']?>')">
                                <?=$this->lang->line('edit')?> <i class="fas fa-edit"></i>
                            </span>
                        </div>
                    </div>
                </td>
                <td class="text-center"><?=$data['sort']?></td>
                <td class="text-center">
                    <span class="btn btn-<?=($data['status'] == 1 ? 'primary' : 'danger')?>" onclick="updateProductTagStatus('<?=$data['id']?>','<?=$data['status']?>')">
                        <?=$this->lang->line(($data['status'] == 1 ? 'on_the_shelf_now' : 'off_the_shelf_now')) ?> <i class="fa-solid fa-circle-<?=($data['status'] == 1 ? 'up' : 'down')?>"></i>
                    </span>
                    <span class="btn btn-danger" style="margin-left: 10px;" onclick="removeSingleProductTag('<?=$data['id']?>')"><?=$this->lang->line('remove')?> <i class="fa-solid fa-dumpster-fire"></i></span>
                </td>
            </tr>
        <?}
    } else {?>
        <tr>
            <td colspan="15">
                <center>
                    <?php echo $this->lang->line('no_data') ?>
                </center>
            </td>
        </tr>
    <?}?>
</table>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>