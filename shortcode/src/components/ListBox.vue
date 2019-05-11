<template>
    <div id="list-box">
        <ListAddress></ListAddress>
    </div>
</template>

<script>
  import ListAddress from './ListAddress/ListAddress.vue'

  export default {
    name: 'ListBox',
    components: {
      ListAddress,
    },
  }
</script>

<style scoped lang="scss">
    @import "../assets/css/vars";

    #list-box {
        width: 40%;
        height: $height-body;
        z-index: 1;
        position: relative;
    }

    @media only screen and (min-device-width: 768px) and (max-width: 1199px) {

    }

    @media only screen and (max-width: 767px) {
        #list-box {
            height: 400px;
            width: 100%;
        }
    }
</style>
