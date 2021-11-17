   

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
                    <tr v-for="orderpengadaan in order_details" :key="orderpengadaan.id">
                      <td>{{orderpengadaan.product_name}}</td>
                      <td>{{orderpengadaan.pro_quantity}}</td>
                      <td>{{orderpengadaan.product_price}}</td>
                      <td>{{orderpengadaan.sub_total}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <div class="form-group">
                  <div class="form-row">
                      <div class="col-md-12">
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
        },

        subtotal(){
            let sum = 0;
            for(let i = 0; i < this.order_details.length; i++){
            sum += (parseFloat(this.order_details[i].pro_quantity) * parseFloat(this.order_details[i].product_price));      
        }
            return sum;

        },
        },

        methods:{
             OrderDetailsAll(){
               let id = this.$route.params.id
                axios.get('/api/order/orderdetails/'+id)
                // .then(() => {
                //     Reload.$emit('AfterAdd');
                //     Notification.success()
                // })
                // .catch()

                // axios.get('/api/orderpengadaan/')


                // .then(({data}) => (this.form = data))
                // .catch(console.log('error'))

                .then(({data}) => (this.order_details = data))
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
            // allPengadaan(){
            //     axios.get('/api/pengadaan/')
            //     .then(({data}) => (this.pengadaans = data))
            //     .catch()
            // },

        },

        created(){
        this.OrderDetailsAll();
        // this.allPengadaan();
        }

    } 
</script>


<style type="text/css">
    
</style>