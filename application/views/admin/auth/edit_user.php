<style>
.form-horizontal .control-label{
    text-align: left;
}
</style>
<div class="row">
    <div class="col-md-6">
        <?php $att = "class='form-horizontal'"; ?>
        <?php echo form_open(uri_string(), $att);?>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">修改</button>
                <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
                <hr>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">姓名</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $user->full_name ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">電子信箱</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->email ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">更改密碼</label>
            <div class="col-md-9">
                <?php echo form_input($password);?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">確認密碼</label>
            <div class="col-md-9">
                <?php echo form_input($password_confirm);?>
            </div>
        </div>

        <?php if ($this->ion_auth->is_admin()): ?>
        <h3>帳號群組</h3>
        <?php foreach ($groups as $group):?>
        <div class="checkbox">
          <label class="checkbox">
            <?php
            $gID=$group['id'];
            $checked = null;
            $item = null;
            foreach($currentGroups as $grp) {
              if ($gID == $grp->id) {
                $checked= ' checked="checked"';
                break;
              }
            } ?>
            <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
            <?php echo htmlspecialchars($group['description'],ENT_QUOTES,'UTF-8');?>
          </label>
        </div>
        <?php endforeach?>
        <?php endif ?>
        <?php echo form_hidden('id', $user->id);?>
        <?php echo form_hidden($csrf); ?>
        <?php echo form_close() ?>
    </div>
</div>