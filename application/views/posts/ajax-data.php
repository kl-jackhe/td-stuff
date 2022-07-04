<?php if(!empty($posts)) { foreach($posts as $post) { ?>
<!-- Post Start -->
<div class="row">
    <div class="col-md-3 offset-md-1 text-center">
        <?php if(!empty($post['post_image'])){ ?>
        <div class="form-group">
            <img src="/assets/uploads/<?php echo $post['post_image'] ?>" class="img-fluid" alt="<?php echo $post['post_title'] ?>">
        </div>
        <?php } ?>
    </div>
    <div class="col-md-7">
        <p style="margin-bottom: 3px;"><?php echo substr($post['created_at'], 0, 10) ?></p>
        <h5 class="font-weight-bold"><?php echo $post['post_title'] ?></h5>
        <p><?php echo html_excerpt($post['post_content'], 110) ?></p>
        <p class="text-right">
            <a href="/posts/view/<?php echo $post['post_id'] ?>">more+</a>
        </p>
    </div>
    <!-- <div class="col-md-11">
        <br style="padding-bottom: 10px;">
    </div> -->
</div>
<!-- Post End -->
<?php }} ?>