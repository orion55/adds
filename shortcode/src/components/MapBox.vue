<template>
    <yandex-map zoom="14" id="map-box" :options="options" :coords="coords" @map-was-initialized="initHandler"
                :scrollZoom="scrollZoom" :placemarks="placemarks" @map-initialization-started="beforeHandler"
    >
    </yandex-map>
</template>

<script>
  import { yandexMap, ymapMarker } from 'vue-yandex-maps'
  import store from '../store'
  import { mapState } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'MapBox',
    store,
    components: {
      yandexMap,
      ymapMarker,
    },
    data () {
      return {
        options: {
          apiKey: wp_data.api_key,
          lang: 'ru_RU',
          version: '2.1',
        },
        scrollZoom: false,
        placemarks: []
      }
    },
    methods: {
      beforeHandler: () => {
        let arr = []
        store.state.adds.forEach((item) => {
            const coord = item.coordinates
            arr.push({
              coords: [coord.lat, coord.lng],
              properties: {},
              options: {
                iconLayout: 'default#image',
                iconImageHref: wp_data.plugin_dir_url + 'img/' + item.iconImage,
                iconImageSize: [40, 40],
                iconImageOffset: [0, 0],
              },
              callbacks: {click: (event) => {console.log(event)}},
            })
          },
        )
        console.log(arr)
        // console.log(this.placemarks)
      },
      initHandler: function () {
        console.log('init')
        // console.log(this.placemarks)
      },
      initPlacemarks: () => {
        let arr1 = []
        this.adds.forEach((item) => {
            const coord = item.coordinates
            arr1.push({
              coords: [coord.lat, coord.lng],
              properties: {},
              options: {
                iconLayout: 'default#image',
                iconImageHref: wp_data.plugin_dir_url + 'img/' + item.iconImage,
                iconImageSize: [40, 40],
                iconImageOffset: [0, 0],
              },
              callbacks: {click: (event) => {console.log(event)}},
            })
          },
        )
        return arr1
      }
    },
    computed: {
      ...mapState(['coords', 'adds'])
    }
  }
</script>

<style scoped>
    #map-box {
        width: 60%;
        height: 800px;
        background-color: #DFE4E6;
    }

</style>
