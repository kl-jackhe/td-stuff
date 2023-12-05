<style>
    #view_position {
        margin-top: 100px;
    }
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container" style="padding-top: 25px; padding-bottom: 25px;">
            <!-- Post Start -->
            <div id="view_position" class="row">
                <div class="col-md-10 offset-md-1">
                    <?php if (!empty($post['post_image'])) { ?>
                        <div class="form-group">
                            <img src="/assets/uploads/<?php echo $post['post_image'] ?>" class="img-fluid" alt="<?php echo $post['post_title'] ?>">
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <p style="margin-bottom: 3px;"><?php echo substr($post['created_at'], 0, 10) ?></p>
                        <h2 class="font-weight-bold"><?php echo $post['post_title'] ?></h2>
                        <p><?php echo $post['post_content'] ?></p>
                    </div>
                </div>
            </div>
            <!-- Post End -->
        </div>
    </section>
</div>