<template>
  <div>
    <h1>Cart</h1>
      <ul style="list-style: none" v-for="cart in carts" :key="cart.id">
        <li> 
        <img class="w-100" :src="cart.image_url" width=150px, height=100px  alt />
        <p> Product Name: {{cart.name}} </p>
        <p> Product Price($): {{cart.price}} </p>
        <p> Order Quantity: {{cart.quntitiy}} </p>
        <button class="btn btn-danger" @click="cartDelete(index, cart.id)">Delete</button>
        </li> 
      </ul>
      <button>Buy</button>  
  </div>
</template>

<script>
export default {
  data(){
    return{
      carts:[],
    }
  },
  created(){
    axios.get('/api/cart')
    .then(response=>{
      this.carts = response.data.carts;
      console.log(response)
    })
    .catch(error=>{
      console.log(error)
    });
  },
  methods:{
    cartDelete(index, id){
			axios.delete('/api/cart/' + id)
			.then(response => {
				this.users.slice(id, 1)
		  })
			.catch(error => console.log(error));
		},
	}
}
</script>
