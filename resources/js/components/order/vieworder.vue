   

<template>
    
    <div>
        <div>
            <router-link to="/order" class="btn btn-primary">kembali</router-link>
        </div>
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
                      <th>Nama Produk</th>
                      <th>Jumlah</th>
                      <th>Harga</th>
                      <th>Total Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- <tr v-for="orderpengadaan in order_details" :key="orderpengadaan.id">
                      <td>{{orderpengadaan.product_name}}</td>
                      <td>{{orderpengadaan.pro_quantity}}</td>
                      <td>{{orderpengadaan.product_price}}</td>
                      <td>{{orderpengadaan.sub_total}}</td>
                      
                    </tr> -->
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <div class="form-group">
                  <div class="form-row">
                      
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

        created(){
        Reload.$on('AfterAdd',() =>{
            this.allOrderdetail();
            })
        },

        data(){
            return{
            order_details:[],
            pengadaans:[],
            errors:{},
            searchTerm:''
            }
        },
        computed:{
        filtersearch(){
        return this.order_details.filter(orderdetail => {
            return orderdetail.order_id.match(this.searchTerm)
        }) 
        }
        },

        methods:{
             allOrderdetail(id){
                axios.get('/api/order/details/'+id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch()
            },
            // AddToDetail(id){
            // axios.get('/api/addToDetail/'+id)
            //     .then(() => {
            //         Reload.$emit('AfterAdd');
            //         Notification.success()
            //     })
            //     .catch()
            // },
            allPengadaan(){
                axios.get('/api/pengadaan/')
                .then(({data}) => (this.pengadaans = data))
                .catch()
            },

        },

        created(){
        // this.allOrderdetail();
        this.allPengadaan();
        }

    } 
</script>


<style type="text/css">
    
</style>