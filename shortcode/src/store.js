import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex, axios)

const circleImg = ['circle.svg', 'halfcircle.svg', 'fullcircle.svg']

export default new Vuex.Store({
  state: {
    adds: [],
    loading: true,
    visibility: 'all',
    coords: [43.317776, 45.694909],
    bubbleID: 0,
    bubbleVisibility: false,
    bubbleActiveSide: 0,
    detailsVisibility: false,
    countActiveSides: 0,
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
        })
        .catch((error) => {
          console.log(error)
        })
    },
  },
  mutations: {
    initAddress (state, address) {
      state.adds = _.sortBy(address, ['city', 'street']).map((item) => {

        item.sides = item.sides.map((side) => {
          if (side.img_small === '') {
            side.img_small = wp_data.plugin_dir_url + 'img/placeholder-small.jpg'
          }
          if (side.img_full === '') {
            side.img_full = wp_data.plugin_dir_url + 'img/placeholder-full.jpg'
          }
          return side
        })

        return {
          ...item,
          iconImage: 'circle.svg',
        }
      })

      const coord = state.adds[0].coordinates
      state.coords = [coord.lat, coord.lng]

      state.bubbleID = state.adds[0].id
    },
    changeLoadingState (state, loading) {
      state.loading = loading
    },
    changeCheck (state, index) {
      if (state.bubbleVisibility) {
        this.commit('changeBubbleShow', false)
      }

      let item = _.find(state.adds, {'id': index})
      const coord = item.coordinates
      state.coords = [coord.lat, coord.lng]

      state.bubbleID = item.id
      state.bubbleActiveSide = 0

      _.delay(() => { this.commit('changeBubbleShow', true) }, 500)

    },
    changeBubbleShow (state, flag) {
      state.bubbleVisibility = flag
    },
    changeSideStatus (state, index) {
      let item = _.find(state.adds, {'id': state.bubbleID})
      item.sides[index].status = !item.sides[index].status
      state.bubbleActiveSide = index

      item.check = item.sides.some((side) => {
        return side.status
      })

      let countActiveSides = 0
      item.sides.forEach((side) => {
        if (side.status) {
          countActiveSides++
        }
      })
      item.iconImage = countActiveSides < 2 ? circleImg[countActiveSides] : circleImg[2]

      this.commit('calcCountSides')
    },
    changeDetailsShow (state) {
      state.detailsVisibility = !state.detailsVisibility
    },
    changeBubbleActiveSide (state, index) {
      state.bubbleActiveSide = index
    },
    calcCountSides (state) {
      let n = 0
      state.adds.forEach((item) => {
        item.sides.forEach((element) => {
          if (element.status) {
            n++
          }
        })
      })
      state.countActiveSides = n
    },
  },
})
