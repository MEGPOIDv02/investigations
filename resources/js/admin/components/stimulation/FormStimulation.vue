<template>
    <v-dialog
        v-model="dialog"
        width="500"
        style="border-radius: 2px"
        persistent
    >
        <template
            v-slot:activator="{on, attrs}"
        >
            <v-btn
                v-if="!isUpdate"
                color="#048CC4"
                width="230"
                height="40"
                class="text-white rounded"
                v-on="on"
                v-bind="attrs"
            >
                AGREGAR INVESTIGACIÓN
            </v-btn>
            <v-icon
                v-else
                color="#048CC4"
                class="txt-blue-2"
                style="margin-right: 1rem; margin-top: -0.2rem"
                v-on="on"
                v-bind="attrs"
                @click="updateData(dataUpdate)"
            >{{ 'fas fa-edit' }}
            </v-icon>

        </template>
        <v-card :outline="true" rounded="xl" style="padding: 1.5rem">
            <div class="close-modal">
                <v-icon @click="dialog = false" v-on:click="goBack" class="mt-3 mx-5">{{ 'fal fa-times' }}</v-icon>
            </div>
            <v-card-text>
                <div>
                    <div class="d-flex justify-content-center mt-3" style="text-align: center; margin-bottom: 2rem">
                        <div><span class="titles-modal mt-5">{{isUpdate ? 'Modificar' : 'Agregar'}} Investigación</span></div>
                    </div>
                    <v-form ref="form" lazy-validation>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Título:</div>
                            <v-text-field
                                v-model="name"
                                :rules="rules.name"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Tipo de estimulación:</div>
                            <v-autocomplete
                                v-model="fk_id_stimulation_type"
                                :items="itemsStimulations"
                                item-text="name"
                                item-value="id"
                                :rules="rules.fk_id_stimulation_type"
                                style="border-radius: 10px;"
                                dense
                                outlined
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Adquisición de señales:</div>
                            <v-autocomplete
                                v-model="fk_id_signs_type"
                                :items="itemsSigns"
                                item-text="name"
                                item-value="id"
                                :rules="rules.fk_id_signs_type"
                                style="border-radius: 10px;"
                                dense
                                outlined
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Efectos:</div>
                            <v-textarea
                                v-model="effects"
                                :rules="rules.effects"
                                style="border-radius: 10px;"
                                type="email"
                                outlined
                                dense
                            ></v-textarea>
                        </v-col>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Duración:</div>
                            <v-text-field
                                v-model="duration"
                                :rules="rules.duration"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Frecuencia:</div>
                            <v-text-field
                                v-model="frecuenty"
                                :rules="rules.frecuenty"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Intensidad:</div>
                            <v-text-field
                                v-model="intensity"
                                :rules="rules.intensity"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Tiempo:</div>
                            <v-text-field
                                v-model="time"
                                :rules="rules.time"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Colocación:</div>
                            <v-text-field
                                v-model="colocation"
                                :rules="rules.colocation"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="px-2">
                            <div class="ml-2 fields-modal">Documento:</div>
                            <v-file-input
                                v-model="documentTxt"
                                accept=".txt"
                                outlined
                                dense
                                placeholder="No se ha seleccionado ningún archivo"
                                style="border-radius: 10px"
                                required>
                            </v-file-input>
                        </v-col>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal"><v-checkbox
                                v-model="concent"
                                :rules="rules.concent"
                                label="El estudio cumple con los requisitos éticos y con el consentimiento del sujeto de pruebas"
                            ></v-checkbox>
                            </div>
                        </v-col>
                        <v-col cols="12" class="px-3 d-flex justify-content-center">
                            <v-btn
                                :loading="loading"
                                width="200"
                                height="50"
                                class="btn-blue"
                                @click="submit"
                            >
                                {{ isUpdate ? 'Guardar' : ' Agregar' }}
                            </v-btn>
                        </v-col>
                    </v-form>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import {bus} from "../../app"

export default {
    name: "FormStimulation",
    components: {},
    props: {
        isUpdate: {
            type: Boolean,
            required: true
        },
        dataUpdate: {
            type: Object,
            required: false
        }
    },
    created() {
        this.URL_CREATE_INVESTIGATION = route('admin_stimulation_create');
        this.URL_UPDATE_INVESTIGATION = route('admin_stimulation_update', {investigationId: 'FAKE_ID'});
        this.URL_SELECT_INV_TYPE = route('select_inv_type');
        this.URL_SELECT_STIMULATION = route('select_stimulation_type');
        this.URL_SELECT_SIGNS = route('select_signs_type');
    },
    mounted() {
        this.getStimulations();
        this.getSigns();
    },
    data() {
        return {
            dialog: false,
            loading: false,
            modalLoading: false,
            id: '',
            name: '',
            effects: '',
            duration: '',
            frecuenty: '',
            intensity: '',
            time: '',
            colocation: '',
            concent: false,
            documentTxt: '',
            fk_id_stimulation_type: '',
            itemsStimulations: [],
            fk_id_signs_type: '',
            itemsSigns: [],

            rules: {
                name: [v => !!v || 'El nombre es necesario'],
                effects: [v => !!v || 'Los efectos son necesarios'],
                duration: [v => !!v || 'La duracion es necesaria'],
                intensity: [v => !!v || 'La intensidad es necesaria'],
                time: [v => !!v || 'El tiempo es necesario'],
                colocation: [v => !!v || 'La colocacion es necesaria'],
                concent: [v => !!v || 'El concentimiento es necesario'],
                fk_id_stimulation_type: [v => !!v || 'El tipo de estimulacion es necesario'],
                fk_id_signs_type: [v => !!v || 'La adquisicion de señal es necesaria'],
            },
        }
    },
    methods: {
        goBack() {
            this.dialog = false;
            this.$refs.form.reset();
        },
        getStimulations() {
            axios.get(this.URL_SELECT_STIMULATION).then(response => {
                this.itemsStimulations = response.data;

            });
        },
        getSigns() {
            axios.get(this.URL_SELECT_SIGNS).then(response => {
                this.itemsSigns= response.data;

            });
        },
        updateData(dataUpdate) {
            this.id = dataUpdate.id;
            this.name = dataUpdate.name;
            this.effects = dataUpdate.effects;
            this.duration = dataUpdate.duration;
            this.frecuenty = dataUpdate.frecuenty;
            this.intensity = dataUpdate.intensity;
            this.time = dataUpdate.time;
            this.colocation = dataUpdate.colocation;
            this.concent = dataUpdate.concent;
            this.documentTxt = dataUpdate.document;
            this.fk_id_stimulation_type = dataUpdate.fk_id_inv_stimulation_type;
            this.fk_id_signs_type = dataUpdate.fk_id_inv_sign_type;
        },
        submit() {
            let valid = this.$refs.form.validate();
            if (valid) {
                //this.loading = true;
                let route = (this.isUpdate) ? this.URL_UPDATE_INVESTIGATION.replace('FAKE_ID', this.dataUpdate.id) : this.URL_CREATE_INVESTIGATION;
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('effects', this.effects);
                formData.append('duration', this.duration);
                formData.append('frecuenty', this.frecuenty);
                formData.append('intensity', this.intensity);
                formData.append('time', this.time);
                formData.append('colocation', this.colocation);
                formData.append('concent', this.concent);
                formData.append('documentTxt', this.documentTxt);
                formData.append('fk_id_stimulation_type', this.fk_id_stimulation_type);
                formData.append('fk_id_signs_type', this.fk_id_signs_type);
                axios({
                    method: 'POST',
                    url: route,
                    data: formData,
                }).then(response => {
                    if (response.data.success) {
                        this.loading = false;
                        this.$swal(
                            {
                                title: this.isUpdate ? 'Información Actualizada' : '¡Investigación Agregada!',
                                text: this.isUpdate ? 'La investigación ha sido modificada con éxito' : 'La investigación ha sido agregada con éxito',
                                icon: 'success',
                                confirmButtonText: 'Confirmar',
                                confirmButtonColor: '#048CC4'
                            });
                        bus.$emit('reload-grid');
                        this.dialog = false;
                        this.$refs.form.reset();
                    } else {
                        this.$swal({
                                title: 'Error',
                                text: 'Revise que los datos sean correctos',
                                icon: 'error',
                                confirmButtonText: 'Confirmar',
                                confirmButtonColor: '#048CC4'
                            }
                        );
                        this.loading = false;
                    }
                });
            }
        }
    }
}
</script>

<style scoped>
.icon {
    width: 2rem;
    margin-top: -0.5rem;
}
</style>
