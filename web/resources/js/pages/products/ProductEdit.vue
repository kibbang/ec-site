<template>
  <div>
    <div>
      <h1>Product Edit</h1>
      <form>
        <p>Product Id: {{ product.id }} </p>
        <img class="w-100" v-for="product_image in product.product_image" :key="product_image.id" 
        :src="product_image.image_url" width="150px" height="100px"  alt />
        <br>
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="product.name">
        </div>
        <div class="form-group">
          <label for="name">Stock:</label>
          <input v-model="product.stock">
        </div>
        <div class="form-group">
          <label for="name">Price($):</label>
          <input v-model="product.price">
        </div>
        <div class="form-group">
          <label for="name">Description:</label>
          <input v-model="product.description">
        </div>
        <button type="button" @click="updateProduct">更新</button>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        id: this.$route.params.id,
        product:{
          id:'',
          name: '',
          stock:'',
          price:'',
          description:''
        }
      }
    },
    methods:{
      // 商品情報の変更
      updateProduct(){
        axios.post('/api/product/update',{
          product: this.product
        })
        .then(response => {
          this.product = response.data.product;
          this.$router.push({ name:'productAdmin'})
        })
        .catch(error => console.log(error));
      },
    },
    created(){
      axios.get('/api/product/' + this.id) 
      .then(response => this.product = response.data.product)
      .catch(erorr => console.log(error));
    }
  }
</script>