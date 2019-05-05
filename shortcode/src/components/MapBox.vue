<template>
    <yandex-map zoom="14" id="map-box" :options="options"
                :coords="coords"
                @map-was-initialized="initHandler" :placemarks="placemarks" :scrollZoom="scrollZoom"
    >
    </yandex-map>

</template>

<script>
  import { yandexMap, ymapMarker } from 'vue-yandex-maps'
  import store from '../store'
  import { mapState } from 'vuex'

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
      }
    },
    methods: {
      initHandler: () => {
        console.log('init')
      },
    },
    computed: mapState(['coords', 'placemarks']),
  }
</script>

<style scoped>
    #map-box {
        width: 60%;
        height: 800px;
        background-color: #DFE4E6;
    }

</style>
