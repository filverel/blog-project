<template>
  <form action="" v-on:submit.prevent="login">
    <button type="submit">Login</button>
  </form>
</template>

<script>
import {useStore} from 'vuex'
export default {
  setup() {
    const store = useStore()
    // here we dispatch the name of the action that we created in the vuex store (namely login)
    // store.dispatch('login')
    const login = () => {
      store.dispatch('login', {
        email: 'info@example.com',
        password: '112528823'
      })
    }
    return {
      login
    }
  },
}
</script>