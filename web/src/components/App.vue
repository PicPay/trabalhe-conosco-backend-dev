<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app',
  data () {
    return {
      msg: 'Olá'
    }
  }
};
</script>

<style>
@import '../../node_modules/bulma/css/bulma.css';
</style>
