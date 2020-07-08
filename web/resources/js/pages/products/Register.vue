<template>
  <div>
    <div>
      <AdHeader></AdHeader>
    </div>
    <h1>ProductRegister</h1>
    <form>
      <div class="form-group">
        <label for="name">Name:</label>
        <input v-model="product.name">
      </div>

      <p><input type="file" ref="file" multiple enctype="multipart/form-data" @change="imageSelected"></p>
      <br>

      <div class="form-group">
        <label for="description">Description:</label>
        <input v-model="product.description">
      </div>

      <br>

      <div class="form-group">
        <label for="price">Price($):</label>
        <input v-model="product.price">
      </div>

      <br>

      <div class="form-group">
        <label for="stock">Stock:</label>
        <input v-model="product.stock">
      </div>

      <button type="button" @click="productRegister">ProductRegister</button>
    </form>
  </div>
</template>

<script>
  import AdHeader from '../../components/AdHeader.vue';
  export default {
    components: {
      AdHeader
    },
    data: function(){
      return {
        product:{
          name:'',
          description:'',
          price:'',
          stock:'',
          shop_id: 1,
        },
        image_url: [],      
        file_info: [],
      }
    },
    methods:{
      async productRegister(){
        // 画像を登録する処理
        const formData = new FormData()
        for(let i=0; i<this.file_info.length; i++){
          let file = this.file_info[i]
          formData.append('file_info['+ i +']',file)
        }
        let config = {
          headers:{
            'Content-Type': 'multipart/form-data'
          },
        }
        let data = await axios.post('/api/product/imageupload', formData,config)
        .then(response => {
          this.image_url = response.data.image_url;
        })
        .catch(error => console.log(error));
        
        if (!this.file_info) {
          return
        }
        // DBに登録する処理
        await axios.post('/api/product/register',{
          product: this.product,
          image_url: this.image_url
        })
        .then(response => {
          this.product = response.data.product;
          this.$router.push({ name:'productAdmin' })
        })
        .catch(error => console.log(error));
      },
      
      // 画像選択のため
      imageSelected(e)
      {       
        const file = e.target.files
        for(let i = 0 ; i < file.length; i++){
          this.file_info.push(file[i])    
        }    
      },   
    }
  }
</script>