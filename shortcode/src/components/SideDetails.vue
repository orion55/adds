<template>
    <transition name="custom-classes-transition"
                enter-active-class="animated fadeIn fast"
                leave-active-class="animated fadeOut">
        <div class="details" v-if="detailsVisibility">
            <div class="details__holder">
                <div class="details__cros" @click="changeDetailsShow()"></div>
                <div class="details__city">{{info.city}}</div>
                <div class="details__street">{{info.street}}</div>
                <div class="details__box">
                    <span class="details__code">{{info.code}}</span>
                    <span class="details__size">{{info.size}}</span>
                    <span class="details__desc">Сторона:</span>
                    <span class="details__side">{{curSide.name}}</span>
                    <span class="details__desc">Освещение:</span>
                    <span class="details__light">{{curSide.lighting? 'Есть': 'Нет'}}</span>
                </div>
                <div class="details__picture">
                    <img :src="curSide.img_full" alt="" class="details__img">
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'SideDetails',
    methods: {
      ...mapMutations(['changeDetailsShow']),
    },
    computed: {
      ...mapState(['adds', 'bubbleID', 'bubbleVisibility', 'bubbleActiveSide', 'detailsVisibility']),
      info: function () {
        return (this.bubbleID > 0) ? _.find(this.adds, {'id': this.bubbleID}) : {}
      },
      curSide: function () {
        return (!_.isEmpty(this.info)) ? this.info.sides[this.bubbleActiveSide] : {}
      },
    },
  }
</script>

<style lang="scss" scoped>
    @import "../assets/css/transition.css";

    .details {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(100, 111, 121, 0.7);
        z-index: 10;
    }

    .details__holder {
        width: 940px;
        height: 620px;
        background-color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 20;
        padding: 20px;
    }

    .details__picture {
        height: 500px;
        width: 900px;
        /*margin: 0 0 10px 0;*/
    }

    .details__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .details__city {
        font-weight: 600;
        font-size: 16px;
        color: black;
        padding-bottom: 5px;
    }

    .details__street {
        font-weight: 600;
        font-size: 13px;
        text-overflow: ellipsis;
        overflow: hidden;
        color: black;
        white-space: nowrap;
        padding-bottom: 5px;
    }

    .details__box {
        font-weight: 600;
        font-size: 11px;
        color: #868F98;
        padding-bottom: 10px;
    }

    .details__code, .details__size, .details__side {
        padding-right: 10px;
    }

    .details__desc {
        padding-right: 5px;
    }

    .details__side, .details__light {
        color: black;
    }

    .details__cros {
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

    @media only screen and (min-device-width: 768px) and (max-width: 1199px) {
        .details__holder {
            width: 95%;
            top: 25%;
            transform: translate(-50%, -25%);
        }
        .details__picture {
            width: 100%;
        }
    }

    @media only screen and (max-width: 767px) {
        .details__holder {
            width: 95%;
            height: 400px;
            top: 25%;
            transform: translate(-50%, -25%);
        }
        .details__picture {
            height: 280px;
            width: 100%;
        }
    }
</style>
