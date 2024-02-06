<!-- 分頁 -->
<ul v-if="order && totalPages !== 0" class="pagination">
    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="currentPage !== 1 && setPage(1)">
        <a class="page_link" href="" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>
    <li class="page-item" :class="{'disabled': currentPage === 1}" @click.prevent="setPage(currentPage-1)">
        <a class="page_link" href="" aria-label="Previous">
            <span aria-hidden="true">&lsaquo;</span>
        </a>
    </li>
    <li v-for="n in limitedPages" :key="n" :class="{'active': (currentPage === n)}" @click.prevent="setPage(n)">
        <a class="page_link" href="">{{ n }}</a>
    </li>
    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(currentPage+1)">
        <a class="page_link" href="" aria-label="Next">
            <span aria-hidden="true">&rsaquo;</span>
        </a>
    </li>
    <li class="page-item" :class="{'disabled': (currentPage === totalPages) || (totalPages === 0)}" @click.prevent="setPage(totalPages)">
        <a class="page_link" href="" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
</ul>

<ul v-if="order && totalPages !== 0" class="pagination pagination_bottom">
    <span>目前頁數： {{ currentPage }} / {{ totalPages }}　資料總數：{{ (this.selectedCategoryId == 1) ? this.order.length : ((this.selectedCategoryId == 2) ? this.followData.length : this.mail.length) }}</span>
</ul>