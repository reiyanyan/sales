<template>
    <div>
        <v-card>
            <v-card-title>
                <v-spacer></v-spacer>
                <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
            </v-card-title>
            <v-data-table class="elevation-1" :headers="headers" :loading="loading" :items="this.$root.desserts" :pagination.sync="pagination" :search="searchTrigger" hide-actions>
                <template v-slot:items="props">
                    <td class="text-xs-center">{{ props.item.identitas }}</td>
                    <td class="text-xs-center">{{ props.item.name }}</td>
                    <td class="text-xs-center">{{ props.item.email }}</td>
                    <td class="text-xs-center">{{ props.item.no_hp }}</td>
                    <td class="text-xs-center">
                        <v-icon color="indigo" @click="showDialog(props.item, props.index)">info</v-icon>
                    </td>
                </template>
                <template v-slot:no-results>
                    <v-alert :value="true" color="error" icon="warning">
                        Your search for "{{ search }}" found no results.
                    </v-alert>
                </template>
            </v-data-table>
            <div class="text-xs-center pt-2">
                <v-pagination class="mb-2" v-if="!isSearch" v-model="pagination.current" :length="pagination.total" @input="onPageChange"></v-pagination>
            </div>
        </v-card>

        <template>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" lazy fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar light>
                            <v-btn icon dark @click="dialog = false">
                                <v-icon light color="black">close</v-icon>
                            </v-btn>
                            <v-toolbar-title>Info Sales</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn @click="removeSales()" flat color="red">Delete</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>
                        <v-list three-line subheader>
                            <v-subheader>Sales Control</v-subheader>
                            <v-layout class="ml-3" wrap>
                                <v-form ref="form" v-model="valid" lazy-validation>
                                    <v-text-field v-model="identitas" :rules="nonNull" label="Identitas" required></v-text-field>
                                    <v-text-field v-model="name" :rules="nonNull" label="Nama" required></v-text-field>
                                    <v-text-field v-model="alamat" :rules="nonNull" label="Alamat" required></v-text-field>
                                    <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
                                    <v-text-field v-model="no_handphone" :mask="mask_phone" :rules="nonNull" label="No. Handphone" prefix="+62" required></v-text-field>
                                    <v-btn :disabled="!valid" color="success" @click="validate">
                                        Simpan
                                    </v-btn>
                                </v-form>
                            </v-layout>
                        </v-list>
                    </v-card>
                </v-dialog>
            </v-layout>
        </template>

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

    </div>
</template>
<script>
  export default {
    data () {
      return {
        search: '',
        id: '',
        identitas: '',
        name: '',
        alamat: '',
        email: '',
        no_handphone: '',
        password: '',
        index: '',
        isSearch: false,
        loading: true,
        mask_phone: '###-###-###-###',
        dialog: false,
        valid: true,
        select: null,
        checkbox: false,
        dialog_loading: false,
        items :{
            identitas: this.identitas,
            name : this.name,
            email : this.email,
            alamat : this.alamat,
            no_hp : '0' + this.no_handphone,
        },
        pagination: {
            rowsPerPage: 10,
            current: 1,
            total: 0
        },
        nameRules: [
            v => !!v || 'Name is required',
            v => (v && v.length <= 10) || 'Name must be less than 10 characters'
        ],
        nonNull: [
            v => !!v || 'Field is Required'
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid'
        ],
        headers: [
          { text: 'Identitas', align: 'center', sortable: false, value: 'identitas'},
          { text: 'Nama', value: 'name', align: 'center' },
          { text: 'E-Mail', value: 'email', align: 'center' },
          { text: 'No. Handphone', value: 'alamat', align: 'center' },
          { text: 'Actions', sortable: false, align: 'center'}
        ],
      }
    },
    props:[
        'url_list_sales'
    ],
    computed: {
        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        },
        searchTrigger(){
            if(this.search == ''){
                this.loading = true;
                this.isSearch = false;
                this.getListSales();
            } else {
                this.isSearch = true;
                this.loading = true;
                this.filteredSales();
            }
        },
    },
    methods: {
      showDialog(data, index){
          this.dialog = true;
          this.id = data.id;
          this.identitas = data.identitas;
          this.name = data.name;
          this.email = data.email;
          this.alamat = data.alamat;
          this.no_handphone = data.no_hp != null ? data.no_hp.substr(1) : data.no_hp ;
          this.index = index;
      },
      onPageChange(){
          this.getListSales();
      },
      validate () {
          var self = this.$root;
        if (this.$refs.form.validate()) {
            axios.post('http://127.0.0.1:8000/user/update', {
                _token : this.token,
                id : this.id,
                identitas : this.identitas,
                name : this.name,
                email : this.email,
                alamat : this.alamat,
                no_hp : '0' + this.no_handphone
            }).then((response) => {
                this.items.identitas = this.identitas;
                this.items.name = this.name;
                this.items.email = this.email;
                this.items.alamat = this.alamat;
                this.items.no_hp = '0' + this.no_handphone;
                this.dialog = false;
                Swal.fire({
                    title: 'Sukses',
                    text: 'Sukses Mengupdate Sales',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if(result.value){
                        location.reload();
                    }
                });
            }, (error) => {
                console.log(error);
            });
        }
      },
      filteredSales(){
        axios.post('http://127.0.0.1:8000/user/search', {
            _token : this.token,
            search : this.search,
        }).then((response) => {
            this.loading = false;
            return this.$root.desserts = response.data;
        });
      },
      reset () {
        this.$refs.form.reset()
      },
      getListSales(){
        let self = this.$root;
        this.dialog_loading = true;
        axios.get("http://127.0.0.1:8000/user/list_sales?page=" + this.pagination.current).then((response) => {
            self.desserts = response.data.data
            this.dialog_loading = false;
            this.loading = false;
            this.pagination.current = response.data.current_page;
            this.pagination.total = response.data.last_page;
        }, (error) => {
            console.log(error);
        });
      },
      removeSales(){
        var self = this.$root;

        Swal.fire({
            title: 'Anda Yakin ?',
            text: "Anda tidak dapat mengembalikan ini",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.value) {
                axios.post('http://127.0.0.1:8000/user/delete', {
                    _token : this.token,
                    id : this.id
                }).then((response) => {
                    self.desserts.splice(this.index, 1);
                    this.dialog = false;
                    Swal.fire('Sukses', 'Sukses Menghapus Sales', 'success').then((result) => {
                        if(result.value) window.location.reload();
                    });
                }, (error) => {
                    console.log(error);
                });
            }
        })

      }
    }
  }
</script>