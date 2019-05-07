<template>
    <div v-if="loading" class="preloader">
        <div class="page-loader-circle"></div>
        <div class="page-loader-text">Пожалуйста, подождите...</div>
    </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {
    name: 'preloader',
    computed: {
      ...mapState(['loading'])
    }
  }
</script>

<style scoped lang="scss">
    @import "../assets/css/vars";

    .preloader {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 999999;
        display: block;
        background: #fff;
        width: 100%;
        height: $height-body;
    }

    .page-loader-circle {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 36px;
        height: 36px;
        margin: -18px 0 0 -18px;
        border-radius: 50%;
        border: 2px solid;
        border-top-color: $color-main;
        border-bottom-color: white;
        border-left-color: $color-main;
        border-right-color: $color-main;
        animation: page-loader-circle 0.8s linear infinite;
    }

    .page-loader-text {
        position: absolute;
        top: 53%;
        left: 50%;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        color: $color-main;
        transform: translateX(-50%);
    }

    @keyframes page-loader-circle {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
