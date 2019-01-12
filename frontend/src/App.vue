<template>
  <div id="app">
    <img width="250" height="130" src="https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png">
    <div></div>
    <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: 'app',
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
