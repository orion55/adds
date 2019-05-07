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
    }
</style>
