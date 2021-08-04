   

<template>
    
    <div>
        <div>
            <router-link to="/order" class="btn btn-primary">Order Pengadaan</router-link>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card-header">
                    <div class="py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">TAMBAH PENGADAAN</h6>
                    </div>
                    <form @submit.prevent="pengadaanInsert">
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
                                    <small class="text-danger" v-if="errors.nama_gudang"> {{ errors.nama_gudang[0] }} </small>
                                    <!-- <input type="text" class="form-control" id="exampleInputFirstName" placeholder="PILIH GUDANG" v-model="form.pilih_gudang"> -->
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleFormControlSelect1">Product Supplier</label>
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="form.supplier">
                                    <option v-for="supplier in suppliers" :key="supplier.id">{{ supplier.name }}</option>
                                    </select>
                                    <small class="text-danger" v-if="errors.supplier"> {{ errors.supplier[0] }} </small>
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
                                    <small class="text-danger" v-if="errors.status_pengadaan"> {{ errors.status_pengadaan[0] }} </small>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlSelect1">Upload Document</label>
                                    <input type="file" class="form-control" id="customFile" @change="onFileSelected" style="display: none">
                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
                                    <label class="form-control" for="customFile" placeholder="Upload Document"></label>
                                    
                                    <!-- <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                    <small class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </small>
                                    <label class="custom-file-label" for="customFile">Choose file</label> -->
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
                            <button class="btn btn-primary" v-for="product in products" @click.prevent="AddToDetail(product.id)" :key="product.id">{{product.product_name}}</button>
                        </div>
                    </form>
                </div>
            </div>
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
                                        <td >{{ pengadaan.product_name }}</td>
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
                                <div class="col-md-6">
                                    <form @submit.prevent="pengadaanInsert">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </form>
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
                supplier: null,
                nama_gudang: null,
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
                axios.post('/api/pengadaaninsert',this.form)
                .then(() => {
                    Notification.success()
                    this.$router.push({name: 'order'})
                })
                .catch(error =>this.errors = error.response.data.errors)
            },

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