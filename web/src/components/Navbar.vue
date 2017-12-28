<template lang="html">
  <nav class="navbar is-transparent">
     <div class="navbar-brand">
       <router-link class="navbar-item" to="/dashboard">
         <svg class="logo" height="28px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170 44">
           <path d="M28 34.3h5.8V17.4H28V34.3zM35.8 5.9h-3.9v3.9h3.9V5.9zM13.9 7.8H8.3v4.9h5.2c3.3 0 5.2 1.6 5.2 4.6 0 3-1.9 4.7-5.2 4.7H8.3v-9.2H2.5v21.5h5.8v-7.4h5.5c6.7 0 10.6-3.6 10.6-9.8C24.4 11.3 20.6 7.8 13.9 7.8zM39.7 2H28v11.7h11.7V2zM37.8 11.7H30V3.9h7.8V11.7zM71.8 7.8h-5.3v4.9h5c3.3 0 5.2 1.6 5.2 4.6 0 3-1.9 4.7-5.2 4.7h-5v-9.2h-5.8v21.5h5.8v-7.4h5.3c6.7 0 10.6-3.6 10.6-9.8C82.4 11.3 78.5 7.8 71.8 7.8zM120.5 14l-5 12.6 -5-12.6h-6l8 20.3 -3.1 7.7h6.1l11-28H120.5zM94.5 13.9c-3.5 0-6.2 0.8-9.2 2.3l1.8 4c2.1-1.2 4.2-1.8 6.1-1.8 2.8 0 4.2 1.2 4.2 3.4v0.4h-5.6c-5 0-7.7 2.3-7.7 6.1 0 3.7 2.6 6.3 7 6.3 2.8 0 4.8-1 6.4-2.7v2.2h5.7l0-13.2C103 16.6 99.9 13.9 94.5 13.9zM97.9 27.5c-0.6 1.7-2.3 3.1-4.7 3.1 -2 0-3.2-1-3.2-2.6 0-1.6 1.1-2.3 3.3-2.3h4.6V27.5zM48.6 29.9c-2.8 0-4.8-2.2-4.8-5.5 0-3.2 2-5.4 4.8-5.4 2 0 3.5 0.8 4.6 2.2l3.9-2.8c-1.8-2.7-4.9-4.3-8.8-4.3C42.2 14 38 18.2 38 24.4c0 6.2 4.2 10.3 10.3 10.3 4.2 0 7.3-1.7 9-4.5l-4-2.7C52.3 29.1 50.7 29.9 48.6 29.9z">
           </path>
         </svg>
       </router-link>
       <div class="navbar-burger burger" @click="toggleMenu">
         <span></span>
         <span></span>
         <span></span>
       </div>
     </div>

     <div class="navbar-menu" :class="{ 'is-active': isActive }" @click="toggleMenu">
       <div class="navbar-start">
        <router-link class="navbar-item" to="browser">
          Browser
        </router-link>
        <router-link class="navbar-item" to="search">
          Search
        </router-link>
       </div>
       <div class="navbar-end">
         <div class="navbar-item">
           <div class="field">
             <div class="control">
               <button class="button is-danger" @click="logout">Logout</button>
             </div>
           </div>
         </div>
       </div>
     </div>
   </nav>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {

  data() {
    return {
      isActive: false,
    }
  },
  methods: {
    ...mapActions([
      'logout'
    ]),
    toggleMenu() {
      this.isActive = !this.isActive;
    }
  },
  computed: mapGetters([
    'isLoggedIn'
  ]),
  watch: {
    isLoggedIn(value) {
      if (!value) {
        this.$router.replace('/login');
      }
    }
  }
}
</script>

<style lang="css">
</style>
