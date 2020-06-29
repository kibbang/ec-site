<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <div v-if="fromView == 'cartView'">
      <ul style="list-style: none" v-for="cart in carts" :key="cart.id">
        <li>
          <img class="w-100" :src="cart.image_url" width="150px" height="100px"  alt />
          <p>Product Name: {{ cart.name }}</p>
          <p>Order Quantity: {{ cart.quantity }}</p>
          <p>Price: {{ cart.price*cart.quantity }}$</p>
        </li> 
      </ul>
      <strong>Total Price: {{ cartTotal }}$</strong>
    </div>
    
    <div v-if="fromView=='productInfoView'">
      <ul style="list-style:none">  
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />      
        <li>Product Name: {{ product.name }} </li>
        <li>Product Price: {{ product.price }} </li>
        <li>Order Quantity: {{ counter }} </li>
        <button @click="counter += 1" class="btn btn-danger">Quantity Increase</button>
        <button @click="quantityDecrease" class="btn btn-danger">Quantity Decrease</button> 
      </ul>  
      <strong>Total Price($): {{ product.price*counter }} </strong>
    </div>     
    <div class="form-group">
      <select class="form-control" v-model="select">
        <option disabled value="">Please select Card</option>
        <option v-for="card in cards" :key="card.id" :value="card.number">
          {{ card.number }}
        </option>
      </select>
    </div>  
    <button @click="buyProduct">Buy</button> 
  </div>
</template>

<script>
  export default {
    data(){
      return{
        id: this.$route.params.id,
        carts:[],
        cards:[],
        product:'',
        fromView: this.$route.params.fromView,
        select:'',
        counter: 0
      }
    },
    computed: {
      cartTotal(){
        if(this.fromView=='cartView'){
          return this.carts.reduce((acc, cart) => {
            return acc + (cart.price * cart.quantity)
          }, 0)
        }
      }
    },
    methods:{
      buyProduct: function(){
        if(this.select=='')
        {
          alert('Please Select Card First!')
          return
        }
        if(this.fromView=='productInfoView')
        {        
          if(this.counter==0)
          {
            alert('Please Select Order Quantity!')
            return
          }
          else
          {
            alert('Buy Successful!')
          }
        }          
        else
        {
          alert('Buy Successful!')
        }
        //DB Change//
        if(this.fromView=='productInfoView')
        {
          axios.post('/api/account/stock/' + this.id,{
            counter:this.counter,
            fromView:this.fromView
          })
          .then(response =>{
            this.product = response.data.product
            this.counter = response.data.counter
            this.fromView = response.data.fromView
          })
          .catch(error => console.log(error));
          this.$router.push({name: 'home'})
        }
    
        if(this.fromView=='cartView')
        {
          axios.post('/api/account/cart',{
            fromView: this.fromView,
          })
          .then(response => {
            this.fromView = response.data.fromView
          })
          .catch(error => console.log(error));
          this.$router.push({name: 'home'})
        }
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
      if(this.fromView=='cartView')
      {
        await axios.get('/api/cart')
        .then(response=>{
          this.carts = response.data.carts
          this.fromView = this.$route.params.fromView
        })   
        .catch(error => console.log(error));
      }

      if(this.fromView=='productInfoView')
      {
        await axios.get('/api/product/list/'+this.id)
        .then(response=>{
          this.product = response.data.product
          this.fromView = this.$route.params.fromView
        })
        .catch(error => console.log(error)); 
      }

      await axios.get('/api/card')
      .then(response=>{
        this.cards = response.data.cards
      }) 
      .catch(error => console.log(error));
    }
  }
</script>