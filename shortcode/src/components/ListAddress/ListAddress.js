import { mapGetters, mapMutations, mapState} from 'vuex'
import FooterAddress from '../FooterAddress'

export default {
  name: 'ListAddress',
  components: {
    FooterAddress,
  },
  computed: {
    ...mapGetters(['filters']),
    ...mapState(['countActiveSides']),
  },
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
    },
  },
}
