<style src="./ListAddress.scss" lang="scss" scoped></style>
<script src="./ListAddress.js"></script>

<template>
    <div class="list-adds">
        <div v-if="loading" class="preloader">
            <div class="page-loader-circle"></div>
        </div>
        <div v-else class="list-adds__box">
            <div class="list-adds__title">Адресная программа</div>
            <div class="list-adds__wrap">
                <div class="list-adds__header">
                    <div class="list-adds__col list-adds__col--1"></div>
                    <div class="list-adds__col list-adds__col--2">Город</div>
                    <div class="list-adds__col list-adds__col--3">Адрес, направление</div>
                    <div class="list-adds__col list-adds__col--4">Сторона</div>
                </div>
                <div class="list-adds__body">
                    <div class="list-adds__item" v-for="item in adds" :key="item.id" @click="changeCheck(item.id)">
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
                                {{getSides(item.sides)}}
                            </div>
                        </div>
                    </div>
                </div>
                <FooterAddress></FooterAddress>
            </div>
        </div>

    </div>
</template>
