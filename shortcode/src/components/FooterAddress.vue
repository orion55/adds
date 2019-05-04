<template>
    <div class="footer-adds">
        <div class="footer-adds--sides">Выбрано сторон<br><span class="footer-adds--count">13</span></div>
        <button class="btn">Далее</button>
    </div>
</template>

<script>
  export default {
    name: 'FooterAddress'
  }
</script>

<style lang="scss">
    @import "../assets/css/btn.css";

    .footer-adds {
        height: 60px;
        background-color: #245EF6;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-right: 22px;
        padding-left: 22px;
    }

    .footer-adds--sides {
        font-weight: 600;
        font-size: 11px;
        line-height: 13px;
    }

    .footer-adds--count {
        font-weight: 600;
        font-size: 20px;
        line-height: 24px;
    }
</style>
