<div role="main" class="main">
    <section class="form-section content_auto_h">
        <div class="container">
            <div class="col-12">
                <div class="row justify-content-center text-center">
                    <?php foreach ($news_data as $row) : ?>
                        <div class="col-lg-4 col-md-3 col-sm-12">
                            <li><? echo $row['subject']; ?></li>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr class="py-2" style="border-top: 1px solid #988B7A;">
            </div>
        </div>
    </section>
</div>