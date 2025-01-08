<template>
  <div>
    <div>
      <textarea v-model="post.title" class="w-full text-center text-4xl lg:text-6xl leading-10 font-extrabold tracking-tight text-gray-900 border-none focus:ring-0 resize-none p-0">
      </textarea>
    </div>
  </div>
</template>

<script>
import useAdminPosts from '../../api/useAdminPosts'
import { onMounted, watch } from 'vue'
import _ from 'lodash' // cloneDeep below and debounce are imported from here

export default {
  props: {
    slug: {
      required: true,
      type: String
    }
  },
  setup(props)  {
    const { post, fetchPost, patchPost } = useAdminPosts()
    const updatePost = async () => {
      await patchPost(props.slug)
    }

    onMounted(async () => {
      await fetchPost(props.slug)
      watch(() => _.cloneDeep(post), _.debounce(() => {
        updatePost()
      }, 500))
    })
    return {
      post
    }
  },
}
</script>