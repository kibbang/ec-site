<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <p>{{product.price}}</p>  
  </div> 
</template>

<script>
  export default {
    data(){
      return{
        id:this.$route.params.id, 
        cart:[],
        product:[],
        account:''
      }
    },
    created(){
      console.log(this.account)
      axios.post('/api/account')
      .then(response=>{
        this.account = response.data.account
      })
      .catch(error=>{
        console.log(error)
      });
    }
  }
</script>

<style>

</style>