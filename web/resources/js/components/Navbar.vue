<template>
  <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <RouterLink class="navbar__brand" to="/">
      Sakura GlobalMaket
    </RouterLink>
    <div class="navbar__menu">
      <div v-if="isLogin" class="navbar__item">
        <button class="button">
          <i class="icon ion-md-add"></i>
          Submit a photo
        </button>
        <router-link v-if="isLogin" to="/cart">
          Cart
        </router-link>
      </div>
      <div>
        <span v-if="isLogin" class="navbar__item">
        {{ username }}
        </span>
      </div>
      <router-link v-if="isLogin" to="/card">
       Card
      </router-link>
      <div v-else class="navbar__item">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink> 
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    }
  }
}
</script>
