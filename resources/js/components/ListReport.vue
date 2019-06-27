<template>
    <div>
        <v-layout row>
            <v-flex xs12 mx-3>
                <v-card>
                    <v-toolbar color="blue lighten-2" dark>
                        <v-spacer></v-spacer>
                        <v-text-field color="white" v-model="search" :search="searchTrigger" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-toolbar>
                    <div v-if="!isSearch">
                        <v-list two-line subheader>
                            <v-subheader>Recent report</v-subheader>
                            <v-list-tile v-for="(item, i) in items" :key="i" avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="item.agenda"></v-list-tile-title>
                                    <v-list-tile-sub-title>{{ item.tanggal }}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-btn icon ripple>
                                        <v-icon @click="showDialog(item)" color="blue lighten-1">info</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                        <v-divider inset></v-divider>
                        <v-list two-line subheader>
                            <v-subheader>Previous reports</v-subheader>
                            <v-list-tile v-for="(item, i) in items2" :key="i" avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="item.agenda"></v-list-tile-title>
                                    <v-list-tile-sub-title>{{ item.tanggal }}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-btn icon ripple>
                                        <v-icon @click="showDialog(item)" color="blue lighten-1">info</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </div>
                    <div v-else>
                        <v-list two-line subheader>
                            <v-subheader>Result Search</v-subheader>
                            <v-list-tile v-for="(item, i) in itemSearch" :key="i" avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="item.agenda"></v-list-tile-title>
                                    <v-list-tile-sub-title>{{ item.tanggal }}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-btn icon ripple>
                                        <v-icon @click="showDialog(item)" color="blue lighten-1">info</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </div>
                </v-card>
            </v-flex>
        </v-layout>
        <!-- <v-layout v-else row>
            <v-flex xs12 mx-3>
                <v-card>
                    <v-toolbar color="blue lighten-2" dark>
                        <v-spacer></v-spacer>
                        <v-text-field color="white" v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
                    </v-toolbar>
                    <v-list two-line subheader>
                        <v-subheader>Previous reports</v-subheader>
                        <v-list-tile v-for="(item, i) in itemSearch" :key="i" avatar>
                            <v-list-tile-content>
                                <v-list-tile-title v-html="item.agenda"></v-list-tile-title>
                                <v-list-tile-sub-title>{{ item.tanggal }}</v-list-tile-sub-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-btn icon ripple>
                                    <v-icon @click="showDialog(item)" color="blue lighten-1">info</v-icon>
                                </v-btn>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout> -->

        <template>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" lazy fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar light>
                            <v-btn icon dark @click="dialog = false">
                                <v-icon light color="black">close</v-icon>
                            </v-btn>
                            <v-toolbar-title>Info Laporan</v-toolbar-title>
                        </v-toolbar>
                        <v-list three-line subheader>
                            <v-subheader>Report Control</v-subheader>
                            <v-layout class="ml-3" row wrap>
                                <v-flex>
                                    <v-card style="border-radius: 3px" class="mr-4 mb-3">
                                        <v-carousel hide-delimiters>
                                            <v-carousel-item v-for="(item,i) in items3" :key="i" :src="'http://127.0.0.1:8000/img/laporan/' + item.foto"></v-carousel-item>
                                        </v-carousel>
                                        <div style="width: 600px !important">
                                            <v-card-title primary-title>
                                                <h2 class="font-weight-regular" style="width:100%;">{{ pekerjaan }}</h2>
                                                <h4 class="font-weight-light">{{ deskripsi }}</h4>
                                                <v-text-field label="Nama Toko"  style="width:100% !important" :value="nama_toko" readonly></v-text-field>
                                                <v-text-field label="No. Handphone" style="width:100% !important" :value="telp" readonly></v-text-field>
                                                <v-text-field label="Tanggal" style="width:100% !important" :value="tanggal" readonly></v-text-field>                                                
                                                <v-text-field label="Alamat"  style="width:100% !important" :value="alamat" readonly></v-text-field>
                                                <v-text-field label="Lokasi Tugas"  style="width:100% !important" :value="lokasi_tugas" readonly></v-text-field>
                                                <v-text-field class="mb-3" label="Lokasi Laporan"  style="width:100% !important" :value="lokasi_laporan" readonly></v-text-field>
                                            </v-card-title>
                                        </div>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-list>
                    </v-card>
                </v-dialog>
            </v-layout>
        </template>

    </div>
</template>
<script>
  export default {
    mounted() {
        this.getRecentListReport();
        this.getPreviousListReport();
    },
    data () {
      return {
        dialog: false,
        pekerjaan: '',
        deskripsi: '',
        alamat: '',
        telp: '',
        nama_toko: '',
        lokasi_tugas: '',
        lokasi_laporan: '',
        tanggal: '',
        ttd_client: '',
        search: '',
        isSearch: '',
        items: [],
        items2: [],
        items3: [],
        itemSearch: []
      }
    },
    computed: {
        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        },
        searchTrigger(){
            if(this.search == ''){
                this.isSearch = false;
                this.getRecentListReport();
                this.getPreviousListReport();
            } else {
                this.isSearch = true;
                this.filteredReports();
            }
        }
    },
    methods: {
        getRecentListReport(){
            axios.get('http://127.0.0.1:8000/list_report/recent').then((response) => {
                this.items = response.data.data;
            });
        },
        getPreviousListReport(){
            axios.get('http://127.0.0.1:8000/list_report/previous').then((response) => {
                this.items2 = response.data.data;
            });
        },
        filteredReports(){
            axios.post('http://127.0.0.1:8000/list_report/search', {
                _token : this.token,
                search : this.search,
            }).then((response) => {
                this.itemSearch = response.data.data;
            });
        },
        showDialog(item){
            this.dialog = true;
            axios.get('http://127.0.0.1:8000/report/foto/' + item.id).then((response) => {
                this.items3 = response.data.data;
                this.pekerjaan = item.agenda;
                this.deskripsi = item.description;
                this.nama_toko = item.nama_toko;
                this.alamat = item.alamat_tujuan;
                this.lokasi_tugas = item.lokasi;
                this.lokasi_laporan = item.lokasi_laporan;
                this.telp = item.telephone;
                this.tanggal = item.tanggal;
            });
        },
    },
  }
</script>