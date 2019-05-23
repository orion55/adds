<template>
    <div id="list-box">
        <transition name="custom-transit"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOutUp">
            <component :is="curList"></component>
        </transition>
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
      ListSelected,
    },
    computed: {
      ...mapState(['listIndex']),
      curList: function () {
        return list[this.listIndex]
      },
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
            width: 100%;
            height: auto;

            & > .list-adds {
                height: 400px;
            }

            & > .list-adds.list--sel {
                height: auto;
            }
        }
    }
</style>
