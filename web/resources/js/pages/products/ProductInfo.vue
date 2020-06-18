<template>
  <div>
    <div>
      <h1>Product Information</h1>
      <ul style="list-style: none">
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />
        <li>Product Name: {{ product.name }}</li>
        <li>Product Price($): {{ product.price }}</li>
        <li>Product Description: {{ product.description }}</li>
        <router-link v-if="isAdmin" class="btn btn-primary" :to="`/product/${product.id}/edit`">Update</router-link>
        <span v-if="!isAdmin">
          <button class="btn btn-primary">Buy</button>
          <button v-on:click="counter += 1" class="btn btn-danger">Add Cart</button>
          <p> Added Quantity: {{ counter }} </p>
          <p> Total Price($): {{ counter * product.price }} </p> 
          <br>
          <button v-if="!counter==0" class="btn btn-primary" @click.prevent="AddCart()">Go to Cart</button>
          <button v-else class="btn btn-primary" @click="$router.push({ name:'cart' })">Go to Cart</button>
        </span>
      </ul>
    </div>
  </div>
</template>

<script>
  import AdHeader from '../../components/AdHeader.vue';
  export default {
    components: {
      AdHeader
    },
    computed: {
      isAdmin(){
        return this.$store.getters['auth/admin']
      }
    },
    data(){
      return {
        id: this.$route.params.id,
        product:[],
        cart:[],
        counter: 0     
      }
    },
      
    created(){
      axios.get('/api/product/list/' + this.id) 
      .then(response => this.product = response.data.product)
      .catch(error => console.log(error));
    },
    methods:{
      AddCart(){
        axios.post('/api/cart',{
          cart:this.cart,
          product:this.product,
          counter:this.counter
        })
        .then(response=>{
          this.product = response.data.product
          this.cart = response.data.cart
          this.counter = response.data.counter
          this.$router.push({ name:'cart' })
        })
        .catch(error => console.log(error));
      }
    }
  }
</script>