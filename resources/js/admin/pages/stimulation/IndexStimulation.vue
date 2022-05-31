<template>
    <Section class="main-container pb-5">
        <Header title="Estimulación" image="/img/admin/sidebar/stimulationWhite.svg"></Header>
        <div class="row mx-1" style="margin-top: 0.5rem">
            <div class="col-4 offset-8 text-end">
                <FormStimulation
                    :is-update="false"
                ></FormStimulation>
            </div>
        </div>
        <CreateTable
            :rows="rows"
            :total_rows="total_rows"
            :is_loading="isLoading"
            :toggle_button="false"
            :page_size="queryParams.per_page"
            @on-change-query="onChangeQuery"
            :columns="columns">
            <template v-slot:action-slot="{data}">
                <DetailsStimulation
                    :data-investigation="data"
                >
                </DetailsStimulation>
                <div v-if="user.fk_id_role===1" class="d-flex justify-content-between">
                    <FormStimulation
                        :is-update="true"
                        :data-update="data"
                    >
                    </FormStimulation>
                    <v-icon
                        color="red"
                        class="txt-blue-2"
                        style="margin-left: 5%; margin-top: -0.2rem"
                        @click="deleteData(data)"
                    >{{ 'fas fa-trash' }}
                    </v-icon>
                </div>
            </template>
        </CreateTable>
    </Section>
</template>

<script>

import CreateTable from "../../../components/commons/data-table/vuetify-satori-table"
import MixinTable from "../../../components/mixins/MixinSatoriTable";
import FormStimulation from "../../components/stimulation/FormStimulation";
import DetailsStimulation from "../../components/stimulation/DetailsStimulation";
import Header from "../../components/header/Header";
import {bus} from "../../app";
export default {
    name: "IndexStimulation",
    components: {CreateTable, FormStimulation, Header,DetailsStimulation },
    mixins: [MixinTable],
    created() {
        this.URL_INDEX_CONTENT=route('admin_stimulation_index_content');
        this.URL_UPDATE_STATUS = route('admin_stimulation_active',{investigationId: 'FAKE_ID'});
        this.URL_AUTH_USER = route('show_auth_user');
    },
    mounted() {
        axios.get(this.URL_AUTH_USER).then(response => {
            this.user = response.data.data;
        });
    },
    data: () =>
        ({
            user: '',
            columns: [
                {
                    label: "Fecha",
                    name: "full_date",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Título",
                    name: "name",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Tipo de investigación",
                    name: "inv_type.name",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Estimulación",
                    name: "stimulation_type.name",
                    filter: {type: "simple",th_style:"padding-top:1rem"},
                },
                {
                    label: "Adquisición de señales",
                    name: "signs_type.name",
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
                                    title: '¡Investigación Borrada!',
                                    text: 'La investigación ha sido borrada con éxito',
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
