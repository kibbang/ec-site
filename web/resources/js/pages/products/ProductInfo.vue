<template>
  <div>
    <div>
      <h1>Product Information</h1>
      <ul style="list-style: none">
        <img class="w-100" v-for="product_image in product.product_image" :key="product_image.id" 
        :src="product_image.image_url" width="150px" height="100px"  alt />
        <li>Product Name: {{ product.name }}</li>
        <li>Product Price($): {{ product.price }}</li>
        <li>Product Description: {{ product.description }}</li>
        <router-link v-if="isAdmin" class="btn btn-primary" :to="`/product/${product.id}/edit`">Update</router-link>
        <button v-if="isAdmin" class="btn btn-danger" @click="productDelete(product.id)">Delete</button>
        <span v-if="!isAdmin">
          <button @click="goToAccountView" class="btn btn-primary">Buy</button>
          <button v-if="isLogin" v-on:click="counter += 1" class="btn btn-danger">Add Cart</button>
          <button v-else @click="userCheck" class="btn btn-danger">Add Cart</button>
          <p> Added Cart Quantity: {{ counter }} </p>
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
      },
      isLogin(){
        return this.$store.getters['auth/check']
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
      // カートに追加する処理
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
      },
      goToAccountView(){
        // fromView cartView or productInfoView
        this.$router.push({name:'accountProduct',params:{fromView:'productInfoView'}})
      },

      //　商品の削除のため
      productDelete(id){
				axios.delete('/api/product/list/' + id)
        .then(response => {
          this.product.slice(id, 1)
        })
        this.$router.push({ name:'productAdmin' })
        .catch(error => console.log(error));
      },
      
      //ログインしていないユーザーのカート使用防止処理
      userCheck(){
        alert('You must login first');
      }
    }
  }
</script>