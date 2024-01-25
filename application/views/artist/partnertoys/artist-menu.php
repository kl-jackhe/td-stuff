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
    <h1 class=""><span><?= !empty($page_title) ? $page_title : '' ?></span></h1>
    <!-- 篩選清單 -->
    <ul class="menu-main">
        <div v-for="category in artist_category">
            <li v-if="category.status == 1" :key="category.sort">
                <div class="category-header" @click="toggleCategory(category.id)">
                    <input type="button" :value="'>&nbsp;' + category.name" :class="{ category_btn: true, active: selectedCategoryId === category.sort}">
                </div>
                <transition name="menu-sub">
                    <ul v-show="isExpanded.switch && isExpanded.id === category.id" class="menu-sub">
                        <li v-for="subCategory in artist_son_category" :key="subCategory.sort">
                            <input type="button" :value="'&nbsp;' + subCategory.name" @click="filterBySubCategory(subCategory.id)" :class="{ category_btn: true, active: selectedSubCategoryId === subCategory.id}">
                        </li>
                    </ul>
                </transition>
            </li>
        </div>
    </ul>
    <!-- 篩選清單 -->
</div>