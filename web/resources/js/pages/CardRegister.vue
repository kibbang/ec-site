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
      CardRegister(){
        axios.post('/api/card',{
          card: this.card,
        })
        .then(response => {
          this.card = response.data.card;
<<<<<<< HEAD
          this.$router.push({ name:'home' })
=======
          this.$router.push('/')
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
        })
        .catch(error => console.log(error));
      }
    }
  }
</script>