import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex, axios)

const URL = 'https://randomuser.me/api/?results=20&nat=us'

export default new Vuex.Store({
  state: {
    adds: [],
    loading: true,
  },
  actions: {
    loadData ({commit}) {
      axios.get(URL)
        .then((response) => {
          commit('updateAddress', response.data.results)
          commit('changeLoadingState', false)
        })
    },
  },
  mutations: {
    updateAddress (state, address) {
      let i = 0
      address.forEach((item) => {
          const location = item.location
          const obj = {
            id: i,
            check: false,
            city: location.city.charAt(0).toUpperCase() + location.city.slice(1),
            street: location.street,
            coordinates: Object.assign(location.coordinates),
            sides: [
              {
                name: 'A',
                status: Math.random() >= 0.5,
                img: '',
                lighting: false,
              },
              {
                name: 'B',
                status: Math.random() >= 0.5,
                img: '',
                lighting: false,
              },
            ],
            code: item.phone,
            size: location.state,
          }
          state.adds.push(obj)
          i++
        },
      )
    },
    changeLoadingState (state, loading) {
      state.loading = loading
    },
    changeCheck (state, index) {
      let item = _.find(state.adds, {'id': index})
      item.check = !item.check
    }
  },
})
