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

      <p><input type="file" ref="file" multiple enctype="multipart/form-data" @change="imageChanged"></p>

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
        //console.log(this.file_info)
        for(let i=0; i<this.file_info.length; i++){
          let file = this.file_info[i]
          //console.log(file)
          formData.append('file_info['+ i +']',file)
          //formData.append('product_image', JSON.stringify(file_info))
          //console.log(file)
        }
        let config = {
          headers:{
            'Content-Type': 'multipart/form-data'
          },
        }
        let data = await axios.post('/api/product/imageupload', formData,config)
        .then(response => {
         this.product_image.image_url = response.data.image_url;
          // console.log(this.file_info)
        })
        .catch(error => console.log(error));
        
        if (!this.file_info) {
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
          // console.log(this.product_image.image_url)
        })
        .catch(error => console.log(error));
      },
      // fileSelected(event){
      //   console.log(event)
      //     this.file_info = event.target.files[0];
      // },
      imageChanged(e)
      {
        // let selectedFiles = e.target.files;
        //console.log(selectedFiles)
        const file = e.target.files
        for(let i = 0 ; i < file.length; i++){
          this.file_info.push(file[i])

          // var fileReader = new FileReader
          // fileReader.readAsDataURL(file[i])
          // fileReader.onload = (e) => {
          //   this.file_info = e.target.result
          // }
          //console.log(file[i])
        }

        //console.log(this.file_info)
        // console.log(e.target.files)
        // console.log(file)

        // console.log(this.product_image.image_url)

        // console.log(selectedFiles)
        // var fileReader = new FileReader
        // fileReader.readAsDataURL(e.target.files[0])
        // fileReader.onload = (e) => {
        //   this.file_info = e.target.result
        // }
        // console.log(this.file_info)
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