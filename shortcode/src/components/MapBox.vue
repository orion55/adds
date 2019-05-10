<template>
    <div id="map-box">
        <yandex-map :zoom="14" :options="options" :coords="coords"
                    @map-was-initialized="initHandler"
                    :scrollZoom="scrollZoom" :placemarks="placemarks" ref="yamaps"
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
      ...mapMutations(['changeLoadingState', 'changeCheck', 'changeBubbleShow']),
      initHandler: function () {
        let arr = []
        store.state.adds.forEach((item) => {
            const coord = item.coordinates
            arr.push({
              coords: [coord.lat, coord.lng],
              properties: {},
              clusterName: item.id + '',
              options: {
                iconLayout: 'default#image',
                iconImageHref: wp_data.plugin_dir_url + 'img/' + item.iconImage,
                iconImageSize: [40, 40],
                iconImageOffset: [0, 0],
              },
              callbacks: {
                click: (event) => {
                  this.changeCheck(+event.get('target').clusterName)
                },
              },
            })
          },
        )
        this.placemarks = arr

        this.changeLoadingState(false)

        this.$refs.yamaps.myMap.events.add('actiontick', (e) => {
          if (this.bubbleVisibility) {
            this.changeBubbleShow(false)
          }
        })

      },
    },
    computed: {
      ...mapState(['coords', 'adds', 'bubbleID', 'bubbleVisibility', 'bubbleActiveSide']),
    },
    mounted () {
      this.$store.subscribe((mutation, state) => {
        if (mutation.type === 'changeSideStatus') {
          const place = _.find(this.placemarks, {'clusterName': this.bubbleID + ''})
          const placeIndex = _.findIndex(this.placemarks, {'clusterName': this.bubbleID + ''})
          const item = _.find(this.adds, {'id': this.bubbleID})

          var deep = _.cloneDeep(place)
          deep.options.iconImageHref = wp_data.plugin_dir_url + 'img/' + item.iconImage
          this.placemarks.splice(placeIndex, 1, deep)
        }
      })
    },
    /*watch: {
      bubbleActiveSide: function (newID, oldID) {
        // console.log(newID, oldID)
        let place = _.find(this.placemarks, {'clusterName': this.bubbleID + ''})
        let item = _.find(this.adds, {'id': this.bubbleID})
        place.options.iconImageHref = wp_data.plugin_dir_url + 'img/' + item.iconImage
        console.log(place)
      },
    },*/
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
