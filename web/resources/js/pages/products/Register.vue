<template>
<div>
	<div>
	<h1>ProductRegister</h1>
	<form @submit.prevent="productRegister">
		<div class="form-group">
			<label for="name">Name:</label>
			<input v-model="product.name">
		</div>
		<div class="form-group">
			<label for="image">Image:</label>
			<input v-model="product.image">
		</div>
		<div class="form-group">
			<label for="description">Description:</label>
			<input type="desctiption" v-model="product.description">
		</div>
		<button type="submit">Register</button>
	</form>
	</div>
</div>
</template>

<script>
	export default {
		data(){
			return {
				product:{
					name: '',
					image:'',
					description:''
				}
			}
		},
		methods:{
			productRegister(){
				axios.post('/api/product',{
					product: this.product
				})
				.then(response => {
					this.user = response.data.product;
					this.$router.push({ name: 'product'})
				})
				.catch(error => console.log(error));
			},
		}
	}
</script>