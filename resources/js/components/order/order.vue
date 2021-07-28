   

<template>
  
  <div>
    <div>
        <router-link to="/pengadaan" class="btn btn-primary">Tambah Pengadaan</router-link>
    </div>
    <!-- <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here"> -->
    <br>

    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Order Pengadaan</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Nama Gudang</th>
                  <th>Supplier</th>
                  <th>Status Pengadaan</th>
                  <th>Dokumen</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- <tr>
                  <td>sabun</td>
                  <td>Kode</td>
                  <td>Gudang</td>
                  <td>supplier</td>
                  <td>
                    <button class="btn btn-primary">Edit</button>
                    <button class="btn btn-danger">Hapus</button>
                  </td>
                </tr> -->
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <div class="form-group">
              <div class="form-row">
                  <!-- <div class="col-md-5">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Catatan:
                          <strong>{{ catatan }}</strong>
                      </li>
                  </div>
                  <div class="col-md-3">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Jumlah Barang:
                          <strong>{{ qty }}</strong>
                      </li>
                  </div>
                  <div class="col-md-3">
                      <li class="list-group-item d-flex justify-content-between align-items-center">Total Harga:
                          <strong>Rp. {{ subtotal }}</strong>
                      </li>
                  </div> -->
                  <div class="col-md-12">
                      <button class="btn btn-primary btn-block">View</button>
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
        orders:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.orders.filter(order => {
         return order.name.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allOrder(){
      axios.get('/api/orders/')
      .then(({data}) => (this.orders = data))
      .catch()
    },
   

  },
  created(){
    this.allOrder();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>