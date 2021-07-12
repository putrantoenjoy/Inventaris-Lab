   

<template>
    
    <div>
        <!--
        <br>
        <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">
        <br>
        -->
        
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card-header">
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                    </div>
                    <form @submit.prevent="pengadaanInsert"  enctype="multipart/form-data" class="user">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG">
                                    <!--<select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id" placeholder="PILIH GUDANG">
                                    <option value="supplier.id" v-for="supplier in suppliers">{{ supplier.name }}</option>-->
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id" placeholder="PILIH SUPPLIER">
                                    <option value="supplier.id" v-for="supplier in suppliers">{{ supplier.name }}</option>
                                    </select>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <select id="status-combo-box" class="form-control" placeholder="PILIH STATUS PENGADAAN">
                                        <option value="null" selected hidden disabled>
                                            PILIH STATUS PENGADAAN
                                        </option>
                                        <option value="1">
                                            status 1
                                        </option>
                                        <option value="2">
                                            status 2
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    
                                    <input type="file" class="form-control" id="customFile" @change="onFileSelected" style="display: none">
                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
                                    <label class="form-control" for="customFile">UPLOAD DOKUMEN</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row"> 
                                <div class="col-md-12">
                                    <!--<input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH BARANG">-->
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.product_id" placeholder="PILIH BARANG">
                                        <option value="product.id" v-for="product in products">{{ product.product_name }}</option>
                                    </select>
                                </div>
                                <!--
                                <div class="col-md-6">
                                    <img :src="form.photo" style="height: 40px; width: 40px;">
                                </div>
                                -->
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div>
                    <div class="card-header">
                        <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">DETAIL PENGADAAN</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead>
                                    <tr>
                                    <th>NAMA</th>
                                    <th>KODE</th>
                                    <th>JUMLAH</th>
                                    <th>HARGA</th>
                                    <th>SUBTOTAL</th>
                                    <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in filtersearch" :key="order.id">
                                        /*
                                        <td> {{ ++$i }} </td>
                                        */
                                        <td> {{ pengadaan.product_name }} </td>
                                        <td> {{ pengadaan.product_code }} $ </td>
                                        <td> {{ pengadaan.product_quantity }} $ </td>
                                        <td> {{ pengadaan.selling_price }} $  </td>
                                        <td> {{ pengadaan.sub_total }} </td>
                                        <td>
                                            <router-link :to="{name: 'edit-product', params:{id:product.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                                            <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Delete</font></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="catatan akhir tahun">
                        </textarea>
                        <br>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="jumlah barang">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" placeholder="total harga">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Row-->

    </div>
</template>



<script type="text/javascript">
  
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

    data(){
      return{
        form:{
            photo: null
        },
        pengadaans:[],
        searchTerm:'',
        errors:{},
        suppliers:{},
        products:{}
      }
    },
    computed:{
      filtersearch(){
      return this.pengadaans.filter(pengadaan => {
         return pengadaan.product_name.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allOrder(){
      axios.get('/api/orders/')
      .then(({data}) => (this.orders = data))
      .catch()
    },
    onFileSelected(event){
     let file = event.target.files[0];
     if (file.size > 1048770) {
      Notification.image_validation()
     }else{
      let reader = new FileReader();
      reader.onload = event =>{
        this.form.photo = event.target.result
        console.log(event.target.result);
      };
      reader.readAsDataURL(file);
     }

    },

    pengadaanInsert(){
       axios.post('/api/pengadaan',this.form)
       .then(() => {
        this.$router.push({ name: 'pengadaan'})
        Notification.success()
       })
       .catch(error =>this.errors = error.response.data.errors)
     },
   

  },
  created(){
    this.allOrder();

    axios.get('/api/supplier/')
    .then(({data}) => (this.suppliers = data))

    axios.get('/api/product/')
    .then(({data}) => (this.products = data))
  }

  } 
</script>


<style type="text/css">
    
</style>