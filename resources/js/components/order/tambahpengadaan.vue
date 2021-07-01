   

<template>
    
    <div>
        <br>
        <!--
        <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">
        -->
        <br>
        
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                    </div>
                    <div class="table-responsive">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG">
                                </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="exampleInputFirstName" placeholder="PILIH SUPPLIER">
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH STATUS PENGADAAN">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="UPLOAD DOCUMENT">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                
                                <div class="col-md-6">
                                    <input type="file" class="custom-file-input" id="customFile">
                                </div>
                                <div class="col-md-6">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">DETAIL PENGADAAN</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                <th>NO</th>
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
                                        <router-link :to="{name: 'view-order', params:{id:order.id}}" class="btn btn-sm btn-primary">View</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
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
        pengadaans:[],
        searchTerm:''
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
   

  },
  created(){
    this.allOrder();
  } 
  

  } 
</script>


<style type="text/css">
</style>