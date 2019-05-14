<template>
    <div :class="['search', { 'search--small': isSmall }]">
        <span class="search__icon" @click="changeSmallActive()"></span>
        <input type="text" class="search__input" @input="updateMessage" :value="searchLine"/>
        <div class="search__close" @click="changeSmall()"></div>
    </div>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'
  import _ from 'lodash'

  export default {
    name: 'SearchBox',
    data: function () {
      return {
        isSmall: true,
      }
    },
    computed: {
      ...mapState(['searchLine']),
    },
    methods: {
      ...mapMutations(['updateSearchLine']),
      changeSmall () {
        this.isSmall = !this.isSmall
        this.updateSearchLine('')
      },
      changeSmallActive () {
        if (this.isSmall) {
          this.isSmall = !this.isSmall
        }
      },
      updateMessage: _.debounce(function (e) {
        this.updateSearchLine(e.target.value.trim())
      }, 750),
    },
  }
</script>

<style lang="scss" scoped>
    .search {
        position: absolute;
        top: 29px;
        right: 15px;
        width: 170px;
        height: 25px;
        border: 1px solid #DFE4E6;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .4s cubic-bezier(0.000, 0.105, 0.035, 1.570);
    }

    .search__input {
        height: 20px;
    }

    .search__icon {
        display: block;
        width: 25px;
        height: 25px;
        margin-left: 4px;
        background: url("../assets/svg/search.svg") center no-repeat;
    }

    @keyframes hvr-icon-pulse-grow {
        to {
            transform: scale(1.2);
        }
    }

    .search__close {
        display: block;
        width: 25px;
        height: 25px;
        margin-right: 4px;
        background: url("../assets/svg/close.svg") center no-repeat;
        cursor: pointer;
        transition-duration: .5s;
        transition-property: transform;
        transition-timing-function: ease-in-out;

        &:hover {
            transform: rotate(180deg);
        }
    }

    .search__input {
        width: 100%;
        padding: 2px;
        opacity: 1;
        background: transparent;
        box-sizing: border-box;
        border: none;
        outline: none;
        font-weight: 500;
        font-size: 11px;
        line-height: 13px;
        color: black;
        transition: all .3s cubic-bezier(0.000, 0.105, 0.035, 1.570);
        transition-delay: 0.3s;
        vertical-align: middle;
    }

    .search--small {
        .search__input, .search__close {
            display: none;
        }

        .search__icon {
            margin-left: 0;
            cursor: pointer;
            transform: translateZ(0);
            transition-timing-function: ease-out;

            &:hover {
                animation-name: hvr-icon-pulse-grow;
                animation-duration: 0.3s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
                animation-direction: alternate;
            }
        }
    }

    .search.search--small {
        width: 25px;
    }

</style>
