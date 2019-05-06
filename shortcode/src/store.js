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
    // placemarks: [],
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
        return {...item, iconImage: 'circle.svg'}
      })

      const coord = state.adds[0].coordinates
      state.coords = [coord.lat, coord.lng]

    },
    /*initPlacemarks (state) {
      state.adds.forEach((item) => {
          const coord = item.coordinates
          state.placemarks.push({
            coords: [coord.lat, coord.lng],
            properties: {},
            options: {
              iconLayout: 'default#image',
              iconImageHref: wp_data.plugin_dir_url + 'img/circle.svg',
              iconImageSize: [40, 40],
              iconImageOffset: [0, 0],
            },
            // callbacks: {click: (event) => {console.log(event)}},
          })
        },
      )
      console.log(state.placemarks)
    },*/
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
