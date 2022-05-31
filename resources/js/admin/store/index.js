import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state:
        {
            sidebar: true,

            //Snackbar
            snack:
                {
                    show: false,
                    message: '',
                    color: null,
                }

        },
    mutations:
        {
            showMessage(state, settings) {

                state.snack.show = true;
                state.snack.message = settings.message;

                switch (settings.status) {
                    case "success":
                        state.snack.color = '#9ACD32';
                        break
                    case "warning":
                        state.snack.color = '#FF5733';
                        break
                    case "error":
                        state.snack.color = '#C70039';
                        break
                }
            },
            closeMessage(state) {
                state.snack.show = false;
            }
        },
    actions:
        {
            showMessage({commit}, settings) {
                commit('showMessage', settings)
            },
            closeMessage({commit}) {
                commit('closeMessage')
            }
        },
});
