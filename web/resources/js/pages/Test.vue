<template>
  <div>
    <AdHeader />
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
    <div>
      <h1>Product Admin</h1>
    </div>
    <AdminProductCard :products="products"/>
  </div>
</template>

<script>

import AdHeader from '../components/AdHeader.vue';
import AdminProductCard from "../components/AdminProductCard.vue"
export default {
  components: {
    AdHeader,
    AdminProductCard
  },
	data(){
		return {
      search:'',
      products:[]
    }
  },
  methods:{    
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
    },
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