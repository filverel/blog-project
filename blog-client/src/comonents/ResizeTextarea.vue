/* In renderless components, we don't use the template tags */
<script>
import { ref } from 'vue'
export default  {
  setup(props, context) {
    const resize = () => {
      console.log('resized')
    }

    return () => context.slots.default({
      resize
    })
  },
}
</script>