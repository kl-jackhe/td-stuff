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

// mobile header sub-menu
function toggleMobileMenu (id) {
  $(`#mobileMenu${id}`).slideToggle()
}

// 置頂fixed-nav
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

// search-icon event
$(document).ready(function () {
  // 获取当前页面的 URL
  var currentPageUrl = window.location.href

  // 检查是否在特定页面
  if (
    (currentPageUrl.indexOf('/product/product_detail') === -1 &&
      currentPageUrl.indexOf('/product') !== -1) ||
    currentPageUrl.indexOf('/posts') !== -1
  ) {
    // 在特定页面添加一个类，使搜索图标可见
    $('.header-icons .search-icon').addClass('visible')
  }
})

// search-icon event listener
document.getElementById('searchLink').addEventListener('click', function () {
  // 触发自定义事件
  var event = new Event('toggleSearch')
  document.dispatchEvent(event)
})

// nav-menu-list
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

// home page product preview effect
var currentIndex = 0
var totalProducts = document.querySelectorAll('.homeProductPreview').length
var productRow = document.querySelector('.product-row')
var productRowContainer = document.querySelector('.product-row-container')
var isAnimating = false
var autoInterval

function changeProduct (direction) {
  if (!isAnimating) {
    clearInterval(autoInterval) // 重置計時器
    isAnimating = true
    currentIndex += direction

    if (currentIndex < 0) {
      currentIndex = totalProducts - getVisibleProductCount()
    } else if (currentIndex > totalProducts - getVisibleProductCount()) {
      currentIndex = 0
    }

    var translateValue = -currentIndex * getProductWidthWithMargin()

    productRow.style.transition = 'transform 0.3s ease'
    productRow.style.transform = 'translateX(' + translateValue + 'px)'

    document.querySelector('.prev-btn').disabled = currentIndex === 0
    document.querySelector('.next-btn').disabled =
      currentIndex >= totalProducts - getVisibleProductCount()

    productRow.addEventListener(
      'transitionend',
      function () {
        isAnimating = false
        productRow.style.transition = 'none'
        if (productRowContainer) {
          startAutoSlide()
        }
        // startAutoSlide() // 動畫結束後重新啟動自動輪播
      },
      { once: true }
    )
  }
}

function startAutoSlide () {
  stopAutoSlide() // 先停止之前的定时器

  autoInterval = setInterval(function () {
    changeProduct(1)
  }, 3000) // 輪播速度3秒換一張
}

function stopAutoSlide () {
  clearInterval(autoInterval)
}

function getProductWidthWithMargin () {
  var productWidth = 270 // 商品寬度
  var margin = 25 // 間距
  return productWidth + margin
}

function getVisibleProductCount () {
  var screenWidth =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth

  if (screenWidth < 768) {
    return 1 // 在螢幕小於768px時，顯示一張商品
  } else if (screenWidth < 769) {
    return 2 // 在螢幕小於769px時，顯示一張商品
  } else {
    return 4 // 在螢幕大於等於769px時，顯示四張商品
  }
}

if (productRowContainer) {
  startAutoSlide()

  productRowContainer.addEventListener('mouseenter', function () {
    isAnimating = true
    stopAutoSlide()
  })

  productRowContainer.addEventListener('mouseleave', function () {
    isAnimating = false
    startAutoSlide()
  })
}
