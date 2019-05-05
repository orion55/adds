<template>
    <div id="app-container">
        <MapBox></MapBox>
        <ListBox></ListBox>
    </div>
</template>

<script>
  import MapBox from './components/MapBox'
  import ListBox from './components/ListBox'
  import store from './store'

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
  }
</script>

<style lang="scss">
    @import "./assets/fonts/montserrat.css";

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
