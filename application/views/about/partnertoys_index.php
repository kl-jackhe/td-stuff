<div id="aboutApp" role="main" class="main pt-signinfo">
    <section id="post_rejust">
        <?php require('about-menu.php'); ?>
        <div id="aboutContent" class="section-contents">
            <div class="container">
                <h1><span>{{ pageTitle }}</span></h1>
            </div>
            <!--M_contents-->
            <div id="M_contents" class="animated fadeIn" bis_skin_checked="1">
                <!--內文區塊↓-->
                <style>
                    /* 編輯器圖片 */
                    .edit img {
                        max-width: 100%;
                        height: auto !important;
                    }
                </style>
                <div class="edit" bis_skin_checked="1">
                    <p style="text-align: center;">
                        <span style="font-size: 14pt; font-family: 微軟正黑體, 'Microsoft JhengHei';">
                            <strong>品牌介紹</strong>
                        </span>
                    </p>
                    <p style="text-align: center;">
                        <span style="font-size: 14pt; font-family: 微軟正黑體, 'Microsoft JhengHei';">
                            <strong>About PartnerToys</strong>
                        </span>
                    </p>
                    <p style="text-align: center;">
                        <span style="font-size: 12pt;">夥伴，讓蒐藏變成一種情感，<br>玩具，讓壓力變成一種療癒。</span>
                    </p>
                    <p style="text-align: center;">
                        <img id="aboutImg" src="/assets/uploads/aboutContent.jpg" alt="">
                    </p>
                </div> <!--內文區塊↑-->
            </div>
    </section>
</div>

<script>
    const aboutApp = Vue.createApp({
        data() {
            return {
                pageTitle: '品牌介紹', // 目前標籤
                isNavOpen: false, // nav搜尋標籤初始狀態為關閉
                isBtnActive: false, // nav-btn active state
            }
        },
        methods: {
            // 篩選清單呼叫
            toggleNav() {
                this.isNavOpen = !this.isNavOpen;
                this.isBtnActive = !this.isBtnActive;
            },
        },
    });
    aboutApp.mount('#aboutApp');
</script>