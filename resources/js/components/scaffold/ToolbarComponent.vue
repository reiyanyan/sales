<template>
    <div>
        <v-toolbar app fixed clipped-left dense>
            <v-toolbar-title>Tangria Spa</v-toolbar-title>
            <v-spacer></v-spacer>
            <div v-if="this.$root.guest == false">
                <v-btn flat @click="logout">Keluar</v-btn>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="token">
                </form>
            </div>
            <div v-else>
                <v-btn flat href="/login" style="text-decoration: none;">Login</v-btn>
                <v-btn flat href="/register" style="text-decoration: none;">Register</v-btn>
            </div>
        </v-toolbar>
    </div>
</template>
<script>
export default {
    data: () => ({
        
    }),
    computed: {
        token() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        }
    },
    methods: {
        logout() {
            document.getElementById('logout-form').submit()
        },
        user_management(){
            window.location.href = "/home";
        },
        laporan(){
            window.location.href = "/laporan";
        },
        job_management(){
            window.location.href = "/job_management";
        },
    }
}
</script>