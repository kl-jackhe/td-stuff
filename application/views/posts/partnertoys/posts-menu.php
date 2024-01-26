<div class="searchContainer container">
    <!-- 篩選清單呼叫鈕 -->
    <div class="left-content">
        <span v-if="!isNavOpen" id="menu-btn" @click="toggleNav">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </span>
        <span v-else id="menu-btn" :class="{ 'active': isBtnActive }" @click="toggleNav">
            <i class="fa fa-times" aria-hidden="true"></i>
        </span>
    </div>
    <!-- 篩選清單呼叫鈕 -->

    <!-- 搜尋攔 -->
    <div :class="{ 'right-content': true, 'breadcrumb': true, 'section-sidesearch': true, 'search-open': hiddenSearch }">
        <input type="text" class="search" placeholder="搜尋欄" v-model="searchText">
        <span v-if="searchText !== ''" @click="clearSearch" class="clear-search"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
    <!-- 搜尋攔 -->
</div>
<div :class="{ 'section-sidemenu': true, 'nav-open': isNavOpen }">
    <h1 class=""><span><?= !empty($page_title) ? $page_title : '' ?></span></h1>
    <!-- 篩選清單 -->
    <ul v-if="searchText === ''" class="menu-main">
        <div v-for="category in posts_categorys">
            <li v-if="category.status == 1" :key="category.sort">
                <input type="button" :value="'>&nbsp;' + category.name" @click="filterByCategory(category.sort)" :class="{ category_btn: true, active: selectedCategoryId === category.sort}">
            </li>
        </div>
    </ul>
    <ul v-else class="menu-main">
        <li>
            <input type="button" value=">&nbsp;搜尋結果" :class="{ category_btn: true, active: true}">
        </li>
    </ul>
    <!-- 篩選清單 -->
</div>