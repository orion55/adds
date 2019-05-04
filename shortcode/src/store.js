import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex, axios)

export default new Vuex.Store({
  state: {
    adds: [],
    loading: true,
  },
  actions: {
    loadData ({commit}) {
      axios.get(wp_data.url_ajax + '?action=get_billboards')
        .then((response) => {
          if (response.data.success) {
            commit('updateAddress', response.data.data)
          } else {
            console.log(response.data.data)
          }
          // commit('changeLoadingState', false)
        })
        .catch((error) => {
          console.log(error)
        })
    },
  },
  mutations: {
    updateAddress (state, address) {
      state.adds = address
    },
    changeLoadingState (state, loading) {
      state.loading = loading
    },
    changeCheck (state, index) {
      let item = _.find(state.adds, {'id': index})
      item.check = !item.check
    },
  },
})
