<template>
  <div>
    <AdHeader />

    <div>
      <h1>Product Admin</h1>
    </div>

    <AdminProductCard />
  </div>
</template>

<script>

import AdHeader from '../components/AdHeader.vue';
import AdminProductCard from "../components/AdminProductCard.vue"
export default {
    components: {
      AdHeader,
      AdminProductCard
    }
}
</script>