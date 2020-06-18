<template>
  <div>
    <div>
      <h1>Product Edit</h1>
      <form>
<<<<<<< HEAD
        <p>Product Id: {{ product.id }}</p>
        <img class="w-100" :src="product.image_url" width=150px, height=100px  alt />
=======
        <p>Product Id: {{ product.id }} </p>
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
        <br>
        <div class="form-group">
          <label for="name">Name:</label>
          <input v-model="product.name">
        </div>
        <div class="form-group">
<<<<<<< HEAD
          <label for="name">Stock:</label>
          <input v-model="product.stock">
        </div>
      <div class="form-group">
          <label for="name">Price($):</label>
          <input v-model="product.price">
        </div>
      <div class="form-group">
=======
          <label for="name">Quantity:</label>
          <input v-model="product.quntity">
        </div>
        <div class="form-group">
          <label for="name">Price($):</label>
          <input v-model="product.price">
        </div>
        <div class="form-group">
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
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
<<<<<<< HEAD
          stock:'',
=======
          quntity:'',
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
          price:'',
          description:''
        }
      }
    },
    methods:{
      updateProduct(){
<<<<<<< HEAD
        console.log(this.product)
=======
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
        axios.post('/api/product/update',{
          product: this.product
        })
        .then(response => {
          this.product = response.data.product;
<<<<<<< HEAD
          this.$router.push({ name:'productAdmin'})
=======
          this.$router.push({ path:'/product/admin'})
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
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