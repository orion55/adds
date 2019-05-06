import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex, axios)

export default new Vuex.Store({
  state: {
    adds: [],
    loading: true,
    visibility: 'all',
    coords: [],
  },
  getters: {
    filters: state => {
      if (state.visibility === 'all') {
        return _.sortBy(state.adds, ['city', 'street'])
      }
    },
  },
  actions: {
    loadData ({commit}) {
      axios.get(wp_data.url_ajax + '?action=get_billboards')
        .then((response) => {
          if (response.data.success) {
            commit('initAddress', response.data.data)
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
    initAddress (state, address) {
      state.adds = _.sortBy(address, ['city', 'street']).map((item) => {
        return {
          ...item,
          iconImage: 'circle.svg',
        }
      })

      const coord = state.adds[0].coordinates
      state.coords = [coord.lat, coord.lng]

    },
    changeLoadingState (state, loading) {
      state.loading = loading
    },
    changeCheck (state, index) {
      let item = _.find(state.adds, {'id': index})
      // item.check = !item.check
      const coord = item.coordinates
      state.coords = [coord.lat, coord.lng]
    },
  },
})
