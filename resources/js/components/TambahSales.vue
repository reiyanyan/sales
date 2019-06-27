<template>
    <div>
        <v-btn color="green white--text" @click="showDialog" class="mx-3">Tambah Sales</v-btn>

        <template>
            <v-layout row justify-center>
                <v-dialog v-model="dialog" lazy fullscreen hide-overlay transition="dialog-bottom-transition">
                    <v-card>
                        <v-toolbar light>
                            <v-btn icon dark @click="dialog = false">
                                <v-icon light color="black">close</v-icon>
                            </v-btn>
                            <v-toolbar-title>Tambah Sales</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-list three-line subheader>
                            <v-subheader>Sales Control</v-subheader>
                            <v-layout class="ml-3" row wrap>
                                <v-form ref="form" v-model="valid" lazy-validation>
                                    <v-text-field v-model="identitas" :rules="nonNull" label="Identitas" required></v-text-field>
                                    <v-text-field v-model="name" :rules="nonNull" label="Nama" required></v-text-field>
                                    <v-text-field v-model="alamat" :rules="nonNull" label="Alamat" required></v-text-field>
                                    <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
                                    <v-text-field v-model="no_handphone" :mask="mask_phone" :rules="nonNull" label="No. Handphone" prefix="+62" required></v-text-field>
                                    <v-text-field v-model="password" :append-icon="pw_visibility ? 'visibility' : 'visibility_off'" :rules="passwordRules" :type="pw_visibility ? 'text' : 'password'" label="Password" hint="At least 8 characters" @click:append="pw_visibility = !pw_visibility" required></v-text-field>
                                    <v-text-field v-model="passwordConfirm" :append-icon="pwc_visibility ? 'visibility' : 'visibility_off'" :rules="passwordConfirmRules" :type="pwc_visibility ? 'text' : 'password'" label="Password Confirmation" @click:append="pwc_visibility = !pwc_visibility" required></v-text-field>
                                    <v-btn :disabled="!valid" color="success" @click="validate">
                                        SAVE
                                    </v-btn>
                                </v-form>
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
    data(){
        return {
            dialog: false,
            id: '',
            identitas: '',
            name: '',
            alamat: '',
            email: '',
            no_handphone: '',
            password: '',
            passwordConfirm: '',
            mask_phone: '###-###-###-###',
            pw_visibility: false,
            pwc_visibility: false,
            valid: true,
            items :{
                identitas: this.identitas,
                name : this.name,
                email : this.email,
                alamat : this.alamat,
                no_hp : '0' + this.no_handphone,
            },
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 8) || 'Min 8 characters'
            ],
            passwordConfirmRules: [
                v => !!v || 'Password Confirmation is Required',
                v => v == this.password || "Password doesn't match"
            ],
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
        }
    },
    computed: {
        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        }
    },
    methods: {
        showDialog(){
            this.dialog = true;
        },
        validate () {
            if (this.$refs.form.validate()) {
                var self = this.$root;
                axios.post('http://127.0.0.1:8000/user/store', {
                    _token: this.token,
                    identitas : this.identitas,
                    name : this.name,
                    email : this.email,
                    alamat : this.alamat,
                    no_hp : '0' + this.no_handphone,
                    password: this.password
                }).then((response) => {
                    if(response.data.message == 'fails'){
                        Swal.fire('Error', 'Email sudah ada', 'error');
                        this.email = '';
                    } else {
                        this.items.identitas = this.identitas;
                        this.items.name = this.name;
                        this.items.email = this.email;
                        this.items.alamat = this.alamat;
                        this.items.no_hp = '0' + this.no_handphone;
                        this.items.password= this.password;
                        this.dialog = false;
                        self.desserts.push(this.items);
                        this.$refs.form.reset();
                        Swal.fire('Sukses', 'Sukses Menambahkan Sales', 'success').then((result) => {
                            if(result.value) window.location.reload();
                        });
                    }
                }, (error) => {
                    console.log(error);
                });
            }
      },
    },
}
</script>
