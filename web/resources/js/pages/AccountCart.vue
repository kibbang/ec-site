<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <div>
      <ul style="list-style: none">
        <li v-for="cart in carts" :key="cart.id">
          <img class="w-100" :src="cart.product.product_image[0].image_url"
           width="150px" height="100px"  alt />
          <p>Product Name: {{ cart.product.name }}</p>
          <p>Order Quantity: {{ cart.quantity }}</p>
          <p>Price: {{ cart.product.price * cart.quantity }}$</p>
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
        fromView: this.$route.params.fromView,
        select:'',
      }
    },
    computed: {
      // カートのある物の総価格を表示する処理
      cartTotal(){
        if(this.fromView=='cartView'){
          return this.carts.reduce((total, cart) => {
            return total + (cart.product.price * cart.quantity)
          }, 0)
        }
      }
    },
    methods:{
      // 商品を購入する際に必要となるalertと購入処理
      buyProduct: function(){
        if(this.select == '')
        {
          alert('Please Select Card First!')
          return
        }
        
        // DB Change   
        axios.post('/api/account/cart')
        .then(
          alert("Buy Successful!"),
          this.$router.push({name: 'home'})
        )
        .catch(error =>{
          alert("Buy Failure")
          console.log(error)
        });             
      }
    },
    async mounted(){
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