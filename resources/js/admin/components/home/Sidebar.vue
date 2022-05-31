<template>

    <div class="sidebar-container" style="height: 102.5%;width: 105%; margin-top: -1%">

        <v-navigation-drawer
            v-model="drawer"
            :mini-variant.sync="mini"
            permanent
            width="100%"
            class="shadow  bg-side "
        >
            <v-list
                v-if="user.fk_id_role===1">

                <v-list-item
                    link
                    class="my-5"
                    :key="index"
                    :to="item.path"
                    v-for="(item, index) in itemsAdmin"
                >
                    <v-list-item-icon class="img1">
                        <div class="icon">
                            <v-img  class="d-block" :src="item.icon" alt="img"/>
                        </div>
                    </v-list-item-icon>
                    <v-list-item-icon class="img2 d-none">
                        <div class="icon">
                            <v-img   :src="item.icon2" alt="img"/>
                        </div>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title  style="color: white">
                            {{ item.first_title }} <br> {{ item.second_title }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

            </v-list>
            <v-list
                v-else>

                <v-list-item
                    link
                    class="my-5"
                    :key="index"
                    :to="item.path"
                    v-for="(item, index) in itemsStudent"
                >
                    <v-list-item-icon class="img1">
                        <div class="icon">
                            <v-img  class="d-block" :src="item.icon" alt="img"/>
                        </div>
                    </v-list-item-icon>
                    <v-list-item-icon class="img2 d-none">
                        <div class="icon">
                            <v-img   :src="item.icon2" alt="img"/>
                        </div>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title  style="color: white">
                            {{ item.first_title }} <br> {{ item.second_title }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

            </v-list>



        </v-navigation-drawer>

    </div>

</template>

<script>

const imgPrefix = '/img/admin/sidebar/';
const imgPrefix2 = '/img/admin/modals/';

export default {
    name: "Sidebar",
    data: () =>
        ({
            mini: false,
            drawer: true,
            user: '',

            itemsAdmin:
                [
                    {
                        icon: imgPrefix + 'userWhite.svg',
                        icon2: imgPrefix2 + 'userBlue.svg',
                        first_title: 'Usuarios',
                        second_title: '',
                        path: {name: "users"}

                    },
                    {
                        icon: imgPrefix + 'accelometerWhite.svg',
                        icon2: imgPrefix2 + 'accelometerBlue.svg',
                        first_title: 'Acelerometría',
                        second_title: '',
                        path: {name: "accelometer"}

                    },
                    {
                        icon: imgPrefix + 'stimulationWhite.svg',
                        icon2: imgPrefix2 + 'stimulationBlue.svg',
                        first_title: 'Estimulación',
                        second_title: '',
                        path: {name: "stimulation"}

                    },
                    {
                        icon: imgPrefix + 'stabilometryWhite.svg',
                        icon2: imgPrefix2 + 'stabilometryBlue.svg',
                        first_title: 'Estabilometría',
                        second_title: '',
                        path: {name: "stabilometry"}

                    },
                ],
            itemsStudent:
                [
                    {
                        icon: imgPrefix + 'accelometerWhite.svg',
                        icon2: imgPrefix2 + 'accelometerBlue.svg',
                        first_title: 'Acelerometría',
                        second_title: '',
                        path: {name: "accelometer"}

                    },
                    {
                        icon: imgPrefix + 'stimulationWhite.svg',
                        icon2: imgPrefix2 + 'stimulationBlue.svg',
                        first_title: 'Estimulación',
                        second_title: '',
                        path: {name: "stimulation"}

                    },
                    {
                        icon: imgPrefix + 'stabilometryWhite.svg',
                        icon2: imgPrefix2 + 'stabilometryBlue.svg',
                        first_title: 'Estabilometría',
                        second_title: '',
                        path: {name: "stabilometry"}

                    },
                ],
        }),
    created() {
        this.URL_AUTH_USER = route('show_auth_user');
    }, mounted() {
        axios.get(this.URL_AUTH_USER).then(response => {
            this.user = response.data.data;
        });
    }
}
</script>

<style scoped>

.icon
{
    min-width: 1.5rem;
    max-width: 1.5rem;
}


</style>
