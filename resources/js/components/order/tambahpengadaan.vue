   

<template>
    
    <div>
        
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card-header">
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                    </div>
                    <form   enctype="multipart/form-data" class="user">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Pilih Gudang</label>
                                    <select id="exampleFormControlSelect1" class="form-control" placeholder="PILIH STATUS PENGADAAN" v-model="form.pilih_gudang">
                                        <option value="null" selected hidden disabled>
                                            PILIH GUDANG
                                        </option>
                                        <option value="1">
                                            Gudang 1
                                        </option>
                                        <option value="2">
                                            Gudang 2
                                        </option>
                                        <option value="3">
                                            Gudang 3
                                        </option>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG" v-model="form.pilih_gudang"> -->
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Product Supplier</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier_id">
                                    <option value="supplier.name" v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
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
                                        <option value="1">
                                            benda cair
                                        </option>
                                        <option value="2">
                                            benda padat
                                        </option>
                                        <option value="3">
                                            benda gas
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlSelect1">Upload Document</label>
                                    <label class="form-control" for="customFile" placeholder="Upload Document">{{form.photo ? form.photo.name :''}}</label>
                                    <input type="file" class="form-control" id="customFile" @change="onFileSelected" style="display: none">
                                    <!-- <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small> -->
                                    
                                </div>
                                <div class="col-md-2">
                                    <br>
                                    <img :src="form.photo" style="height: 50px; width: 50px;">
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="user"  enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="form-row"> 
                                <div class="col-md-12">
                                    <label for="exampleFormControlSelect1">Pilih Barang</label>
                                    <!-- <select class="form-control" id="exampleFormControlSelect1" v-model="form.product_id" placeholder="PILIH BARANG">
                                        <option value="product.product_name" v-for="product in products" :key="product.id">{{ product.product_name }}</option>
                                    </select> -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- <button type="submit" class="btn btn-primary">submit</button> -->
                            <button class="btn btn-primary" v-for="product in products" @click.prevent="AddToDetail(product.id)">{{product.product_name}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-6" v-for="product in products" :key="product.id">
                <button class="btn btn-sm" @click.prevent="AddToDetail(product.id)">
                <div class="card" style="width: 8.5rem; margin-bottom: 5px;">
                    <img :src="product.image" id="em_photo" class="card-img-top">
                    <div class="card-body">
                    <h6 class="card-title">{{ product.product_name }}</h6>
                    <span class="badge badge-success" v-if="product.product_quantity  >= 1 ">Available {{ product.product_quantity }}  </span> 
                    <span class="badge badge-danger" v-else=" ">Stock Out </span>
                    </div>
                </div>
                </button>
            </div>
        </div>
        <form @submit.prevent="AddToDetail(product.id)">
            <select class="form-control" id="exampleFormControlSelect1">
                <option value="product.product_name" v-for="product in products" :key="product.id">{{ product.product_name }}</option>
            </select>
            <button class="btn btn-sm" >submit</button>
        </form> -->
        
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
                                    <tr v-for="pengadaan in filtersearch" :key="pengadaan.id">
                                        <td>{{ pengadaan.product_name }}</td>
                                        <td>{{ pengadaan.product_code }}</td>
                                        <td><input type="text" readonly="" style="width: 40px;" :value="pengadaan.product_quantity">
                                            <button @click.prevent="increment(pengadaan.id)" class="btn btn-sm btn-success">+</button>
                                            <button  @click.prevent="decrement(pengadaan.id)" class="btn btn-sm btn-danger" v-if="pengadaan.product_quantity >= 2">-</button>
                                            <button class="btn btn-sm btn-danger" v-else="" disabled="">-</button>
                                        </td>
                                        <td>{{ pengadaan.selling_price }}</td>
                                        <td>{{ pengadaan.sub_total }}</td>
                                        <td><a @click="removeDetail(pengadaan.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a></td>
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
        this.DetailProduct();
        Reload.$on('AfterAdd',() =>{
            this.PengadaanDetail();
            })
        },

        data(){
            return{
            form:{
                supplier_id: null,
                pilih_gudang: null,
                input_document: null,
                status_pengadaan: null,
                photo: null
            },
            pengadaans:[],
            searchTerm:'',
            errors:{},
            suppliers:{},
            products:{},
            // photo:{}
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

        methods:{
            onFileSelected(event){
                let file = event.target.files[0];
                if (file.size > 1048770) {
                Notification.image_validation()
                console.log(event.target.result);
                console.log(event);
                }else{
                let reader = new FileReader();
                reader.onload = event =>{
                this.form.photo = event.target.result
                console.log(event.target.result);
                console.log(event);
                };
                reader.readAsDataURL(file);
                }
            },

            // pengadaanInsert(){
            //     axios.post('/api/pengadaan',this.form)
            //     .then(() => {
            //     this.$router.push({ name: 'pengadaan'})
            //     Notification.success()
            //     })
            //     .catch(error =>this.errors = error.response.data.errors)
            // },

            //detail
            AddToDetail(id){
            axios.get('/api/addToDetail/'+id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch()
            },

            allPengadaan(){
                axios.get('/api/pengadaan/')
                .then(({data}) => (this.pengadaans = data))
                .catch()
            },

            removeDetail(id){
            axios.get('/api/remove/pengadaan/'+id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                })
                .catch()
            },
            increment(id){
            axios.get('/api/increment/pengadaan/'+id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch()
            },
            decrement(id){
                axios.get('/api/decrement/pengadaan/'+id)
                .then(() => {
                    Reload.$emit('AfterAdd');
                    Notification.success()
                })
                .catch() 
            }, 

        },

        created(){
        this.allPengadaan();
        Reload.$on('AfterAdd',() =>{
            this.allPengadaan();
        })

        axios.get('/api/supplier/')
        .then(({data}) => (this.suppliers = data))

        axios.get('/api/product/')
        .then(({data}) => (this.products = data))
        }

    } 
</script>


<style type="text/css">
    
</style>