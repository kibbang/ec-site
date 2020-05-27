import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue'
import Login from './pages/Login.vue'
import SystemError from './pages/error/System.vue'
import Test from './pages/Test.vue'
import Product from './pages/products/Product.vue'
import ProductRegister from './pages/products/Register.vue'
import ProductList from './pages/products/ProductDetail.vue'
import ProductDetail from './pages/UserProduct.vue'
import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: PhotoList
  },

  {
    path: '/test',
    component: Test
  },

  {
    path: '/product',
    component: Product
  },

  {
    path:'/product/list',
    component: ProductList
  },

  {
    path: '/product/register',
    component: ProductRegister
  },

  {
    path: '/product/:id',
    component: ProductDetail,
    props: true

  },

  {
    path: '/login',
    component: Login,
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: '/500',
    component: SystemError
  }

]


// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  routes
    
  
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router