import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue'
import Login from './pages/Login.vue'
import SystemError from './pages/error/System.vue'
import ProductAdmin from './pages/ProductAdmin.vue'
import Product from './pages/products/Product.vue'
import ProductRegister from './pages/products/Register.vue'
import ProductDetail from './pages/products/ProductInfo.vue'
import ProductEdit from './pages/products/ProductEdit.vue'


import store from './store'

import Card from './pages/Card.vue'
import CardRegister from './pages/CardRegister.vue'
<<<<<<< HEAD
import Cart from './pages/Cart.vue'
=======
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    name: 'home',
    component: PhotoList
  },

  {
    path: '/product/admin',
<<<<<<< HEAD
    name: 'productAdmin',
=======
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
    component: ProductAdmin
  },
  {
    path: '/product',
    name: 'product',
    component: Product
  },

  {
    path: '/product/register',
    name: 'productRegister',
    component: ProductRegister
  },

  {
    path: '/product/:id',
    name: 'productDetail',
    component: ProductDetail,
  },

  {
    path: '/product/:id/edit',
    name: 'productEdit',
    component: ProductEdit,
  },

  {
    path: '/card',
    name: 'card',
    component: Card,
  },
  {
    path: '/card/register',
<<<<<<< HEAD
    name: 'cardRegister',
    component: CardRegister,
  },
  {
    path: '/cart',
    name: 'cart',
    component: Cart,
  },
=======
    component: CardRegister,
  },
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739

  {
    path: '/login',
    name: 'login',
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
    name: 'systemError',
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