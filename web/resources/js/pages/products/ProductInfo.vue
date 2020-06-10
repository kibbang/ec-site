<template>
  <div>
	  <div>
	    <h1>Product Information</h1>
	    <ul style="list-style: none">
			<img class="w-100" :src="product.image_url" "width=150px, height=100px"  alt />
		    <li>Product Name: {{ product.name }}</li>
		    <li>Product Price($): {{ product.price }}</li>
		    <li>Product Description: {{ product.description }}</li>
			<router-link v-if="isAdmin" class="btn btn-primary" :to="`/product/${product.id}/edit`">Update</router-link>
      		<button v-else class="btn btn-primary">Buy</button> 
			<button v-if="!isAdmin" class="btn btn-danger" @click.prevent="AddCart()">Add Cart</button>
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
    isAdmin () {
      return this.$store.getters['auth/admin']
    }
  },
	data(){
		return {
			id: this.$route.params.id,
      product:'',
      cart:[]
    }
	},
		
	created(){
		axios.get('/api/product/list/' + this.id) 
    .then(response => this.product = response.data.product)
		.catch(error => console.log(error));
  },
  methods:{
    AddCart(){
      console.log(this.product);
      console.log(this.cart);
      axios.post('/api/cart',{
        cart:this.cart,
        product:this.product
      })
      .then(response=>{
        this.product = response.data.product;
        this.cart = response.data.cart
        this.$router.push('/')
      })
      .catch(error => console.log(error));
    }
  }
}
</script>