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
                width="180"
                height="40"
                class="text-white rounded"
                v-on="on"
                v-bind="attrs"
            >
                AGREGAR USUARIO
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
                        <div><span class="titles-modal mt-5">{{isUpdate ? 'Modificar' : 'Agregar'}} usuario</span></div>
                    </div>
                    <v-form ref="form" lazy-validation>
                        <v-col cols="12" class="px-2">
                            <div class="fields-modal">Nombre:</div>
                            <v-text-field
                                v-model="name"
                                :rules="rules.name"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Email:</div>
                            <v-text-field
                                v-model="email"
                                :rules="[rules.email,rules.emailType]"
                                style="border-radius: 10px;"
                                type="email"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Contraseña:</div>
                            <v-text-field
                                v-if="!isUpdate"
                                v-model="password"
                                type="password"
                                style="border-radius: 10px;"
                                :rules="passwordRules"
                                outlined
                                dense
                            ></v-text-field>
                            <v-text-field
                                v-else
                                v-model="password"
                                type="password"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Confirmar contraseña:</div>
                            <v-text-field
                                v-model="confirmPassword"
                                type="password"
                                :rules="passwordConfirmRules"
                                style="border-radius: 10px;"
                                outlined
                                dense
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" class="px-2" style="margin-top: -2rem;">
                            <div class="fields-modal">Tipo de usuario:</div>
                            <v-autocomplete
                                v-model="fk_id_role"
                                :items="itemsRole"
                                item-text="name"
                                item-value="id"
                                :rules="rules.fk_id_role"
                                style="border-radius: 10px;"
                                dense
                                outlined
                            ></v-autocomplete>
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
    name: "FormUser",
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
        this.URL_CREATE_USER = route('admin_user_create');
        this.URL_UPDATE_USER = route('admin_user_update', {userId: 'FAKE_ID'});
        this.URL_SELECT_ROLE = route('select_role');
    },
    mounted() {
        this.getRoles();
    },
    data() {
        return {
            dialog: false,
            loading: false,
            modalLoading: false,
            id: '',
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            passwordRules: [],
            passwordConfirmRules: [],
            fk_id_role: '',
            itemsRole: [],

            rules: {
                name: [v => !!v || 'El nombre es necesario'],
                email: [v => !!v || 'El correo es necesario'],
                emailType: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Su correo no es valido.'
                },
                fk_id_role: [v => !!v || 'El tipo de usuario es necesario'],
            },
        }
    },
    watch:{
        password(val) {
            if (val !== '' && val !== null && val !== undefined) {
                this.passwordRules = [
                    v => !!v || 'La contraseña es necesaria',
                    v => (v && v.length >= 8) || 'La contraseña debe tener contener al menos 8 dígitos'
                ];
            }
            if (val !== this.confirmPassword) {
                this.passwordConfirmRules = [
                    'Las contraseñas no coinciden'
                ];
            } else {
                this.passwordConfirmRules = [];
            }
        },
        confirmPassword(val) {
            if (val !== this.password) {
                this.passwordConfirmRules = [
                    'Las contraseñas no coinciden'
                ];
            } else {
                this.passwordConfirmRules = [];
            }
        },
    },
    methods: {
        goBack() {
            this.dialog = false;
            this.$refs.form.reset();
        },
        getRoles() {
            axios.get(this.URL_SELECT_ROLE).then(response => {
                this.itemsRole = response.data;

            });
        },
        updateData(dataUpdate) {
            this.id = dataUpdate.id;
            this.name = dataUpdate.name;
            this.email = dataUpdate.email;
            this.password = '';
            this.confirmPassword = '';
            this.fk_id_role = dataUpdate.fk_id_role;
        },
        submit() {
            let valid = this.$refs.form.validate();
            if (valid) {
                //this.loading = true;
                let route = (this.isUpdate) ? this.URL_UPDATE_USER.replace('FAKE_ID', this.dataUpdate.id) : this.URL_CREATE_USER;
                let formData = new FormData();
                formData.append('name', this.name);
                formData.append('email', this.email);
                formData.append('password', this.password);
                formData.append('fk_id_role', this.fk_id_role);
                axios({
                    method: 'POST',
                    url: route,
                    data: formData,
                }).then(response => {
                    if (response.data.success) {
                        this.loading = false;
                        this.$swal(
                            {
                                title: this.isUpdate ? 'Información Actualizada' : '¡Usuario Agregado!',
                                text: this.isUpdate ? 'El usuario ha sido modificado con éxito' : 'El usuario ha sido agregado con éxito',
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
                                text: 'Ya existe un usuario asociado con esta dirección de correo',
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
