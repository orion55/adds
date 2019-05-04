import { mapState, mapMutations } from 'vuex'
import FooterAddress from '../FooterAddress'

export default {
  name: 'ListAddress',
  components: {
    FooterAddress,
  },
  mounted () {
    this.$store.dispatch('loadData')
  },
  computed: mapState(['adds', 'loading']),
  methods: {
    ...mapMutations(['changeCheck']),
    getSides (sides) {
      let str = ''
      sides.forEach((item) => {
        if (item.status) {
          str += item.name
        }
      })
      return str
    }
  }
}
