<template>
  <div>
    <h1>Account</h1>
    <div>
      <ul style="list-style:none">  
        <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />      
        <li>Product Name: {{ product.name }} </li>
        <li>Product Price: {{ product.price }} </li>
        <li>Order Quantity: {{ counter }} </li>
        <button @click="counter += 1" class="btn btn-danger">Quantity Increase</button>
        <button @click="quantityDecrease" class="btn btn-danger">Quantity Decrease</button> 
      </ul>  
      <strong>Total Price($): {{ product.price * counter }} </strong>
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
        cards:[],
        product:'',
        fromView: this.$route.params.fromView,
        select:'',
        counter: 0
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
                       
        if(this.counter==0)
        {
          alert('Please Select Order Quantity!')
          return
        }

        //DB Change
        axios.post('/api/account/stock/' + this.id,{
          counter:this.counter,
        })
        .then(
          alert("Buy Successful!"),
          this.$router.push({name: 'home'})
        )
        .catch(error =>{
          alert("Buy Failure")
          console.log(error)
        });                 
      },
      //数量を減らす処理(０以下は不可)
      quantityDecrease: function(){
        if(this.counter <= 0){
          alert('Order quantity cannot be zero.')
          return 
        }
        this.counter--
      }         
    },
    async created(){
      await axios.get('/api/product/list/'+this.id)
      .then(response=>{
        this.product = response.data.product
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
