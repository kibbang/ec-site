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
          <p>Price: {{ cart.price * cart.quantity }}$</p>
        </li> 
      </ul>
      <strong>Total Price: {{ cartTotal }}$</strong>
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
        //product:'',
        fromView: this.$route.params.fromView,
        select:'',
        //counter: 0
      }
    },
    computed: {
      //カートのある物の総価格を表示する処理
      cartTotal(){
        if(this.fromView=='cartView'){
          return this.carts.reduce((total, cart) => {
            return total + (cart.price * cart.quantity)
          }, 0)
        }
      }
    },
    methods:{
      //商品を購入する際に必要となるalertと購入処理
      buyProduct: function(){
        if(this.select == '')
        {
          alert('Please Select Card First!')
          return
        }
        else
        {
          alert('Buy Successful!')
        }
        //DB Change//   
        axios.post('/api/account/cart')
        .then(this.$router.push({name: 'home'}))          
        .catch(error => console.log(error));  
      }
    },
    async created(){
      await axios.get('/api/cart')
      .then(response=>{
        this.carts = response.data.carts
        this.fromView = this.$route.params.fromView
      })   
      .catch(error => console.log(error));

      await axios.get('/api/card')
        .then(response=>{
          this.cards = response.data.cards
        }) 
        .catch(error => console.log(error));
      }     
  }
</script>