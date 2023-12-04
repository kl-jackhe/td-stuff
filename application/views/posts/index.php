<style>
    #post_rejust {
        padding-top: 25px;
        padding-bottom: 25px;
        margin-top: 100px;
    }

    .section-contents h1 span,
    .section-contents-one h1 span {
        display: inline-block;
        height: 40px;
        color: #d35448;
        border-bottom: 2px solid #d35448;
        padding: 0 15px;
    }

    .section-contents h1,
    .section-contents-one h1 {
        height: 40px;
        font-size: 22px;
        line-height: 40px;
        border-bottom: 2px solid #ddd;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .selectWebList {
        padding: 0 0 0 30px;
    }

    .selectWebList a:hover {
        color: #e07f55;
        text-decoration: none;
    }

</style>

<div role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <div class="container" bis_skin_checked="1">
            <div class="crumb" bis_skin_checked="1">
                <ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li class="selectWebList" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a href="/" title="首頁" itemprop="item">
                            <i class="fas fa-h-square"></i><span itemprop="name">首頁</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                    <li class="selectWebList" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a href="/Posts" title="最新訊息" itemprop="item">
                            <span itemprop="name">最新訊息</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </li>

                    <?php foreach($posts_category as $category): ?>
                    <li class="selectWebList" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a href="/Posts" title="<?php echo $category['post_category_name']?>" itemprop="item">
                            <span itemprop="name"><?php echo $category['post_category_name']?></span>
                        </a>
                        <meta itemprop="position" content="2">
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="section-contents">
            <div class="container">
                <h1><span>最新訊息</span></h1>
            </div>
            <div class="container">
                <?php require('ajax-data.php') ?>
            </div>
        </div>
    </section>
</div>