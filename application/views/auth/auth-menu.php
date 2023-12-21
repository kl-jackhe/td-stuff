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
    <h1 class=""><span>會員專區</span></h1>
    <!-- 篩選清單 -->
    <ul class="menu-main">
        <?php foreach ($auth_category as $category) : ?>
            <li>
                <input type="button" value=">&nbsp;<?php echo $category['auth_category_name']; ?>" @click="filterByCategory(<?php echo $category['auth_category_id']; ?>)" :class="{ category_btn: true, active: selectedCategoryId == <?php echo $category['auth_category_id']; ?>}">
            </li>
        <?php endforeach; ?>
    </ul>
    <!-- <ul class="menu-main">
        <li v-for="category in authCategory" :key="category.auth_category_id">
            <input type="button" :value="'>&nbsp;' + category.auth_category_name" @click="filterByCategory(category.auth_category_id)" :class="{ category_btn: true, active: selectedCategoryId === category.auth_category_id}">
        </li>
    </ul> -->
    <!-- 篩選清單 -->
</div>