<template>
<div>
	<div>
		<AdHeader></AdHeader>
	</div>
	<h1>Product List</h1>
	<ul>
		<li v-for="product in products" v-text="product.name" v-bind:key="product.id"></li>
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
				products:[]
			}
		},
		created(){
			axios.get('/api/product')
				.then(response=>{
					this.products = response.data.products;
				})
				.catch(error => {
					console.log(error)
				});
		}
	}
</script>