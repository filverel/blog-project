<template>
  <div>
    <div class="absolute w-full left-0 top-0 p-6 flex justify-between items-center space-x-6">
      <div class="flex-grow flex items-center">
        <span class="mr-1">/</span>
        <input type="text" class="p-0 border-none focus:ring-0 w-full" v-model="post.slug" spellcheck="false" @click="$event.target.select()">
      </div>
      <div class="flex items-center space-x-6">
        <RelativeTime :date="lastSaved" v-if="lastSaved">
          <template v-slot:default="{ fromNow }" >
            <span class="text-sm text-gray-500">{{ fromNow }}</span>
          </template>
        </RelativeTime>
        <div>
          <button @click="post.published = !post.published" class="text-sm font-medium" :class="{ 'text-pink-500': post.published }">
            {{ !post.published ? 'Publish' : 'Unpublish' }}
          </button>
        </div>
        <div>
<!--          <router-link :to="{ name: 'post', params: { slug: post.slug } }" class="text-sm font-medium text-gray-800">-->
<!--            Preview-->
<!--          </router-link>-->
        </div>
      </div>
    </div>
    <div>
      <ResizeTextarea v-if="post.title">
        <template v-slot:default="{ resize, el }">
          <textarea :ref="el" v-model="post.title" @input="resize" class="w-full text-center text-4xl lg:text-6xl leading-10 font-extrabold tracking-tight text-gray-900 border-none focus:ring-0 resize-none p-0" rows="1"></textarea>
        </template>
      </ResizeTextarea>
    </div>

    <!-- we can use double vue models in Vue3 provided they're properly named -->
    <Editor
        v-model:modelValue="post.body"
        v-model:teaserValue="post.teaser"
        class="mt-16"
    />
  </div>
</template>

<script>
import useAdminPosts from '../../api/useAdminPosts'
import { onMounted, watch, watchEffect, ref } from 'vue'
import _ from 'lodash' // cloneDeep below and debounce are imported from here
import ResizeTextarea from '../../comonents/ResizeTextarea.vue'
import RelativeTime from '../../comonents/RelativeTime.vue'
import Editor from '../../comonents/Editor.vue'
import slugify from "slugify";
import dayjs from 'dayjs'

export default {
  components: {
    ResizeTextarea,
    Editor,
    RelativeTime
  },
  props: {
    uuid: {
      required: true,
      type: String
    }
  },
  setup(props)  {
    const { post, fetchPost, patchPost } = useAdminPosts()
    const lastSaved = ref(null)
    const updatePost = async () => {
      await patchPost(props.uuid)
      lastSaved.value = dayjs()
    }

    const replaceSlug = () => {
      const slug = post.value.slug
      if (slug.charAt(slug.length - 1) === ' ') {
        return
      }
      post.value.slug = slug ? slugify(slug, { strict: true }) : post.value.uuid
    }

    onMounted(async () => {
      await fetchPost(props.uuid)
      watchEffect(() => {
        replaceSlug()
      })
      watch(() => _.cloneDeep(post), _.debounce(() => {
        updatePost()
      }, 500))
    })
    return {
      post,
      lastSaved
    }
  },
}
</script>