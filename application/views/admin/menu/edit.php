<div class="row">
    <? $attributes = array('class' => 'update', 'id' => 'update'); ?>
    <? echo form_open('admin/menu/update/' . $databaseName, $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <span onclick="returnSubMenu()" class="btn btn-primary" style="margin: 20px 20px 20px 0;">
                <i class="fa fa-reply" aria-hidden="true"></i>&nbsp;返回
            </span>
            <span id="update-btn" class="btn btn-primary" style="margin: 20px 20px 20px 0;">更新</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#general" aria-controls="general" role="tab" data-toggle="tab">編輯資料</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                        <div class="row">
                            <input type="hidden" class="form-control" id="id" name="id" value="<? echo $menu['id'] ?>" required>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">選單名稱</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<? echo $menu['name'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">類型</label>
                                    <input type="text" class="form-control" id="type" name="type" value="<? echo $menu['type'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sort">排序</label>
                                    <input type="text" class="form-control" id="sort" name="sort" value="<? echo $menu['sort'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">狀態</label>
                                    <select class="form-control" name="status">
                                        <? if (!empty($menu['status'])) { ?>
                                            <option value="1" selected>✔️開啟</option>
                                            <option value="0">❌關閉</option>
                                        <? } else { ?>
                                            <option value="1">✔️開啟</option>
                                            <option value="0" selected>❌關閉</option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if ($databaseName != 'menu' && $databaseName != 'sub_menu') : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">內容描述</label>
                                        <textarea id="editor" name="description"><?= $menu['description'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? echo form_close() ?>
</div>
<script src="/assets/ckeditor5-build-classic/ckeditor.js"></script>
<script>
    // ajax 一定要寫在裡面不然會讀不到editor
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            $('#update-btn').click(function(e) {
                var editid = $('#id').val();
                var editName = $('#name').val();
                var editSort = $('#sort').val();

                if (editSort == 0) {
                    alert('更新失敗排序不可為NULL');
                    return;
                }
                <?php if (!empty($same_level_menu)) : ?>
                    <?php foreach ($same_level_menu as $self) : ?>
                        if (editSort == <?= json_encode($self['sort']) ?>) {
                            if (editid != <?= json_encode($self['id']) ?>) {
                                alert('更新失敗排序不可重複');
                                return;
                            }
                        }
                        if (editName == <?= json_encode($self['name']) ?>) {
                            if (editid != <?= json_encode($self['id']) ?>) {
                                alert('更新失敗名稱不可重複');
                                return;
                            }
                        }
                    <?php endforeach; ?>
                <?php endif; ?>

                // 更新 <textarea> 的值
                editor.updateSourceElement();

                // send ajax data to backend
                e.preventDefault();
                var form = $('#update');
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(data) {
                        if (data == '更新成功') {
                            location.reload(true);
                        } else {
                            console.log(data);
                        }
                    },
                    error: function(data) {
                        console.log('無法送出');
                    }
                })
            });
        })
        .catch(error => {
            console.error(error);
        });

    function returnSubMenu() {
        window.history.back();
    }

    $(document).ready(function() {
        $(document).on('click', '.x', function() {
            $(this).parent().parent().remove();
        });
        $('#any_specification').click(function() {
            if ($("#any_specification").is(":checked") == true) {
                $('#any_specification').val('1');
            } else {
                $('#any_specification').val('0');
            }
        });
    });
</script>