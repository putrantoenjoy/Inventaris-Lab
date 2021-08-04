   

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
                    <tr v-for="orderpengadaan in filtersearch" :key="orderpengadaan.id">
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

        // created(){
        // this.DetailProduct();
        // Reload.$on('AfterAdd',() =>{
        //     this.PengadaanDetail();
        //     })
        // },

        data(){
            return{
            order_details:[],
            errors:{},
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
             allOrderdetail(){
                axios.get('/api/order/orderdetails/{id}/')
                .then(({data}) => (this.order_details = data))
                .catch()
            },

        },

        created(){
        this.allOrderdetail();
        }

    } 
</script>


<style type="text/css">
    
</style>