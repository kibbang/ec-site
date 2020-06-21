<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <div v-if="fromView=='cartView'">
      <ul style="list-style: none" v-for="cart in carts" :key="cart.id">
        <li>
          <img class="w-100" :src="cart.image_url" width="150px" height="100px"  alt />
          <p>Product Name: {{cart.name}}</p>
          <p>Order Quantity: {{cart.quantity}}</p>
          <p>Price: {{cart.price*cart.quantity}}$</p>
        </li> 
      </ul>
      <strong>Total Price: {{total}}$</strong>
      <br>
      {{fromView}}
    </div>
    <div v-if="fromView=='productInfoView'">
      <ul style="list-style:none" v-for="product in products" :key="product.id">
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />
        <li>Product Name: {{product.name}} </li>
        <li>Product Price: {{product.price}}</li>
        <li>Order Quantity: </li>
      </ul>  
      <strong>Total Price: {{1}} </strong>
      <br>
      {{fromView}}
    </div>     
    <div>
      <select v-model="cardSelected">
        <option disabled value="">Please select Card</option>
        <option>A</option>
        <option>B</option>
        <option>C</option>
      </select>
    </div>
    <button>Buy</button>
  </div> 
</template>

<script>
  export default {
    data(){
      return{
        id: this.$route.params.id,
        carts:[],
        cardSelected:'',
      }
    },
    computed: {
      total(){
        return this.carts.reduce((acc, cart) => {
          return acc + (cart.price * cart.quantity)
        }, 0)
      }
    },
    created(){
      axios.get('/api/cart')
      .then(response=>{
        this.carts = response.data.carts      
      })
      .catch(error => console.log(error));
      //fromView cartView or productInfoView
      this.fromView = this.$route.params.fromView;      
    },
  }
</script>