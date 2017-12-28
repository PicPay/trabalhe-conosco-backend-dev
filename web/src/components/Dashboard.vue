<template lang="html">
  <div class="dashboard">
    <div class="container">
      <navbar />
    </div>

    <router-view></router-view>
  </div>
</template>

<script>
  import Navbar from './Navbar.vue';

  export default {
    components: {
      Navbar
    }
  }
</script>

<style lang="css">
  .dashboard,
  .dashboard .hero,
  .dashboard .pagination {
    margin-bottom: 20px;
  }
</style>
