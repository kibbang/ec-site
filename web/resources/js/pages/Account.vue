<template>
  <div>
    <div>
      <h1>Account</h1>
    </div>
    <p>{{account}}</p>  
  </div> 
</template>

<script>
  export default {
    data(){
      return{
        account: '',
        product:[]
      }
    },
    created(){
      console.log(this.account)
      axios.get('/api/account')
      .then(response=>{
        this.account = response.data.account
        this.product = response.data.product
      })
      .catch(error=>{
        console.log(error)
      });
    }
  }
</script>

<style>

</style>