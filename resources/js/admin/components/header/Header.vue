<template>
    <v-app-bar
        absolute
        color="black"
        class="nav-bar shadow-sm mb-3"
    >
        <div class="row justify-content-between size-row">
            <v-col cols="2"  class="size-row py-1">
            </v-col>
            <v-col cols="8 text-center" class="size-row">
                <div class="row">
                    <v-col cols="12">

                        <div class="fw-700">
                            <v-avatar rounded>
                                <div class="icon"><v-img v-bind:src="image"></v-img></div>
                            </v-avatar>

                            <span class=" fs-title txt-white my-auto pa-0">{{title}}</span>
                            <span class="fs-title my-auto pa-0"><b>{{subtitle}}</b></span>
                        </div>
                    </v-col>

                </div>

            </v-col>
            <v-col cols="2" class="size-row">
                <div class="row">
                    <v-col cols="4 text-end">
                        <v-avatar rounded>
                            <div class="iconLogin"><v-img src="/img/admin/login/logo_icon.png"></v-img></div>
                        </v-avatar>
                    </v-col>
                    <v-col cols="8" style="margin-left: -1rem">
                        <ul class="user txt-white fz-sm me-1 mb-0" style="margin-left: -1.5rem">
                            <li><b>{{ user.name }}</b></li>
                            <li><a
                                style="color: #048CC4"
                                v-on:click="onClick"
                            >{{ logout.name }}</a></li>
                        </ul>
                    </v-col>
                </div>

            </v-col>
        </div>

    </v-app-bar>
</template>

<script>
export default {
    name: "Header",
    props: {
        title: {
            type: String,
            required: false
        },
        subtitle: {
            type: String,
            required: false
        },
        image: {
            type: String,
            required: false
        }
    },
    data(){
        return {
            user: '',
            logout: {
                name: 'Cerrar sesión',
                path: route('admin.logout')
            },
            loadingData: true,
        }
    },
    methods: {
        onClick() {
            this.$swal(
                {
                    title: 'Cerrar sesión',
                    text:'¿Estás seguro de cerrar sesión?',
                    icon: 'success',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#048CC4',
                    showDenyButton: true,
                    denyButtonText: `Cancelar`,
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location.href=this.logout.path;
                } else if (result.isDenied) {

                }
            });
        },

    },
    created() {
        this.URL_AUTH_USER = route('show_auth_user');
    },
    mounted() {
        axios.get(this.URL_AUTH_USER).then(response => {
            this.user = response.data.data;
            this.loadingData = false;
        });
    }
}
</script>

<style scoped>
.size-row{
    height: 64px;
}

.nav-bar{
    position: absolute;
    top: 0;
    z-index: 1;
}
.iconLogin{
    width: 2.5rem;
}
.icon{
    width: 2rem;
}
.icon2{
    width: 1rem;
}
.txt-white{
    color:white ;
    font-weight: bold;
}
.user li{
    text-decoration: none;
    list-style: none;
}
.fs-title{
    font-size: 1.5rem;
}

</style>


