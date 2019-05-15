<template>
    <div class="list-sel">
        <div class="list-adds">
            <div class="list-adds__box">
                <div class="list-adds__title">Выбранные стороны</div>
                <div class="list-adds__wrap">
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
            </div>
        </div>

    </div>
</template>

<script>
  import { mapGetters, mapMutations } from 'vuex'
  import HeadList from './HeadList'

  export default {
    name: 'ListSelected',
    components: {
      HeadList,
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
</style>
