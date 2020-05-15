<template>
<div>
	<div>
		<AdHeader></AdHeader>
	</div>
			<h1>ProductRegister</h1>
			<form @submit.prevent="productRegister">
			<div class="form-gruop">
				<label for="name">Name:</label>
				<input v-model="product.name">
			</div>
				<p><input type="file" v-on:change="imageChanged"></p>

				<br>
				<div class="form-group">
				<label for="description">Description:</label>
				<input v-model="product.description">
				</div>
				<br>

				<div class="form-group">
				<label for="price">Price($):</label>
				<input v-model="product.price">
				</div>
				<br>

				<div class="form-group">
				<label for="price">Quantity:</label>
				<input v-model="product.quntity">
				</div>

				<button v-on:click="productRegister">ProductRegister</button>
			</form>
				
</div>
	
</template>

<script>
import AdHeader from '../../components/AdHeader.vue';

export default {
    components: {
      AdHeader
    },
		data: function(){
			return {
				product:{
					name:'',
					description:'',
					price:'',
					quntity:'',
					shop_id: 1,
				},
				fileInfo:'',
				image_url:''
			}
		},
		methods:{
			productRegister(){
				axios.post('/api/product',{
					product: this.product
				})
				.then(response => {
					this.product = response.data.product;
					//this.$router.push('/product/list')
				})
				.catch(error => console.log(error));
			},
			fileSelected(event){
				console.log(event)
					this.fileInfo = event.target.files[0];
			},
			imageChanged(e)
			{
				console.log(e.target.files[0])
				var fileReader = new FileReader

				fileReader.readAsDataURL(e.target.files[0])

				fileReader.onload = (e) => {
					this.image_url = e.target.result
				}
			},
			/*async fileUpload(){
				//console.log(update)
				const formData = new FormData()
				formData.append('file',this.fileInfo)
				// formData.append('product[name]',this.product.name)
				// formData.append('product[description]',this.product.description)
				// formData.append('product[price]',this.product.price)
				// formData.append('product[quntity]',this.product.quntity)
				// formData.append('product[shop_id]',this.product.shop_id)
				formData.append('product', JSON.stringify(this.product))
				formData.append('product_image',this.image_url )
				let data = await axios.post('/api/fileupload',formData).then(response =>{
					console.log(response)
					return response.data
				});
				console.log(data)
				return data
			},
			async register() {
				const url = await this.fileUpload()
				console.log(url)
				let formData = new FormData()
				formData.product = this.product
				formData.fileInfo = this.image_url
				axios.post('/api/product/register',formData).then(response =>{
					console.log(response)
				});*/
			}		
		}

</script>

