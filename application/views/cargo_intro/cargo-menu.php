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
    <h1 class=""><span>產品介紹</span></h1>
    <!-- 篩選清單 -->
    <ul class="menu-main">
        <div v-for="category in cargo_category">
            <li v-if="category.status == 1" :key="category.sort">
                <input type="button" :value="'>&nbsp;' + category.name" @click="filterByCategory(category.sort)" :class="{ category_btn: true, active: selectedCategoryId === category.sort}">
            </li>
        </div>
        <!-- <div v-for="category in cargo_category">
            <li v-if="category.status == 1" :key="category.id">
                <div class="category-header" @click="toggleCategory(category.id)">
                    <input type="button" :value="'>&nbsp;' + category.name" :class="{ category_btn: true, active: selectedCategoryId === category.sort}">
                </div>
                嵌套的子项列表
                <ul v-show="category.isExpanded">
                    <li v-for="subCategory in getSubCategories(category.id)" :key="subCategory.sort">
                        <input type="button" :value="'>&nbsp;' + subCategory.name" @click="filterBySubCategory(subCategory.sort)" :class="{ category_btn: true, active: selectedSubCategoryId === subCategory.sort}">
                    </li>
                </ul>
                嵌套的子项列表结束
            </li>
        </div> -->
    </ul>
    <!-- 篩選清單 -->
</div>