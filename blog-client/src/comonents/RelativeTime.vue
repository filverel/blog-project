<script>
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
dayjs.extend(relativeTime)
import { ref, watch } from 'vue'

export default {
  props: {
    date: {
      required: true,
    }
  },
  setup(props, context) {
    let date = ref(props.date)
    watch(() => props.date, (value) => {
      date.value = value
    })
    setInterval(() => {
      date.value = dayjs(date.value)
    }, 60000)

    return () => context.slots.default({
      fromNow: date.value.fromNow()
    })
  },
}
</script>