<style>
    .active {
        background-color: #d35448;
        font-weight: bold;
    }

    .breadcrumb {
        display: flex;
        justify-content: center;
        list-style: none;
        /* padding: 0; */
    }

    .breadcrumb li {
        margin: 0 10px;
        /* 可根據需要調整按鈕之間的距離 */
    }

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

    #post_rejust {
        padding-top: 25px;
        padding-bottom: 25px;
        margin-top: 70px;
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

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: 2px solid #e07f55;
        color: #e07f55;
        border-radius: 5px;
        transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -webkit-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
    }

    .btn.active,
    .btn:hover {
        background-color: #d35448;
        color: #fff;
    }
</style>

<script src="https://unpkg.com/vue@next"></script>

<div id="app" role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <div class="container">
            <div class="crumb">
                <ul class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li v-for="category in categories" :key="category.post_category_id">
                        <input type="button" :value="category.post_category_name" @click="filterByCategory(category.post_category_id)" :class="{ btn: true, active: selectedCategoryId === category.post_category_id}">
                    </li>
                </ul>
            </div>
        </div>
        <div class="section-contents">
            <div class="container">
                <h1><span>最新訊息</span></h1>
            </div>
            <div class="container">
                <!-- 這裡顯示你的文章內容 -->
                <div v-for="self in filteredPosts" :key="self.post_id">
                    <a class="font_color" :href="'/posts/view/' + self.post_id">
                        <div class="row touch_effect">
                            <div class="col-md-3 offset-md-1 text-center">
                                <img :src="'/assets/uploads/' + self.post_image" class="img-fluid" :alt="self.post_title">
                            </div>
                            <div class="col-md-7">
                                <p id="postsDate">{{ self.created_at.substr(0, 10) }}</p>
                                <h3 class="font-weight-bold">{{ self.post_title }}</h3>
                                <p>{{ customExcerpt(self.post_content, 110) }}</p>
                                <p class="text-right">more+</p>
                            </div>
                        </div>
                    </a>
                    <!-- Post End -->
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const app = Vue.createApp({
        data() {
            return {
                categories: <?php echo json_encode($posts_category); ?>,
                selectedCategoryId: 1,
                posts: <?php echo json_encode($posts); ?>,
            };
        },
        computed: {
            filteredPosts() {
                if (this.selectedCategoryId == 1) {
                    return this.posts;
                } else {
                    return this.posts.filter(self => self.post_category === this.selectedCategoryId);
                }
            },
        },
        methods: {
            filterByCategory(categoryId) {
                this.selectedCategoryId = categoryId;
                // 檢查過濾後的文章
                // console.log('Selected Category ID:', categoryId);
                // console.log('Filtered Posts:', this.filteredPosts);
            },
            customExcerpt(content, maxLength) {
                // 使用 DOMParser 解析 HTML 字符串
                const doc = new DOMParser().parseFromString(content, 'text/html');

                // 從解析後的文檔中提取純文本內容
                const plainText = doc.body.textContent || "";

                // 截取文本，確保不超過指定的最大長度
                const truncatedText = plainText.length > maxLength ?
                    plainText.substring(0, maxLength) + "..." :
                    plainText;

                return truncatedText;
            },
        },
    });

    app.mount('#app');
</script>