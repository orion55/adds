<style src="./ListAddress.scss" lang="scss" scoped></style>

<template>
    <div class="list-adds">
        <div class="list-adds__box">
            <div class="list-adds__title">Адресная программа</div>
            <div class="list-adds__wrap">
                <div class="list-adds__header">
                    <div class="list-adds__col list-adds__col--1">
                        <HeadList id="1" title=""></HeadList>
                    </div>
                    <div class="list-adds__col list-adds__col--2">
                        <HeadList id="2" title="Город"></HeadList>
                    </div>
                    <div class="list-adds__col list-adds__col--3">
                        <HeadList id="3" title="Адрес, направление"></HeadList>
                    </div>
                    <div class="list-adds__col list-adds__col--4">
                        <HeadList id="4" title="Сторона"></HeadList>
                    </div>
                </div>
                <div class="list-adds__body">
                    <div class="list-adds__item" v-for="item in filters" :key="item.id"
                         @click="changeCheck(item.id)">
                        <div class="list-adds__column list-adds__col--1">
                            <div :class="[item.check ? 'list-adds--circle-solid': 'list-adds--circle' , 'list-adds--center']">
                            </div>
                        </div>
                        <div :class="[item.check ? 'list-addr--check' : '', 'list-adds__column', 'list-adds__col--2', 'list-adds__col--text', 'list-adds__col--space']">
                            {{item.city}}
                        </div>
                        <div class="list-adds__column list-adds__col--3">
                            <div :class="[item.check ? 'list-addr--check' : '','list-adds--headline', 'list-adds__col--text']">
                                {{item.street}}
                            </div>
                            <div :class="[item.check ? 'list-addr--check' : '','list-adds--desc']">
                                {{item.code}} {{item.size}}
                            </div>
                        </div>
                        <div class="list-adds__column list-adds__col--4">
                            <div :class="[item.check ? 'list-addr--check' : '','list-adds--center']">
                                {{item.blocks}}
                            </div>
                        </div>
                    </div>
                </div>
                <transition name="custom-transit"
                            enter-active-class="animated fadeIn fast"
                            leave-active-class="animated fadeOut">
                    <FooterAddress v-if="countActiveSides > 0"></FooterAddress>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapGetters, mapMutations, mapState } from 'vuex'
  import FooterAddress from '../FooterAddress'
  import HeadList from '../HeadList'

  export default {
    name: 'ListAddress',
    components: {
      FooterAddress,
      HeadList,
    },
    computed: {
      ...mapGetters(['filters']),
      ...mapState(['countActiveSides']),
    },
    methods: {
      ...mapMutations(['changeCheck']),
      /*getSides (sides) {
        let str = ''
        sides.forEach((item) => {
          if (item.status) {
            str += item.name
          }
        })
        return str
      },*/
    },
  }
</script>
