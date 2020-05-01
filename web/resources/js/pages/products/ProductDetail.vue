<template>
<div>
	<div>
	<h1>Product Information</h1>
	<ul>
		<li>Product Id: {{ product.id }}</li>
		<li>Product Name: {{ product.name }}</li>
		<li>Product Description: {{ proudct.description }}</li>
	</ul>
	</div>
	
	
</div>
</template>

<script>
	export default {
		data(){
			return {
				id: this.$route.params.id,
				product: ''
			}
		},
		created(){
			axios.get('/api/product/' + this.id)
			.then(response => this.product = response.data.product)
			.catch(erorr => console.log(error));
		}

	}
</script>