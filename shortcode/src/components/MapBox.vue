<template>
    <div id="map-box">
        <yandex-map :zoom="zoomMap" :options="options" :coords="coords"
                    @map-was-initialized="initHandler"
                    :scrollZoom="scrollZoom" :placemarks="placemarks" ref="mapschild"
        >
        </yandex-map>
        <Bubble></Bubble>
    </div>
</template>

<script>
  import { yandexMap, ymapMarker } from 'vue-yandex-maps'
  import store from '../store'
  import { mapMutations, mapState } from 'vuex'
  import Bubble from './Bubble'

  export default {
    name: 'MapBox',
    store,
    components: {
      yandexMap,
      ymapMarker,
      Bubble,
    },
    data () {
      return {
        options: {
          // apiKey: wp_data.api_key,
          lang: 'ru_RU',
          version: '2.1',
        },
        scrollZoom: false,
        placemarks: [],
      }
    },
    methods: {
      ...mapMutations(['changeLoadingState']),
      initHandler: function () {
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
        this.placemarks = arr
        this.changeLoadingState(false)

        this.$refs.mapschild.myMap.setZoom(4, {
          duration: 1000,
        })
      },
    },
    computed: {
      ...mapState(['coords', 'adds', 'zoomMap']),
    },
  }
</script>

<style scoped lang="scss">
    @import "../assets/css/vars";

    #map-box {
        width: 60%;
        height: $height-body;
        background-color: #DFE4E6;
        position: relative;
    }

    .ymap-container {
        width: 100%;
        height: 100%;
    }
</style>
