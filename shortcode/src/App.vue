<template>
    <div id="app-container">
        <Preloader></Preloader>
        <MapBox></MapBox>
        <ListBox></ListBox>
        <SideDetails></SideDetails>
    </div>
</template>

<script>
  import MapBox from './components/MapBox'
  import ListBox from './components/ListBox'
  import Preloader from './components/Preloader'
  import SideDetails from './components/SideDetails'
  import store from './store'
  import { mapState } from 'vuex'

  export default {
    name: 'app',
    store,
    components: {MapBox, ListBox, Preloader, SideDetails},
    mounted () {
      this.$store.dispatch('loadData')
    },
    computed: {
      ...mapState(['loading']),
    },
  }
</script>

<style lang="scss">
    @import "assets/css/vars";
    @import "./assets/fonts/montserrat.css";

    #app-container {
        width: 100%;
        height: $height-body;
        font-family: 'Montserrat', Arial, Helvetica, sans-serif;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 0;
    }
</style>
