<template>

    <v-app>

        <div  style=" margin-top: 4rem; width: 100%; align-self:center">
            <div class="row">
                <div class="col-2">
                    <sidebar></sidebar>
                </div>
                <div class="col-10 shadow  bg-white">
                    <transition>
                        <router-view></router-view>
                    </transition>
                </div>
            </div>
        </div>
    </v-app>

</template>

<script>
import IndexUsers from "./users/IndexUsers";
import Sidebar from "../components/home/Sidebar";

export default {
    name: "App",
    components: {Sidebar, IndexUsers},
    data: () =>
        ({
            year: new Date().getFullYear(),
        })
}
</script>

<style scoped>

</style>

