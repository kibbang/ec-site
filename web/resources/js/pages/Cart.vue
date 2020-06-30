<template>
  <div>
    <h1>Cart</h1>
    <ul style="list-style: none" v-for="cart in carts" :key="cart.id">
      <li> 
        <img class="w-100" :src="cart.image_url" width="150px" height="100px"  alt />
        <p> Product Name: {{ cart.name }} </p>
        <p> Product Price($): {{ cart.price }} </p>
        <p> Order Quantity: {{ cart.quantity }} </p>
        <strong> Total Price($): {{ cart.quantity * cart.price }} </strong>
        <br>
        <button class="btn btn-danger" @click="cartDelete(cart.id)">Delete</button>
      </li> 
    </ul>
    
    <button @click="goToAccountView">Buy</button>  
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
      })
      .catch(error=>{
        console.log(error)
      });
    },
    methods:{
      // カート情報削除
      cartDelete(id){
        axios.delete('/api/cart/' + id)
        .then(response => {
          this.carts.slice(id, 1)
          this.$router.push({ name:'home' })
        })
        .catch(error => console.log(error));
      },
      goToAccountView(){
        // fromView cartView or productInfoView
        this.$router.push({name:'accountCart',params:{fromView:'cartView'}})
      }
    }
  }
</script>
