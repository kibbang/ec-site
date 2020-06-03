<template>
  <div>
	  <div>
	    <h1>Shop</h1>
	    <ul>
		    <li>Shop Id: {{ shop.id }}</li>
		    <li>Shop Name: {{ shop.name }}</li>
		    <li>Shop Email: {{ shop.email }}</li>
	    </ul>
	  </div>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				id: this.$route.params.id,
				shop: ''
			}
		},
		created(){
			axios.get('/api/shop/' + this.id)
			.then(response => this.shop = response.data.shop)
			.catch(erorr => console.log(error));
		}

	}
</script>