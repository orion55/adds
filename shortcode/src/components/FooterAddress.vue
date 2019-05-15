<template>
    <div class="footer-adds">
        <div class="footer-adds--sides">Выбрано сторон<br><span class="footer-adds--count">{{countActiveSides}}</span>
        </div>
        <button class="btn" @click="changeListIndex(1)">Далее</button>
    </div>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'

  export default {
    name: 'FooterAddress',
    computed: {
      ...mapState(['countActiveSides']),
    },
    methods: {
      ...mapMutations(['changeListIndex']),
    },
  }
</script>

<style lang="scss">
    @import "../assets/css/btn";
    @import "../assets/css/vars";

    .footer-adds {
        height: 60px;
        background-color: $color-main;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-right: 22px;
        padding-left: 22px;
    }

    .footer-adds--sides {
        font-weight: 600;
        font-size: 11px;
        line-height: 13px;
    }

    .footer-adds--count {
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
    }
</style>
