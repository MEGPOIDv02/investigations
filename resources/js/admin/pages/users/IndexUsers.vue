<template>
    <Section class="main-container pb-5">
        <Header title="Usuarios" image="/img/admin/sidebar/userWhite.svg"></Header>
        <div class="row mx-1" style="margin-top: 0.5rem">
            <div class="col-4 offset-8 text-end">
                <FormUser
                    :is-update="false"
                ></FormUser>
            </div>
        </div>
        <SatoriGrid
            :rows="rows"
            :total_rows="total_rows"
            :is_loading="isLoading"
            :toggle_button="false"
            :page_size="queryParams.per_page"
            @on-change-query="onChangeQuery"
            :columns="columns">
            <template v-slot:action-slot="{data}">
                <DetailsUsers
                    :data-user="data"
                >
                </DetailsUsers>
                <FormUser
                    :is-update="true"
                    :data-update="data"
                >
                </FormUser>
                <v-icon
                    color="red"
                    class="txt-blue-2"
                    style="margin-left: 5%; margin-top: -0.2rem"
                    @click="deleteData(data)"
                >{{ 'fas fa-trash' }}
                </v-icon>
            </template>
        </SatoriGrid>
    </Section>
</template>

<script>

import SatoriGrid from "../../../components/commons/data-table/vuetify-satori-table"
import MixinSatoriTable from "../../../components/mixins/MixinSatoriTable";
import FormUser from "../../components/users/FormUser";
import DetailsUsers from "../../components/users/DetailsUsers";
import Header from "../../components/header/Header";
import {bus} from "../../app";
export default {
    name: "IndexUsers",
    components: {SatoriGrid, FormUser, Header,DetailsUsers },
    mixins: [MixinSatoriTable],
    created() {
        this.URL_INDEX_CONTENT=route('admin_user_index_content');
        this.URL_UPDATE_STATUS = route('admin_user_active',{userId: 'FAKE_ID'});
    },
    data: () =>
        ({
            columns: [
                {
                    label: "Nombre",
                    name: "name",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Correo",
                    name: "email",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Rol",
                    name: "role.name",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "",
                    name: "actions",
                    slot_name: "action-slot",
                }
            ],
        }),
    methods: {
        fetchData(preventSpinner = false) {
            let params = this.prepareParams(preventSpinner);
            axios.get(this.URL_INDEX_CONTENT, {params: params}).then((response) => {
                this.isLoading = false;
                this.rows = response.data.data;
                this.total_rows = response.data.count;
            }).catch(function (error) {
                console.error(error);
            });
        },
        deleteData(data){
            this.$swal({
                title: '¿Estás Seguro?',
                text: "¡Esta acción no se puede revertir!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Borrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let deleteData = this.URL_UPDATE_STATUS.replace('FAKE_ID', data.id);
                    axios({
                        method: 'GET',
                        url: deleteData,
                    }).then(response => {
                        if (response.data.success) {
                            this.$swal(
                                {
                                    title: '¡Usuario Borrado!',
                                    text: 'El usuario ha sido borrado con éxito',
                                    icon: 'success',
                                    confirmButtonText: 'Confirmar',
                                    confirmButtonColor: '#048CC4'
                                }
                            );
                            bus.$emit('reload-grid');
                        }
                    });
                }
            })
        }
    },
}
</script>

<style scoped>

</style>
