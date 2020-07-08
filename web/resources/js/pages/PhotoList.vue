<template>
  <div>
    <div class="col-md-4">
      <form>
        <div class="input-group">
          <input type="text" v-model="search" class="form-control">
          <span class="input-group-prepend">
            <button @click.prevent="searchProduct()" class="btn btn-primary"><i class="fa fa-search">Search</i></button>
          </span>
        </div>
      </form>
    </div>
    <ProductCard :products="products"/>
  </div>
</template>

<script>
  import ProductCard from "../components/ProductCard.vue"
  export default {
    components: {
      ProductCard
    },
    data(){
      return {
        search:'',
        products:[]       
      }
    },
    methods:{
      // 商品検索処理
      searchProduct(){
        axios.get('/api/product/list',{
          params:{
            search: this.search
          }
        })
        .then(response => {
          this.products = response.data.products
        })
        .catch(error => {
          console.log(error);
        });
      }
    },  
    created(){
      axios.get('/api/product/list')
      .then(response=>{
        this.products = response.data.products
      })
      .catch(error => {
        console.log(error)
      });
    }
  }
</script>