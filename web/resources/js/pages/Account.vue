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
      <ul style="list-style:none">  
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />      
        <li>Product Name: {{product.name}} </li>
        <li>Product Price: {{product.price}} </li>
      </ul>  
      <strong>Total Price: </strong>
      <br>
      {{fromView}}
    </div>     
    <div>
      <select>
        <option disabled value="">Please select Card</option>
        <option>A</option>
        <option>B</option>
        <option>C</option>
      </select>
    </div>
    <button v-on:click="buy('Buy product is success!',$router.push({ name:'home' }))">Buy</button>
  </div> 
</template>

<script>
  export default {
    data(){
      return{
        id: this.$route.params.id,
        productId: this.$route.params.id,
        carts:[],
        product:'',
        cards:[]
      }
    },
    computed: {
      total(){
        return this.carts.reduce((acc, cart) => {
          return acc + (cart.price * cart.quantity)
        }, 0)
      }
    },
    methods:{
      buy: function(message) {
        alert(message)
      }
    },
    created(){
      axios.get('/api/cart')
      .then(response=>{
        this.carts = response.data.carts
        axios.get('/api/product/list/'+this.id)
        .then(response=>{
          this.product = response.data.product
          axios.get('/api/card')
          .then(response=>{
            this.cards = response.data.cards
          })
        })  
      })
      .catch(error => console.log(error));
      this.fromView = this.$route.params.fromView;
    }
  }
</script>