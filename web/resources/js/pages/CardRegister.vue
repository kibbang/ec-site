<template>
  <div>
    <h1>Card Register</h1>
    <form>
      <div class="form-group">
        <label for="number">Number:</label>
        <input v-model="card.number">
      </div>

      <br>
      <div class="form-group">
        <label for="cvc">CVC Code:</label>
        <input v-model="card.security_code">
      </div>
      <br>

      <button type="button" @click="CardRegister">CardRegister</button>
    </form>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        card:{
          number: '',
          security_code: '',
          user_id:''
        },
      }
    },
    methods:{
      /**カード登録処理**/
      CardRegister(){
        axios.post('/api/card',{
          card: this.card,
        })
        .then(response => {
          this.card = response.data.card;
          this.$router.push({ name:'home' })
        })
        .catch(error => console.log(error));
      }
    }
  }
</script>