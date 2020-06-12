<template>
<div>
	<div>
		<AdHeader></AdHeader>
  </div>
	<h1>Product</h1>
	<router-link class="btn btn-success" :to="`/product/register`">Register</router-link>
	<router-link class="btn btn-success" :to="`/product/admin`">Adimin</router-link>
</div>
</template>

<script>

import AdHeader from '../../components/AdHeader.vue';
export default {
	components: {
		AdHeader
	},
	data(){
		return{
			products:[],
		}
	},
	created(){
		axios.get('/api/product')
		.then(response=>{
			this.products = response.data.products;
		})
		.catch(error => {console.log(error)});		
	}
}
</script>