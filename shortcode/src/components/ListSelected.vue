<template>
    <div class="list-adds list--sel">
        <div class="list-adds__box list-adds__box--sel">
            <div class="list-adds__title">Выбранные стороны</div>
            <div class="list-adds__wrap list-adds__wrap--sel">
                <div class="list-adds__header">
                    <div class="list-adds__col list-adds__col--1">
                    </div>
                    <div class="list-adds__col list-adds__col--2">
                        <HeadList id="1" title="Город"></HeadList>
                    </div>
                    <div class="list-adds__col list-adds__col--3">
                        <HeadList id="2" title="Адрес, направление"></HeadList>
                    </div>
                    <div class="list-adds__col list-adds__col--4">
                        <HeadList id="3" title="Сторона"></HeadList>
                    </div>
                </div>
                <div class="list-adds__body list-adds__body--sel">
                    <transition-group name="list"
                                      enter-active-class="animated fadeIn fast"
                                      leave-active-class="animated fadeOut fast">
                        <div class="list-adds__item" v-for="item in selected" :key="item.id"
                             @click="changeCheck(item.id)">
                            <div class="list-adds__column list-adds__col--1">
                                <div class="list-adds--delete"
                                     @click.self.stop="handleRemove(item.id)"></div>
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
                    </transition-group>
                </div>
                <div class="list-adds__add-more">
                    <button class="btn btn__add-more" @click="handelMore">Добавить
                        ещё
                    </button>
                </div>
            </div>
            <ContactForm></ContactForm>
        </div>
    </div>
</template>

<script>
  import { mapGetters, mapMutations, mapState } from 'vuex'
  import HeadList from './HeadList'
  import ContactForm from './ContactForm'

  export default {
    name: 'ListSelected',
    components: {
      HeadList,
      ContactForm,
    },
    computed: {
      ...mapGetters(['selected']),
      ...mapState(['countActiveSides']),
    },
    methods: {
      ...mapMutations(['changeListIndex', 'changeCheck', 'removeCheck', 'calcCountSides']),
      handleRemove (index) {
        this.removeCheck(index)

        this.calcCountSides()
        if (this.countActiveSides === 0) {
          this.changeListIndex(-1)
        }
      },
      handelMore () {
        this.calcCountSides()
        this.changeListIndex(-1)
      },
    },
  }
</script>

<style src="./ListAddress/ListAddress.scss" lang="scss" scoped></style>

<style lang="scss" scoped>
    .list-adds__add-more {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-bottom: 10px;
    }

    .list-adds.list--sel {
        height: 100%;
    }

    .list-adds__box.list-adds__box--sel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .list-adds__wrap.list-adds__wrap--sel {
        min-height: auto;
        max-height: calc(100% - 282px);
        width: 100%;
    }

    .list-adds__body.list-adds__body--sel {
        flex: none;
        flex-shrink: 1;
    }

    .list-adds--delete {
        width: 13px;
        height: 13px;
        background: url("../assets/svg/redminus.svg") center no-repeat;
        margin: 0 auto;
        cursor: pointer;
        transition-duration: .5s;
        transition-property: transform;
        transition-timing-function: ease-in-out;
    }

    .list--sel .list-adds__col--1:hover {
        .list-adds--delete {
            transform: rotate(180deg);
        }
    }
</style>
