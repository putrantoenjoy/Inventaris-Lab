
<template>
  <div>
    <div class="row">
        <!-- Area Chart -->
        <div class="col-lg-12 mb-4">
            <div class="card-header">
                <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                </div>
                <form @submit.prevent="AddToDetail(product.id)"  enctype="multipart/form-data" class="user">
                        
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG">
                            </div>
                            <!-- <div class="col-md-6">
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id" placeholder="PILIH SUPPLIER">
                                <option value="supplier.id" v-for="supplier in suppliers">{{ supplier.name }}</option>
                                </select>
                            </div>  -->
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
                            <!-- <div class="col-md-6">
                                
                                <input type="file" class="form-control" id="customFile" @change="onFileSelected" style="display: none">
                                <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
                                <label class="form-control" for="customFile">UPLOAD DOKUMEN</label>
                            </div> -->
                        </div>
                    </div>
                    
                    <!-- <div class="form-group">
                        <div class="form-row"> 
                            <div class="col-md-12">
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.product_id" placeholder="PILIH BARANG">
                                    <option value="product.id" v-for="product in products">{{ product.product_name }}</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" @click.prevent="AddToDetail(product.id)">submit</button>
                    </div>
                </form>
                <!--  Category Wise Product -->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div>
                        <div class="row">
                            <div class="col-lg-3 col-md-3" v-for="product in filtersearch" :key="product.id">
                                <button class="btn btn-primary" @click.prevent="AddToPengadaan(product.id)">
                                    <h6 class="card-title">{{ product.product_name }}</h6>
                                </button>
                            </div>        
                        </div>
                    </div>
                </div>
                    <!--  End TBAS HOME -->
                    <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <input type="text" v-model="getsearchTerm" class="form-control" style="width: 560px;" placeholder="Search Product">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="getproduct in getfiltersearch" :key="getproduct.id">
                                <button class="btn btn-sm" @click.prevent="AddToPengadaan(getproduct.id)">
                                    <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                                        <img :src="getproduct.image" id="em_photo" class="card-img-top">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ getproduct.product_name }}</h6>
                                            <span class="badge badge-success" v-if="getproduct.product_quantity  >= 1 ">Available {{ getproduct.product_quantity }}  </span> 
                                            <span class="badge badge-danger" v-else=" ">Stock Out </span>
                                        </div>
                                    </div>
                                </button>
                            </div>        
                        </div>
                    </div> -->
                <!-- End Category Wise Product -->
                
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4">
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
                                    <tr v-for="pengadaan in pengadaans" :key="pengadaan.id">
                                        <td>{{ pengadaan.product_name }}</td>
                                        <td>{{ pengadaan.product_code }}</td>
                                        <td>
                                            <input type="text" readonly="" style="width: 50px;" :value="pengadaan.product_quantity">
                                            <button @click.prevent="increment(pengadaan.id)" class="btn btn-sm btn-success">+</button>
                                            <button @click.prevent="decrement(pengadaan.id)" class="btn btn-sm btn-danger" v-if="pengadaan.product_quantity >= 2">-</button>
                                            <button class="btn btn-sm btn-danger" v-else="" disabled="">-</button>
                                        </td>
                                        <td>{{ pengadaan.selling_price  }}</td>
                                        <td>{{ pengadaan.sub_total }}</td>
                                        <td><a @click="removeItem(pengadaan.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="catatan akhir tahun"></textarea>
                            <br>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Jumlah Barang:
                                            <strong>{{ qty }}</strong>
                                        </li>
                                    </div>
                                    <div class="col-md-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">Total Harga:
                                            <strong>Rp. {{ subtotal }}</strong>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pie Chart -->
        
    </div>
      
    <!--Row-->
    </div> 
  </div>
</template>



<script type="text/javascript">
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

    created(){
    this.allProduct();
    this.allCategory();
    this.allCustomer();
    // this.allDetail();
    this.detailProduct();
    this.vat();
    Reload.$on('AfterAdd',() =>{
        this.detailProduct();
    })

   }, 
 data(){
      return{
       customer_id:'',
       pay:'',
       due:'',
       payby:'',

        products:[],
        categories:'',
        getproducts:[],
        searchTerm:'',
        getsearchTerm:'',
        customers:'',
        errors:'',
        pengadaans:[],
        vats:''

      }
    },
    computed:{
      filtersearch(){
      return this.products.filter(product => {
         return product.product_name.match(this.searchTerm)
      }) 
      },
      getfiltersearch(){
      return this.getproducts.filter(getproduct => {
         return getproduct.product_name.match(this.getsearchTerm)
       }) 
      },
   qty(){
    let sum = 0;
    for(let i = 0; i < this.pengadaans.length; i++){
          sum += (parseFloat(this.pengadaans[i].product_quantity));      
        }
        return sum;
   },
   subtotal(){
    let sum = 0;
    for(let i = 0; i < this.pengadaans.length; i++){
    sum += (parseFloat(this.pengadaans[i].product_quantity) * parseFloat(this.pengadaans[i].selling_price));      
        }
       return sum;

      },

    },
 
  methods:{
      
      AddToPengadaan(id){
          axios.get('/api/addtopengadaan/'+id)
      .then(() => {
          Reload.$emit('AfterAdd');
          Notification.success()
      })
      .catch()
  },
  detailProduct(){
      axios.get('/api/coba/product/')
      .then(({data}) => (this.pengadaans = data))
      .catch()
  },
  removeItem(id){
   axios.get('/api/remove/coba/'+id)
      .then(() => {
        Reload.$emit('AfterAdd');
        Notification.success()
      })
      .catch()
  },
  increment(id){
  axios.get('/api/increment/coba/'+id)
      .then(() => {
        Reload.$emit('AfterAdd');
        Notification.success()
      })
      .catch()
  },
   decrement(id){
    axios.get('/api/decrement/coba/'+id)
      .then(() => {
        Reload.$emit('AfterAdd');
        Notification.success()
      })
      .catch() 
  }, 
  vat(){
       axios.get('/api/vats/')
      .then(({data}) => (this.vats = data))
      .catch()
  },
  orderdone(){
    let total = this.subtotal*this.vats.vat /100 + this.subtotal;
    var data = {qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id, payby:this.payby, pay:this.pay, due:this.due, vat:this.vats.vat, total:total }

    axios.post('/api/orderdone',data)
       .then(() => {
          Notification.success()
         this.$router.push({name: 'home'})
       }) 

  },
   
    // End Cart Methods 
    allProduct(){
      axios.get('/api/product/')
      .then(({data}) => (this.products = data))
      .catch()
    },

     allCategory(){
      axios.get('/api/category/')
      .then(({data}) => (this.categories = data))
      .catch()
    },

    allCustomer(){
      axios.get('/api/customer/')
      .then(({data}) => (this.customers = data))
      .catch(console.log('error'))
    },

    // allDetail(){
    //   axios.get('/api/pengadaan/')
    //   .then(({data}) => (this.pengadaans = data))
    //   .catch(console.log('error'))
    // },

    // subproduct(id){
    //   axios.get('/api/getting/product/'+id)
    //   .then(({data}) => (this.getproducts = data))
    //   .catch()
    // },

    subproductpengadaan(id){
      axios.get('/api/gettingpengadaan/product/'+id)
      .then(({data}) => (this.getproducts = data))
      .catch()
    } 
   

    }  

  } 

</script>


<style type="text/css" scoped>
  #em_photo{
    height: 100px;
    width: 135px;
  }
</style>