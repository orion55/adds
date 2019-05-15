<template>
    <div id="list-box">
        <component :is="ListAddress"></component>
    </div>
</template>

<script>
  import { mapState } from 'vuex'
  import ListAddress from './ListAddress/ListAddress.vue'
  import ListSelected from './ListSelected.vue'

  const list = ['ListAddress', 'ListSelected']

  export default {
    name: 'ListBox',
    components: {
      ListAddress,
      ListSelected
    },
    computed: {
      ...mapState(['listIndex']),
      curList: function () {
        return list[this.listIndex]
      }
    }
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
