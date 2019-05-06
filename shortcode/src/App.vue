<template>
    <div id="app-container">
        <div v-if="loading" class="preloader">
            <div class="page-loader-circle"></div>
            <div class="page-loader-text">Пожалуйста, подождите...</div>
        </div>
        <MapBox></MapBox>
        <ListBox></ListBox>
    </div>
</template>

<script>
  import MapBox from './components/MapBox'
  import ListBox from './components/ListBox'
  import store from './store'
  import { mapState } from 'vuex'

  export default {
    name: 'app',
    store,
    components: {
      MapBox,
      ListBox,
    },
    mounted () {
      this.$store.dispatch('loadData')
    },
    computed: {
      ...mapState(['loading']),
    },
  }
</script>

<style lang="scss">
    @import "./assets/fonts/montserrat.css";
    @import "./assets/css/preloader.css";

    #app-container {
        width: 100%;
        height: 800px;
        font-family: 'Montserrat', Arial, Helvetica, sans-serif;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
</style>
