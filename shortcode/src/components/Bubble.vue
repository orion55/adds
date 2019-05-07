<template>
    <div class="bubble">
        <div class="bubble__cros"></div>
        <div class="bubble__city">{{info.city}}</div>
        <div class="bubble__street">{{info.street}}</div>
        <div class="bubble__box">
            <span class="bubble__code">{{info.code}}</span>
            <span class="bubble__size">{{info.size}}</span>
        </div>
        <div class="bubble__picture">
            <img src="http://adds.infoblog72.ru/wp-content/uploads/2019/05/grzbb8006a-doroga-groznyj-argun-vezd-v-g.-groznyj-so-storony-g.-arguna-arka-100-m.-300x200.jpg"
                 alt="" class="bubble__img">
        </div>
        <div class="bubble__sides">
            <div class="btn btn--sides btn--active">A</div>
            <div class="btn btn--sides"><span class="btn--selected"></span>B</div>
            <div class="btn btn--choice"><span class="bubble__plus"></span>Добавить</div>
        </div>
    </div>
</template>

<script>
  import { mapState } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'baloon',
    computed: {
      ...mapState(['adds', 'bubbleID', 'bubbleVisibility']),
      info: function () {
        return (this.bubbleID > 0) ? _.find(this.adds, {'id': this.bubbleID}) : {}
      },
    },
  }
</script>

<style lang="scss" scoped>
    @import "../assets/css/btn";

    .bubble {
        position: absolute;
        left: 19%;
        bottom: 51%;
        width: 330px;
        height: 340px;
        background: #FFFFFF;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(173, 178, 188, 0.5);
        padding: 10px 15px;
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

    .bubble__picture {
        height: 200px;
        width: 300px;
        margin: 0 0 10px 0;
    }

    .bubble__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .bubble__city {
        font-weight: 600;
        font-size: 14px;
        color: black;
        padding-bottom: 5px;
    }

    .bubble__street {
        font-weight: 600;
        font-size: 12px;
        text-overflow: ellipsis;
        overflow: hidden;
        color: black;
        white-space: nowrap;
        padding-bottom: 5px;
    }

    .bubble__box {
        font-weight: 600;
        font-size: 9px;
        color: #868F98;
        padding-bottom: 10px;
    }

    .bubble__code {
        padding-right: 10px;
    }

    .bubble__sides {
        display: flex;
        align-items: center;
        justify-items: flex-start;
    }

    .bubble__cros {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 20px;
        height: 20px;
        background: url("../assets/svg/times-circle-regular.svg") center no-repeat;
        cursor: pointer;

        &:hover {
            background: url("../assets/svg/times-circle-solid.svg") center no-repeat;
        }
    }

    .bubble__plus {
        width: 20px;
        height: 20px;
        background: url("../assets/svg/plus.svg") center no-repeat;
        display: inline-block;
        margin-right: 5px;
    }

</style>
