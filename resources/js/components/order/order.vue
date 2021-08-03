   

<template>
  
  <div>
    <!-- <b-button v-b-modal="'modal1'" class="btn btn-danger">View</b-button>
    <b-modal id="modal1" title="modal">
      <p>hai</p>
    </b-modal> -->
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
                <tr v-for="orderpengadaan in order_pengadaans" :key="orderpengadaan.id">
                  <td>{{orderpengadaan.nama_gudang}}</td>
                  <td>{{orderpengadaan.status_pengadaan}}</td>
                  <td>{{orderpengadaan.supplier}}</td>
                  <td><img :src="orderpengadaan.photo" id="em_photo"></td>
                  <td>
                    <router-link :to="{name: 'edit-order', params:{id:orderpengadaan.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                    <a @click="deleteOrderPengadaan(orderpengadaan.id)" class="btn btn-sm btn-danger"><font color="#ffffff">Hapus</font></a>
                  </td>
                </tr>
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
        order_pengadaans:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.order_pengadaans.filter(orderpengadaan => {
         return orderpengadaan.nama_gudang.match(this.searchTerm)
      }) 
      }
    },
 
  methods:{
    allOrderPengadaan(){
      axios.get('/api/orderpengadaan/')
      .then(({data}) => (this.order_pengadaans = data))
      .catch()
    },

    deleteOrderPengadaan(id){
      Swal.fire({
      title: 'Apakah kamu yakin?',
      text: "Kamu tidak akan mendapatkannya kembali",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus sekarang!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        axios.delete('/api/orderpengadaan/'+id)
        .then(() => {
        this.order_pengadaans = this.order_pengadaans.filter(orderpengadaan => {
          return orderpengadaan.id != id
        })
        })
        .catch(() => {
        this.$router.push({name: 'order'})
        })
        Swal.fire(
          'Terhapus!',
          'Gudang telah dihapus.',
          'sukses'
        )
      }
    })

  }
   

  },
  created(){
    this.allOrderPengadaan();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>