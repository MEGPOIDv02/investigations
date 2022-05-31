<template>
    <v-dialog
        v-model="dialog"
        width="500"
        style="border-radius: 2px"
    >
        <template v-slot:activator="{on, attrs}">
            <v-icon
                color="#048CC4"
                style="margin-right: 1.5rem;margin-top: -0.2rem"
                v-on="on"
                v-bind="attrs"

            >{{'fas fa-search'}}
            </v-icon>
        </template>
        <v-card :outlined="true" rounded="xl" style="padding: 1rem">
            <div class="close-modal">
                <v-icon @click="dialog = false" class="mt-3 mx-5">{{ 'fal fa-times' }}</v-icon>
            </div>
            <v-card-text>
                <div class="col-12 px-5 py-0 mb-5" style="text-align: center">
                    <div class="d-flex justify-content-center mt-3" style="text-align: center; margin-bottom: 3rem">
                        <div><v-img class="icon" src="/img/admin/modals/accelometerBlack.svg"></v-img></div>
                        <div><span class="titles-modal mt-5">Investigación</span></div>
                    </div>
                    <v-row class="px-3">
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Fecha de carga
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.full_date}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Título
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.name}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Tipo de investigación
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.inv_type.name}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Tipo de estimulación
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.stimulation_type.name}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Adquisición de señales
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.signs_type.name}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Efectos:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.effects}}
                            </p>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Duración:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.duration}}
                            </p>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Frecuencia:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.frecuenty}}
                            </p>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Intensidad:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.intensity}}
                            </p>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Tiempo:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.time}}
                            </p>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <p class="fw-700 fz-md color-txt-black m-0 fields-max-modal-show">
                                Colocación:
                            </p>
                            <p class="fw-400 fz-md color-txt-black m-0 mb-2 subtitle-show">
                                {{dataInvestigation.colocation}}
                            </p>
                        </v-col>
                        <v-col cols="12" class="text-left px-0">
                            <a :href="dataInvestigation.document" download="Investigacion" target="_blank">
                                Descargar Archivo txt
                            </a>
                        </v-col>
                    </v-row>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "DetailsAccelometer",
    props:{
        dataInvestigation: {
            type: Object,
            required: false
        }
    },
    created(){
    },
    data(){
        return{
            dialog: false,

        }
    },
}
</script>

<style scoped>
.icon {
    width: 2rem;
    margin-top: -0.5rem;
}
</style>
