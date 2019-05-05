<template>
    <yandex-map zoom="10" id="map-box" :options="options"
                :coords="[54.62896654088406, 39.731893822753904]"
                @map-was-initialized="initHandler"
    >
    </yandex-map>
</template>

<script>
  import { yandexMap, ymapMarker } from 'vue-yandex-maps'

  export default {
    name: 'MapBox',
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
      }
    },
    methods: {
      initHandler: () => {
        console.log('init')
      },
    },
  }
</script>

<style scoped>
    #map-box {
        width: 60%;
        height: 800px;
        background-color: #DFE4E6;
    }

</style>
