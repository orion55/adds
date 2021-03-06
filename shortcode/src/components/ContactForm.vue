<template>
    <div class="contact">
        <div class="contact__group" ref="contactName">
            <input type="text" class="contact__input" required :value="contactName"
                   @input="setContact('Name', $event.target.value)">
            <span class="contact__highlight"></span>
            <span class="contact__bar"></span>
            <label class="contact__label">Имя</label>
            <div class="contact__error" v-if="submitted && !$v.contactName.required">Поле,
                обязательное
                для заполнения
            </div>
            <div class="contact__error" v-if="submitted && !$v.contactName.minLength">Имя должно
                содержать как минимум {{$v.contactName.$params.minLength.min}} буквы.
            </div>
        </div>
        <div class="contact__group">
            <input type="text" class="contact__input" required v-mask="'+7 (999) 999 99 99'"
                   :value="contactPhone"
                   @input="setContact('Phone', $event.target.value)">
            <span class="contact__highlight"></span>
            <span class="contact__bar"></span>
            <label class="contact__label">Телефон</label>
            <div class="contact__error" v-if="submitted && !$v.contactPhone.required">Поле,
                обязательное
                для заполнения
            </div>
        </div>

        <div class="contact__group contact__group--last">
            <input type="text" class="contact__input" required :value="contactEmail"
                   @input="setContact('Email', $event.target.value)">
            <span class="contact__highlight"></span>
            <span class="contact__bar"></span>
            <label class="contact__label">Email</label>
            <div class="contact__error" v-if="submitted && !$v.contactEmail.required">Поле,
                обязательное
                для заполнения
            </div>
            <div class="contact__error" v-if="submitted && !$v.contactEmail.email">Введите
                корректный email-адрес
            </div>
        </div>
        <button class="btn" @click="handleSubmit">Отправить запрос</button>
    </div>
</template>

<script>
  import Vue from 'vue'
  import { mapActions, mapMutations, mapState } from 'vuex'
  import Vuelidate from 'vuelidate'
  import { email, minLength, required } from 'vuelidate/lib/validators'
  import _ from 'lodash'
  import VueSweetalert2 from 'vue-sweetalert2'

  Vue.use(VueSweetalert2)

  const VueInputMask = require('vue-inputmask').default
  Vue.use(VueInputMask)

  Vue.use(Vuelidate)

  export default {
    name: 'ContactForm',
    data () {
      return {
        submitted: false,
      }
    },
    computed: {
      ...mapState(['contactName', 'contactPhone', 'contactEmail']),
    },
    methods: {
      ...mapMutations(['updateContact', 'changeListIndex', 'calcCountSides']),
      ...mapActions(['sendAction']),
      setContact: _.debounce(function (varName, varValue) {
        this.updateContact({
          varName,
          varValue,
        })
      }, 750),
      handleSubmit () {
        this.submitted = true

        this.$v.$touch()
        if (this.$v.$invalid) {
          return
        }

        this.sendAction()
          .then((answer) => {
            // console.log(answer)
            if (answer.success) {
              Vue.swal({
                type: 'success',
                title: 'Спасибо за заявку!',
                text: answer.data,
                confirmButtonColor: '#245EF6',
              })
              this.calcCountSides()
              this.changeListIndex(-1)
            } else {
              let message = ''
              answer.data.forEach((element) => {
                message += element
              })
              Vue.swal({
                type: 'error',
                title: 'Ошибка',
                text: message,
                confirmButtonColor: '#245EF6',
              })
            }

          })
          .catch((error) => {
            Vue.swal({
              type: 'error',
              title: 'Ошибка',
              text: error.statusText,
              confirmButtonColor: '#245EF6',
            })
          })
      },
    },
    validations: {
      contactName: {
        required,
        minLength: minLength(3),
      },
      contactPhone: {
        required,
      },
      contactEmail: {
        required,
        email,
      },
    },
  }
</script>

<style lang="scss" scoped>
    @import "../assets/css/vars.scss";

    .contact {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: $color-main;
        color: white;
        flex-direction: column;
        padding: 15px;
        width: 100%;
        margin-top: auto;
        position: relative;
    }

    .contact__group {
        position: relative;
        margin-bottom: 5px;
    }

    .contact__group--last {
        margin-bottom: 15px;
    }

    input.contact__input {
        font-size: 18px;
        padding: 5px 5px 5px 0;
        display: block;
        width: 300px;
        border: none;
        border-bottom: 1px solid #5E8BFF;
        background-color: $color-main;
        color: white;
        font-weight: 500;
        border-radius: 0;

        &:focus {
            outline: none;
        }
    }


    label.contact__label {
        color: white;
        font-size: 12px;
        font-weight: normal;
        position: absolute;
        pointer-events: none;
        left: 1px;
        top: 11px;
        transition: 0.2s ease all;
    }

    input.contact__input:focus ~ label.contact__label, input.contact__input:valid ~ label.contact__label {
        top: -6px;
        font-size: 10px;
        color: white;
        left: 0;
    }

    .contact__bar {
        position: relative;
        display: block;
        width: 300px;
    }

    .contact__bar:before, .contact__bar:after {
        content: '';
        height: 1px;
        width: 0;
        bottom: 1px;
        position: absolute;
        background: white;
        transition: 0.2s ease all;
    }

    .contact__bar:before {
        left: 50%;
    }

    .contact__bar:after {
        right: 50%;
    }

    input.contact__input:focus ~ .contact__bar:before, input.contact__input:focus ~ .contact__bar:after {
        width: 50%;
    }

    .contact__highlight {
        position: absolute;
        height: 60%;
        width: 100px;
        top: 25%;
        left: 0;
        pointer-events: none;
        opacity: 0.5;
    }

    input.contact__input:focus ~ .contact__highlight {
        animation: inputHighlighter 0.3s ease;
    }

    @keyframes inputHighlighter {
        from {
            background: $color-main;
        }
        to {
            width: 0;
            background: transparent;
        }
    }

    .contact__error {
        font-size: 10px;
        color: #FFD479;
        text-align: center;
    }

    @media only screen and (min-device-width: 768px) and (max-width: 1199px) {
        input.contact__input {
            width: 90%;
        }

        .contact__group {
            margin-left: auto;
            margin-right: auto;
        }
    }

    @media only screen and (max-width: 767px) {

    }
</style>
