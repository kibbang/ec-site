<template>
  <div>
	  <div>
	    <AdHeader></AdHeader>
    </div>
    <h1>Product Update</h1>
	  <ul>
	    <li v-for="product in products" v-bind:key="product.id">
		  	<p>Product Name:{{ product.name }}</p>
		    <p>Product Price:{{ product.price }}</p>
			<p>Product Quantity:{{ product.quntity }}</p>
	    </li>
	  </ul>
  </div>
</template>


<script>

import AdHeader from '../../components/AdHeader.vue';

export default {

    components:{ 
	  AdHeader
	},

	data(){
	  return{
	    products:[],
		
		}
	},
	created(){
	  axios.get('/api/product/list')
	  .then(response=>{
	    this.products = response.data.products;
	   })
	  .catch(error => {
		console.log(error)
	  });
	}
}
</script>