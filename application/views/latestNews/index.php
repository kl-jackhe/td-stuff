<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="row product_box">
                <div class="col-12">
                    <div class="row justify-content-center text-center">
                        <?php foreach ($news_data as $row) : ?>
                            <p><?php echo $row['subject']; ?></p>
                            <!-- 其他資料 -->
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="data" class="col-12">
                </div>
            </div>
        </div>
    </section>
</div>