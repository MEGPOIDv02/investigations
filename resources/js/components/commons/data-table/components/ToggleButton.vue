<template>

    <v-icon v-if="isLoading" class="color-secondary mdi-spin mdi-36px">
        mdi-loading
    </v-icon>

    <v-icon v-else-if="dataActive"
            v-on:click="onToggle"
            v-tooltip.top="active ? 'Desactivar' : 'Activar'"
            class="color-blue cursor-pointer mdi-36px">
        mdi-toggle-switch-outline
    </v-icon>

    <v-icon v-else-if="!dataActive"
            v-on:click="onToggle"
            v-tooltip.top="active ? 'Desactivar' : 'Activar'"
            class="grey--text cursor-pointer mdi-36px">
        mdi-toggle-switch-off-outline
    </v-icon>

</template>

<script>
    export default {
        name: "ToggleButton",
        props: {
            dataUpdateUrl: {
                required: true,
                type: String,
            },
            entityId: {
                required: true,
            },
            active: {
                required: true,
            }
        },
        data: () => ({
            isLoading: false,
            dataActive: false,
        }),
        mounted() {
            this.dataActive = this.active;
        },
        methods: {
            onToggle() {
                    this.$swal(
                        {
                            title: this.dataActive ? 'Desactivar' : 'Activar',
                            text:'¿Estás seguro?',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#048CC4',
                            showDenyButton: true,
                            denyButtonText: `Cancelar`,
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            this.$swal(
                                {
                                    title:'¡Hecho!',
                                    text: 'Se realizó el cambio',
                                    icon: 'success',
                                    confirmButtonText: 'Confirmar',
                                    confirmButtonColor: '#048CC4',
                                })
                            this.isLoading = true;
                            let url = this.dataUpdateUrl.replace('FAKE_ID', this.entityId);
                            axios.get(url).then((response) => {
                                this.isLoading = false;
                                if (response.data.success) {
                                    this.dataActive = !this.dataActive;
                                    this.$store.commit('setSuccessSnackbar', 'Registro actualizado éxitosamente');
                                }
                            });
                        } else if (result.isDenied) {
                            this.$swal(
                                {
                                    title:'¡Cancelado!',
                                    text: 'No se realizaron cambios',
                                    icon: 'error',
                                    confirmButtonText: 'Confirmar',
                                    confirmButtonColor: '#048CC4',
                                })
                        }
                    });
            },
        }
    }
</script>

<style scoped>
.color-blue{
    color: #048CC4 !important;
}
</style>
