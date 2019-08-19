<template>
    <div>
        <v-layout row wrap>
            <v-flex v-for="sales in list_sales" :key="sales.id">
                <v-card style="border-radius: 5px" width="350" class="m-3">
                    <v-card-title primary-title>
                        <div>
                            <div class="headline">{{ sales.name }}</div>
                            <span class="grey--text">{{ sales.email }}</span>
                        </div>
                    </v-card-title>
        
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn flat @click="showDialog(sales.id)" style="text-decoration: none" color="purple">Pekerjaan</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>

        <template>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" lazy fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar light>
                            <v-btn icon dark @click="dialog = false">
                                <v-icon light color="black">close</v-icon>
                            </v-btn>
                            <v-toolbar-title>Info Pekerjaan</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn flat color="green" @click="showDialogInfo(null)">Tambah</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-list three-line subheader>
                            <v-subheader>Job Control</v-subheader>
                            <v-layout class="ml-3" style="width: 600px !important" wrap>
                                <v-flex v-for="job in job_list" :key="job.id">
                                <!-- <v-flex v-for="i in 5" :key="i" class="mb-4"> -->
                                    <v-card style="border-radius: 3px" c class="m-2" width="500px">
                                        <v-card-title primary-title>
                                            <div>
                                                <div class="headline">{{ job.nama_agenda }}</div>
                                            </div>
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn flat @click="showDialogInfo(job)" style="text-decoration: none" color="purple">Info</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-list>
                    </v-card>
                </v-dialog>
            </v-layout>
        </template>

        <template>
            <v-layout row justify-center>
                <v-dialog v-model="infoDialog" persistent max-width="600px">
                    <v-card>
                        <v-form ref="form" v-model="valid" lazy-validation>
                            <v-card-title>
                                <span class="headline">Info Job</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <v-text-field v-model="pekerjaan" :rules="nonNull" label="Pekerjaan" required></v-text-field>
                                            <v-text-field v-model="alamat_tujuan" :rules="nonNull" label="Alamat Tujuan" required></v-text-field>
                                            <v-text-field v-model="nama_toko" :rules="nonNull" label="Nama Toko" required></v-text-field>
                                            <v-text-field v-model="handphone" :rules="nonNull" :mask="mask_phone" label="Nomor Handphone" required></v-text-field>
                                            <v-text-field v-model="lokasi" :rules="nonNull" label="Lokasi" required></v-text-field>
                                            <v-text-field v-model="date" label="Tanggal" readonly @click="modal = true"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red darken-1" flat v-show="showInfo" @click="deleteJobs(job_id)">Hapus</v-btn>
                                <v-btn color="blue darken-1" flat @click="emptyField">Batal</v-btn>
                                <v-btn color="blue darken-1" flat @click="storeJobSales(job_id)">Simpan</v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-dialog>
            </v-layout>
        </template>

        <template>
            <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent lazy full-width width="290px">
                <v-date-picker v-model="date" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="modal = false">Cancel</v-btn>
                    <v-btn flat color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
                </v-date-picker>
            </v-dialog>
        </template>

        <template>
            <div class="text-xs-center">
                <v-dialog v-model="dialog_loading" hide-overlay persistent width="300">
                    <v-card color="primary" dark>
                        <v-card-text>
                            Please stand by
                            <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
                        </v-card-text>
                    </v-card>
                </v-dialog>
            </div>
        </template>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getListSales();
        },
        data(){
            return {
                valid: true,
                dialog: false,
                infoDialog: false,
                dialog_loading: false,
                date: new Date().toISOString().substr(0, 10),
                mask_phone: '#############',
                modal: false,
                list_sales: [],
                job_list: [],
                job_id: '',
                sales_id: '',
                pekerjaan: '',
                alamat_tujuan: '',
                nama_toko: '',
                handphone: '',
                lokasi: '',
                showInfo: false,
                nonNull: [
                    v => !!v || 'Field is Required'
                ],
            }
        },
        props: [
            'url', 'auth_id'
        ],
        methods: {
            showDialog(id){
                this.dialog = true;
                this.sales_id = id
                axios.get('http://127.0.0.1:8000/user/get_job/' + id).then((response) => {
                    this.job_list = response.data.data;
                });                
            },
            showDialogInfo(job){
                if(job == null){
                    this.showInfo = false;
                    this.infoDialog = true;
                } else {
                    this.showInfo = true;
                    this.infoDialog = true;
                    this.job_id = job.id
                    this.sales_id = job.user_id_sasaran
                    this.pekerjaan = job.nama_agenda
                    this.alamat_tujuan = job.alamat_tujuan
                    this.nama_toko = job.nama_toko
                    this.handphone = job.telephone
                    this.lokasi = job.lokasi
                    this.date = new Date(job.tanggal).toISOString().substr(0,10)
                }
            },
            getListSales(){
                let self = this;
                this.dialog_loading = true
                axios.get('http://127.0.0.1:8000/user/list_sales/outpage').then((response) => {
                    this.list_sales = response.data;
                    this.dialog_loading = false
                }, (error) => {
                    this.dialog_loading = false
                    console.log(error);
                });
            },
            storeJobSales(job_id){
                if (this.$refs.form.validate()) {
                    this.snackbar = true
                    this.dialog_loading = true
                    axios.post('http://127.0.0.1:8000/user/store_job', {
                        _token : this.token,
                        agenda_id : job_id,
                        user_id : this.auth_id,
                        user_id_sasaran : this.sales_id,
                        nama_agenda : this.pekerjaan,
                        alamat_tujuan : this.alamat_tujuan,
                        nama_toko : this.nama_toko,
                        telephone : this.handphone,
                        lokasi : this.lokasi,
                        tanggal : this.date
                    }).then((response) => {
                        this.infoDialog = false;
                        this.emptyField();
                        axios.get('http://127.0.0.1:8000/user/get_job/' + this.sales_id).then((response) => {
                            this.job_list = response.data.data;
                            this.dialog_loading = false
                        });          
                    });
                }
            },
            deleteJobs(job_id){
                Swal.fire({
                    title: 'Anda Yakin ?',
                    text: "Anda tidak dapat mengembalikan ini",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!'
                }).then((result) => {
                    if(result.value){
                        axios.post('http://127.0.0.1:8000/user/delete_job', {
                            _token : this.token,
                            agenda_id : job_id
                        }).then((result) => {
                            this.infoDialog = false;
                            this.emptyField();
                            Swal.fire('Sukses', 'Sukses Menghapus Pekerjaan', 'success').then((result) => {
                                if(result.value) window.location.reload();
                            });
                        }, (error) => {
                            console.log(error);
                        });
                    }
                });
            },
            emptyField(){
                this.infoDialog = false
                this.pekerjaan = ''
                this.alamat_tujuan = ''
                this.nama_toko = ''
                this.handphone = ''
                this.lokasi = ''
                this.date = new Date().toISOString().substr(0, 10)
                this.$refs.form.resetValidation()
            }
        },
        computed: {
            binding () {
                const binding = {}
                if (this.$vuetify.breakpoint.mdAndUp) binding.column = true
                return binding
            },
            token() {
                let token = document.head.querySelector('meta[name="csrf-token"]');
                return token.content
            },
        }
    }
</script>
