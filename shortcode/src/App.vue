<template>
    <div id="app">
        <ListAddress></ListAddress>
    </div>
</template>

<script>
  import ListAddress from './components/ListAddress/ListAddress.vue'

  export default {
    name: 'app',
    components: {
      ListAddress,
    },
  }
</script>

<style lang="scss">
    @import "./assets/fonts/montserrat.css";

    #app {
        width: 800px;
        margin: 15px auto;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.6);
        height: 850px;
        font-family: 'Montserrat', Arial, Helvetica, sans-serif;
    }
</style>
