   

<template>
    
    <div>
        <div>
            <router-link to="/order" class="btn btn-primary">Kembali</router-link>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card-header">
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                    </div>
                    <form @submit.prevent="pengadaanUpdate">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Pilih Gudang</label>
                                    <select id="exampleFormControlSelect1" class="form-control" placeholder="PILIH STATUS PENGADAAN" v-model="form.nama_gudang">
                                        <option value="null" selected hidden disabled>
                                            PILIH GUDANG
                                        </option>
                                        <option value="Gudang 1">
                                            Gudang 1
                                        </option>
                                        <option value="Gudang 2">
                                            Gudang 2
                                        </option>
                                        <option value="Gudang 3">
                                            Gudang 3
                                        </option>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG" v-model="form.pilih_gudang"> -->
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Product Supplier</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier">
                                    <option v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
                                    </select>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Pilih Status Pengadaan</label>
                                    <select id="exampleFormControlSelect1" class="form-control" placeholder="PILIH STATUS PENGADAAN" v-model="form.status_pengadaan">
                                        <option value="null" selected hidden disabled>
                                            PILIH STATUS PENGADAAN
                                        </option>
                                        <option value="lama">
                                            lama
                                        </option>
                                        <option value="baru">
                                            baru
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlSelect1">Upload Document</label>
                                    <label class="form-control" for="customFile" placeholder="Upload Document"></label>
                                    <input type="file" class="form-control" id="customFile" @change="onFileSelected" style="display: none">
                                    
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <img :src="form.photo" style="height: 50px; width: 50px;">
                                </div>
                            </div>
                        </div>
                    </form>
                    <form @submit.prevent="pengadaanUpdate">
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
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
                supplier: '',
                nama_gudang: '',
                status_pengadaan: '',
                document: '',
                photo: '',
                newphoto: ''
            },
            pengadaans:[],
            searchTerm:'',
            errors:{},
            suppliers:{},
            order_pengadaans:{},
            }
        },
        computed:{
            filtersearch(){
            return this.pengadaans.filter(pengadaan => {
                return pengadaan.product_name.match(this.searchTerm)
            }) 
            },
            getfiltersearch() {
            return this.getproducts.filter((getproduct) => {
                return getproduct.product_name.match(this.getsearchTerm);
            });
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

        created(){
          let id = this.$route.params.id
          axios.get('/api/orderpengadaan/'+id)
          .then(({data}) => (this.form = data))
          .catch(console.log('error'))

          axios.get('/api/supplier/')
          .then(({data}) => (this.suppliers = data))
        },

        methods:{
            onFileSelected(event){
            let file = event.target.files[0];
            if (file.size > 1048770) {
              Notification.image_validation()
            }else{
              let reader = new FileReader();
              reader.onload = event =>{
                this.form.photo = event.target.result
              
              };
              reader.readAsDataURL(file);
            }

            },

            pengadaanUpdate(){
                let id = this.$route.params.id
                axios.patch('/api/orderpengadaan/'+id,this.form)
                .then(() => {
                  this.$router.push({ name: 'order'})
                  Notification.success()
                })
                .catch(error =>this.errors = error.response.data.errors)
     
            },

            //detail
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

            // removeDetail(id){
            // axios.get('/api/remove/pengadaan/'+id)
            //     .then(() => {
            //         Reload.$emit('AfterAdd');
            //     })
            //     .catch()
            // },
            // increment(id){
            // axios.get('/api/increment/pengadaan/'+id)
            //     .then(() => {
            //         Reload.$emit('AfterAdd');
            //         Notification.success()
            //     })
            //     .catch()
            // },
            // decrement(id){
            //     axios.get('/api/decrement/pengadaan/'+id)
            //     .then(() => {
            //         Reload.$emit('AfterAdd');
            //         Notification.success()
            //     })
            //     .catch() 
            // }, 

        },

        // created(){
        // this.allPengadaan();
        // Reload.$on('AfterAdd',() =>{
        //     this.allPengadaan();
        // })

        // axios.get('/api/supplier/')
        // .then(({data}) => (this.suppliers = data))

        // axios.get('/api/product/')
        // .then(({data}) => (this.products = data))
        // }

    } 
</script>


<style type="text/css">
    
</style>