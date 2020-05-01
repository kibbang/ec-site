<template>
<div>
	<h1>Product Infomation/h1>
	<ul>
		<li v-for="product in products" v-text="user.name" v-bind:key="product.id"></li>
	</ul>
</div>
</template>

<script>
	export default {
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
				.catch(error => {
					console.log(error)
				});
		}
	}
</script>;