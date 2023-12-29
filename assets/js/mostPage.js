const headerapp = Vue.createApp({
  methods: {
    confirmLogout () {
      // 使用原生的 confirm 对话框
      const confirmLogout = confirm('確定要登出嗎？')

      if (confirmLogout) {
        // 用户点击确认后，执行登出操作
        window.location.href = '/auth/logout'
      }
    }
  }
}).mount('#headerApp')

$(document).ready(function () {
  var headerFixed = $('.header_fixed_top')

  // 滚动事件处理函数
  function handleScroll () {
    var scrolled = $(window).scrollTop()

    if (scrolled > 40) {
      headerFixed.css('top', '0')
    } else {
      headerFixed.css('top', '35px')
    }
  }

  // 刷新后立即触发一次滚动事件
  handleScroll()

  // 监听滚动事件
  $(window).scroll(handleScroll)
})

$(document).ready(function () {
  // 获取当前页面的 URL
  var currentPageUrl = window.location.href

  // 检查是否在特定页面
  if (
    (currentPageUrl.indexOf('/product/product_detail') === -1 &&
      currentPageUrl.indexOf('/product') !== -1) ||
    currentPageUrl.indexOf('/posts') !== -1
  ) {
    // 在特定页面显示搜索图标
    $('.header-icons .search-icon').show()
  } else {
    // 在其他页面隐藏搜索图标
    $('.header-icons .search-icon').hide()
  }
})

document.getElementById('searchLink').addEventListener('click', function () {
  // 触发自定义事件
  var event = new Event('toggleSearch')
  document.dispatchEvent(event)
})

function switchMenu (mainMenuItem, submenuId, eventType) {
  var submenu = document.getElementById(submenuId) // 取得子選單

  if (eventType === 'MouseOver') {
    // 顯示子選單
    submenu.style.display = 'block'
  } else if (eventType === 'MouseOut') {
    // 隱藏子選單
    submenu.style.display = 'none'
  }
}

function hideSubMenu (submenuId) {
  var submenu = document.getElementById(submenuId)
  submenu.style.display = 'none'
}
