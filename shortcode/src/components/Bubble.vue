<template>
    <div class="bubble">

    </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'baloon',
    computed: {
      ...mapState(['bubbleID', 'bubbleVisibility'])
    }
  }
</script>

<style lang="scss" scoped>
    .bubble {
        position: absolute;
        left: 19%;
        bottom: 51%;
        width: 340px;
        height: 250px;
        padding: 0;
        background: #FFFFFF;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(173, 178, 188, 0.5);
    }

    .bubble:after {
        content: '';
        position: absolute;
        border-style: solid;
        border-width: 15px 15px 0;
        border-color: #FFFFFF transparent;
        display: block;
        width: 0;
        z-index: 1;
        bottom: -15px;
        left: 160px;
    }

</style>
