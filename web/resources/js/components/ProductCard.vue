<template>
  <div>
    <div class = "col-3 mt-3">
      <div class = "card h-100 text-left">        
        <div class = "card-body">
          <h4 class="card-title">
            <ul style="list-style: none">
              <li v-for="(product, index) in products" :key="index">
                <img class="w-100" :src="product.image_url" width="150px" height="100px"  alt />
                <p>Product Name : {{ product.name }}</p>
                <p>Product Price($) : {{ product.price }}</p>
                <router-link class="btn btn-success" :to="`/product/${product.id}`">Product detail</router-link>               
              </li>	
            </ul>
          </h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props:['products']
  }
</script>