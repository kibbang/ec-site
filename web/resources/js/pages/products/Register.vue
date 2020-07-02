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

      <p><input type="file" @change="imageChanged"></p>

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
        product_image: {
          image_url: ''
        },
        file_info: [],
      }
    },
    methods:{
      async productRegister(){
        // 画像を登録する処理
        const formData = new FormData()
        formData.append('file',this.file_info) // formData.append(key,value)
        formData.append('product_image', JSON.stringify(this.file_info)) // formData.append(key,value)
        let data = await axios.post('/api/product/imageupload',{
          file_info: this.file_info
        })
        .then(response => {
          this.product_image.image_url = response.data.image_url;
        })
        .catch(error => console.log(error));
        
        if (!this.product_image.image_url) {
          return
        }
        // DBに登録する処理
        await axios.post('/api/product/register',{
          product: this.product,
          product_image: this.product_image
        })
        .then(response => {
          this.product = response.data.product;
          this.$router.push({ name:'productAdmin' })
        })
        .catch(error => console.log(error));
      },
      // fileSelected(event){
      //   console.log(event)
      //     this.file_info = event.target.files[0];
      // },
      imageChanged(e)
      {
        console.log(e.target.files[0])
        var fileReader = new FileReader
        fileReader.readAsDataURL(e.target.files[0])
        fileReader.onload = (e) => {
          this.file_info = e.target.result
        }              
      },
      // async fileUpload(){
      //   //console.log(update)
      //   const formData = new FormData()
      //   formData.append('file',this.file_info)
      //   // formData.append('product[name]',this.product.name)
      //   // formData.append('product[description]',this.product.description)
      //   // formData.append('product[price]',this.product.price)
      //   // formData.append('product[quntity]',this.product.quntity)
      //   // formData.append('product[shop_id]',this.product.shop_id)
      //   formData.append('product', JSON.stringify(this.product))
      //   formData.append('product_image', JSON.stringify(this.file_info))
      //   let data = await axios.post('/api/fileupload',formData).then(response =>{
      //     console.log(response)
      //     return response.data
      //   });
      //   console.log(data)
      //   return data
      // },
      // async register() {
      //   const url = await this.fileUpload()
      //   console.log(url)
      //   let formData = new FormData()
      //   formData.product = this.product
      //   formData.file_info = this.product_image.image_url
      //   axios.post('/api/product/register',formData).then(response =>{
      //     console.log(response)
      //   });
      // }		
    }
  }
</script>