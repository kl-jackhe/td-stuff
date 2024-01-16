<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="row product_tag_box my-5">
                <?php if (!empty($product_tag)) : ?>
                    <div class="col-12">
                        <div class="py-2" style="padding: 30px;">
                            <a href="/">回冰箱</a>
                            <span>&nbsp;/&nbsp;</span>
                            <span><?= $product_tag['name']; ?></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr class="py-2" style="border-top: 1px solid #988B7A;">
                    </div>
                    <div id="data" class="col-12">
                        <?php require 'ajax-data.php'; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>