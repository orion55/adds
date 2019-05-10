<template>
    <transition name="custom-classes-transition"
                enter-active-class="animated fadeIn fast"
                leave-active-class="animated fadeOut">
        <div class="bubble" v-if="bubbleVisibility">
            <div class="bubble__cros" @click="changeBubbleShow(false)"></div>
            <div class="bubble__city">{{info.city}}</div>
            <div class="bubble__street">{{info.street}}</div>
            <div class="bubble__box">
                <span class="bubble__code">{{info.code}}</span>
                <span class="bubble__size">{{info.size}}</span>
            </div>
            <div class="bubble__picture">
                <transition name="fadeimg">
                    <img :src="imgSrc" alt="" class="bubble__img" :key="imgSrc">
                </transition>
            </div>
            <div class="bubble__sides">
                <div :class="['btn', 'btn--sides', index === activeSide ? 'btn--active' : '',]"
                     v-for="(side, index) of info.sides" @click="changeSide(index)"
                     :key="index"><span
                        v-if="side.status"
                        class="btn--selected"></span>{{side.name}}
                </div>
                <div class="btn btn--choice"
                     v-if="!_.isEmpty(info) && !info.sides[activeSide].status"
                     @click="changeSideStatus(activeSide)"><span
                        class="bubble__plus"></span>Добавить
                </div>
                <div class="btn btn--choice btn--alert" v-else @click="changeSideStatus(activeSide)"><span
                        class="bubble__minus"></span><span
                        class="bubble__text-alert">Убрать</span></div>
            </div>
        </div>
    </transition>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'baloon',
    data: function () {
      return {
        activeSide: 0,
      }
    },
    methods: {
      ...mapMutations(['changeBubbleShow', 'changeSideStatus']),
      changeSide: function (index) {
        if (index !== this.activeSide) {
          this.activeSide = index
        }
      },
    },
    computed: {
      ...mapState(['adds', 'bubbleID', 'bubbleVisibility']),
      info: function () {
        return (this.bubbleID > 0) ? _.find(this.adds, {'id': this.bubbleID}) : {}
      },
      _ () {
        return _
      },
      imgSrc: function () {
        return !_.isEmpty(this.info) ? this.info.sides[this.activeSide].img_small : ''
      },
    },
    watch: {
      bubbleID: function () {
        this.activeSide = 0
      },
    },
  }
</script>

<style lang="scss" scoped>
    @import "../assets/css/btn";
    @import "../assets/css/transition.css";

    .bubble {
        position: absolute;
        top: 48px;
        left: calc(50% + 10px);
        transform: translateX(-50%);
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

    .bubble__minus {
        width: 20px;
        height: 20px;
        background: url("../assets/svg/minus.svg") center no-repeat;
        display: inline-block;
        margin-right: 5px;
    }

    .bubble__text-alert {
        color: #DB545C;
    }
</style>
