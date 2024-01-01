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
</div>
<div :class="{ 'section-sidemenu': true, 'nav-open': isNavOpen }">
    <h1 class=""><span>關於我們</span></h1>
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