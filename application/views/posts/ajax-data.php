<style>
    .touch_effect {
        border: 1px solid #eaeaea;
        padding: 30px 15px;
        background: #fff;
        border-radius: 15px;
        margin-top: 30px;
        position: relative;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .touch_effect:hover {
        -webkit-box-shadow: 0 10px 50px 0 rgba(84, 110, 122, .35);
        box-shadow: 0 10px 50px 0 rgba(84, 110, 122, .35)
    }

    .font_color {
        font-size: .9375rem;
        line-height: 20px;
        color: black;
    }

    .font_color:hover {
        color: #e07f55;
        text-decoration: none;
    }

    #postsDate {
        margin-bottom: 3px;
    }
</style>

<?php if (!empty($posts)) {
    foreach ($posts as $post) { ?>
        <!-- Post Start -->
        <a class="font_color" href="/posts/view/<?php echo $post['post_id'] ?>">
            <div class="row touch_effect">
                <div class="col-md-3 offset-md-1 text-center">
                    <?php if (!empty($post['post_image'])) { ?>
                        <img src="/assets/uploads/<?php echo $post['post_image'] ?>" class="img-fluid" alt="<?php echo $post['post_title'] ?>">
                    <?php } ?>
                </div>
                <div class="col-md-7">
                    <p id="postsDate"><?php echo substr($post['created_at'], 0, 10) ?></p>
                    <h3 class="font-weight-bold"><?php echo $post['post_title'] ?></h3>
                    <p><?php echo html_excerpt($post['post_content'], 110) ?></p>
                    <p class="text-right">more+</p>
                </div>
            </div>
        </a>
        <!-- Post End -->
<?php }
} ?>