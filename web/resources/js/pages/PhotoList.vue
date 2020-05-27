<template>
  <div class="card-deck">
    <product-card v-for="product in products" :key="product.id" :product="product" />
    <product-card />
    <product-card />
    <product-card />
    <product-card />
    <product-card />
    <product-card />
    <product-card />
  </div>
</template>

<script>
import ProductCard from "../components/ProductCard.vue"
export default {
  
  components: {
    ProductCard
  },

  computed:{
    products() {
      return this.$store.products;
    }
  },

  mounted() {
    this.$store.dispatch('product/getProducts');
  }
};
</script>
