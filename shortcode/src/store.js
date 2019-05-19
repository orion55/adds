import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex, axios)

const circleImg = ['circle.svg', 'halfcircle.svg', 'fullcircle.svg']
const isTest = true

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
    sortID: 0,
    sortDirect: 0,
    searchLine: '',
    listIndex: +isTest,
    contactName: '',
    contactPhone: '',
    contactEmail: '',
  },
  getters: {
    filters: state => {
      let result = _.sortBy(state.adds, ['city', 'street'])

      let fieldsName = ['check', 'city', 'street', 'blocks']
      if (state.sortID > 0) {
        result = _.sortBy(result, fieldsName[state.sortID - 1])
      }

      if (state.sortDirect === 2) {
        result = result.reverse()
      }

      if (state.searchLine !== '') {
        const str = state.searchLine.toLowerCase()
        result = _.filter(result, function (item) {
          return item.city.toLowerCase().indexOf(str) > -1 || item.street.toLowerCase()
            .indexOf(str) > -1
        })
      }
      return result
    },
    selected: state => {
      let result = _.filter(state.adds, ['check', isTest])
      // result = result.reduce((res, current) => [...res, current, current], [])
      // result = _.sampleSize(result, 3)

      result = _.sortBy(result, ['city', 'street'])

      let fieldsName = ['city', 'street', 'blocks']
      if (state.sortID > 0) {
        result = _.sortBy(result, fieldsName[state.sortID - 1])
      }

      if (state.sortDirect === 2) {
        result = result.reverse()
      }
      return result
    },
  },
  actions: {
    loadData ({commit}) {
      axios.get(wp_data.url_ajax + '?action=get_billboards')
        .then((response) => {
          if (response.data.success) {
            commit('initAddress', response.data.data)
            if (isTest) {
              commit('demoData')
            }
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
          blocks: '',
        }
      })

      const coord = state.adds[0].coordinates
      state.coords = [coord.lat, coord.lng]

      state.bubbleID = state.adds[0].id
    },
    demoData (state) {
      let result = _.sampleSize(state.adds, 3)
      result.forEach((item) => {
        item.check = true
        let str = ''
        item.sides.forEach((element) => {
          element.status = true
          str += element.name
        })
        item.blocks = str
      })
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

      this.commit('changeBlocks')
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
    changeHeaderState (state, id) {
      if (state.sortID !== +id) {
        state.sortDirect = 0
      }

      state.sortID = +id

      state.sortDirect++
      if (state.sortDirect > 2) {
        state.sortDirect = 0
        state.sortID = 0
      }
    },
    changeBlocks (state) {
      let item = _.find(state.adds, {'id': state.bubbleID})
      let str = ''
      item.sides.forEach((side) => {
        if (side.status) {
          str += side.name
        }
      })
      item.blocks = str
    },
    updateSearchLine (state, line) {
      state.searchLine = line
    },
    changeListIndex (state, index) {
      state.listIndex += index
    },
    updateContact (state, obj) {
      state['contact' + obj.varName] = obj.varValue
    },
    removeCheck (state, index) {
      let item = _.find(state.adds, {'id': index})
      item.check = false
      item.blocks = ''
      item.sides.forEach((element) => {
        element.status = false
      })
    },
  },
})
