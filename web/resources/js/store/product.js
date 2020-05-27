import axios from "axios";

 const state ={
  products: []
}

 const getters = {}

const mutations = { 
  SET_PRODUCTS  (state, products) {
    state.products = products
  }
}

const actions = {
  async getProducts (context, data) {
    const response = await axios.get('https://localhost:17443/api/products',data)
    context.commit('SET_PRODUCTS',response.data);
  }
}


export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}