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
                <div class="list-adds__body">
                    <div class="list-adds__item" v-for="item in selected" :key="item.id">
                        <div class="list-adds__column list-adds__col--1">

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
                <div class="list-adds__add-more">
                    <button class="btn btn__add-more" @click="changeListIndex(-1)">Добавить
                        ещё
                    </button>
                </div>
            </div>
            <ContactForm></ContactForm>
        </div>
    </div>
</template>

<script>
  import { mapGetters, mapMutations } from 'vuex'
  import HeadList from './HeadList'
  import ContactForm from './ContactForm'

  export default {
    name: 'ListSelected',
    components: {
      HeadList,
      ContactForm
    },
    computed: {
      ...mapGetters(['selected']),
    },
    methods: {
      ...mapMutations(['changeListIndex']),
    },
  }
</script>

<style src="./ListAddress/ListAddress.scss" lang="scss" scoped></style>

<style lang="scss" scoped>
    .list-adds__add-more {
        display: flex;
        align-items: center;
        justify-content: flex-end;
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
        height: auto;
    }
</style>
