<template>
    <span :class="['head', getEmptyClass, getSelectedClass]" @click="changeHeaderState(id)">
        {{title}}<span :class="['head--chevron',getActiveClass,getChevronUpClass]"></span>
    </span>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'

  export default {
    name: 'HeadList',
    props: ['id', 'title'],
    computed: {
      ...mapState(['sortID', 'sortDirect']),
      getEmptyClass () {
        return this.title === '' ? 'head--empty' : ''
      },
      getSelectedClass () {
        return +this.sortID === +this.id && +this.sortDirect !== 0 ? 'head--selected' : ''
      },
      getActiveClass () {
        return +this.sortDirect > 0 && +this.sortID === +this.id ? 'head--active' : ''
      },
      getChevronUpClass () {
        return +this.sortDirect === 2 && +this.sortID === +this.id ? 'head--chevron__up' : ''
      },
    },
    methods: {
      ...mapMutations(['changeHeaderState']),
    },
  }
</script>

<style lang="scss" scoped>
    @import "../assets/css/vars";

    .head--chevron {
        border-style: solid;
        border-width: .15em .15em 0 0;
        content: "";
        display: inline-block;
        height: 5px;
        position: relative;
        top: 5px;
        vertical-align: top;
        width: 5px;
        left: 4px;
        transform: rotate(135deg);
        opacity: 0;
        transition: opacity .5s ease-in-out;
    }

    .head--chevron__up {
        transform: rotate(315deg);
        top: 7px;
    }

    .head {
        cursor: pointer;
        display: inline-block;
        padding-left: 9px;

        &:hover {
            .head--chevron {
                opacity: 1;
            }
        }
    }

    .head--empty {
        padding-left: 9px;
    }

    .head--selected {
        color: $color-main
    }

    .head--active {
        opacity: 1;
    }
</style>
