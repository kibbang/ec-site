import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import product from './product'


Vue.use(Vuex)



const store = new Vuex.Store({
  modules: {
    auth,
    error,
    product
  }
})

export default store

 