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
<<<<<<< HEAD

=======
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
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
<<<<<<< HEAD
    methods:{      
=======
    methods:{
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
      searchProduct(){
        axios.get('/api/product/list',{
          params:{
            search: this.search
          }
        })
        .then(response => {
          this.products = response.data.products
          console.log(response.data.products);
        })
        .catch(error => {
          console.log(error);
        });
<<<<<<< HEAD
      },
=======
      }
>>>>>>> 98b2de9534ab825382e5af623f20f9ba42e94739
    },  
    created(){
      axios.get('/api/product/list')
      .then(response=>{
        this.products = response.data.products;
      })
      .catch(error => {
        console.log(error)
      });
    }
  }
</script>