<template lang="html">
  <div class="hero is-dark hero-search">
    <div class="hero-body">
      <div class="container">
        <div class="container">
          <h1 class="title">
            Search
          </h1>
          <h2 class="subtitle">
            Search users by name or username
          </h2>
        </div>
        <br>
        <form @submit.prevent="submit(key)">
          <div class="field has-addons">
            <div class="control is-expanded">
              <input
              class="input is-large"
              type="text"
              placeholder="Search..."
              v-model="key"
              :disabled="status === 'pending'"
              autofocus>
            </div>
            <div class="control">
              <button
              type="submit"
              class="button is-large"
              :class="{ 'is-loading': status === 'pending' }">
                Search
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      status: {
        type: String,
        default: 'success'
      }
    },
    data() {
      return {
        key: ''
      }
    },
    methods: {
      submit(key) {
        this.$emit('handler', key);
      }
    }
  }
</script>

<style lang="css">
</style>
