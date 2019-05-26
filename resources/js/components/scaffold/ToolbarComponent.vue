<template>
    <div>
        <v-navigation-drawer v-model="drawer" clipped fixed app>
            <v-list dense>
                <v-list-tile @click="user_management">
                    <v-list-tile-action>
                        <v-icon v-if="this.$root.current_url == '/home'" color="indigo">verified_user</v-icon>
                        <v-icon v-else>verified_user</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            User Management
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="job_management">
                    <v-list-tile-action>
                        <v-icon v-if="this.$root.current_url == '/job_management'" color="indigo">favorite</v-icon>
                        <v-icon v-else>favorite</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            Job Sales Management
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="laporan">
                    <v-list-tile-action>
                        <v-icon v-if="this.$root.current_url == '/laporan'" color="indigo">favorite</v-icon>
                        <v-icon v-else>favorite</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            Laporan
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>

        </v-navigation-drawer>

        <v-toolbar app fixed clipped-left dense>
            <v-toolbar-side-icon v-if="guest == 0" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Sales Report</v-toolbar-title>
            <v-spacer></v-spacer>
            <!-- <v-menu bottom left>
                <v-btn slot="activator" icon>
                    <v-icon large>account_circle</v-icon>
                </v-btn>

                <v-list dense>
                    <v-list-tile >
                        <v-list-tile-avatar size="23"> 
                            <img src="https://cdn.vuetifyjs.com/images/john.jpg">
                        </v-list-tile-avatar>

                        <v-list-tile-content>
                            <v-list-tile-title>Oke</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>

                <v-list>
                    <v-list-tile @click="logout">
                        <v-list-tile-title>Logout</v-list-tile-title>
                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                            <input type="hidden" name="_token" :value="token">
                        </form>
                    </v-list-tile>
                </v-list> 
            </v-menu> -->
            <div v-if="guest == 0">
                <v-btn flat @click="logout">Keluar</v-btn>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    <input type="hidden" name="_token" :value="token">
                </form>
                <!-- <v-menu v-model="menu" :close-on-content-click="false" :nudge-width="150" offset-y>
                    <template v-slot:activator="{ on }">
                        <v-btn v-on="on" icon style="outline: 0; box-shadow: none!important;">
                            <v-icon class="mr-2" large>account_circle</v-icon>
                        </v-btn>
                    </template>

                    <v-card>
                        <v-list dense>
                            <v-list-tile @click="logout">
                                <v-list-tile-action> 
                                    <v-icon medium>exit_to_app</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Logout</v-list-tile-title>
                                </v-list-tile-content>
                                
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-menu> -->
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
        drawer : false,
        menu: false,
    }),
    props: [
        'guest'
    ],
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