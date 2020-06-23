<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <div v-if="fromView == 'cartView'">
      <ul style="list-style: none" v-for="cart in carts" :key="cart.id">
        <li>
          <img class="w-100" :src="cart.image_url" width="150px" height="100px"  alt />
          <p>Product Name: {{cart.name}}</p>
          <p>Order Quantity: {{cart.quantity}}</p>
          <p>Price: {{cart.price*cart.quantity}}$</p>
        </li> 
      </ul>
      <strong>Total Price: {{total}}$</strong>
    </div>
    
    <div v-if="fromView=='productInfoView'">
      <ul style="list-style:none">  
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />      
        <li>Product Name: {{product.name}} </li>
        <li>Product Price: {{product.price}} </li>
        <li>Order Quantity: {{counter}} </li>
        <button @click="counter += 1" class="btn btn-danger">Quantity Increase</button>
        <button @click="quantityDecrease" class="btn btn-danger">Quantity Decrease</button> 
      </ul>  
      <strong>Total Price($): {{product.price*counter}} </strong>
    </div>     
    <div class="form-group">
      <select class="form-control" v-model="card">
        <option disabled value="">Please select Card</option>
        <option v-for="card in cards" :key="card.user_id" :value="card.number">
          {{card.number}}
        </option>
      </select>
    </div>
    <button @click="buy('Buy product is success!',$router.push({ name:'home' }))">Buy</button> 
  </div>
</template>

<script>
  export default {
    data(){
      return{
        id: this.$route.params.id,
        carts:[],
        product:'',
        cards:[],
        fromView:'',
        counter: 0,
        card:[]
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
      buy: function(message){
        alert(message)
      },
      quantityDecrease: function(){
        if(this.counter <= 0){
          alert('Order quantity cannot be zero.')

          return 
        }
        this.counter--
      }
    },
    async created(){    
      await axios.get('/api/cart')
      .then(response=>{
        this.carts = response.data.carts
      })   
      .catch(error => console.log(error));
        
      await axios.get('/api/product/list/'+this.id)
      .then(response=>{
        this.product = response.data.product
      })
      .catch(error => console.log(error)); 
        
      await axios.get('/api/card')
      .then(response=>{
        this.cards = response.data.cards
        console.log(response.data)
      }) 
      .catch(error => console.log(error));
      this.fromView = this.$route.params.fromView;
    }
  }
</script>