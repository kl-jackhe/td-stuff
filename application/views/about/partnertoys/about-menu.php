<div class="searchContainer container">
    <!-- 篩選清單呼叫鈕 -->
    <div class="left-content">
        <span id="menu-btn" @click="toggleNav">
            <h1 v-if="!isNavOpen" class="">夥伴商城 <i class="fa fa-caret-down"></i></h1>
            <h1 v-else id="menu-btn" :class="{ 'active': isBtnActive }">夥伴商城 <i class="fa fa-times" aria-hidden="true"></i></h1>
        </span>
    </div>
    <!-- 篩選清單呼叫鈕 -->
</div>
<div :class="{ 'section-sidemenu': true, 'nav-open': isNavOpen }">
    <h1 class=""><span><?= !empty($page_title) ? $page_title : '' ?></span></h1>
    <!-- 篩選清單 -->
    <ul class="menu-main">
        <div v-for="category in about_category">
            <li v-if="category.status == 1" :key="category.sort">
                <input type="button" :value="'>&nbsp;' + category.name" @click="filterByCategory(category.sort)" :class="{ category_btn: true, active: selectedCategoryId === category.sort}">
            </li>
        </div>
    </ul>
    <!-- 篩選清單 -->
</div>