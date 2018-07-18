<template>
  <div id="app">
    <nprogress-container />
    <div v-if="$auth.ready()">
      <router-view />
    </div>

    <div v-if="!$auth.ready()">
      Loading ...
    </div>
  </div>
</template>

<script>
import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
import store from '@/store'

export default {
  name: 'app',
  store,
  components: {
    NprogressContainer
  }
}
</script>

<style lang="scss">
// buefy lib
@import '~buefy/lib/buefy.css';

// basic imports
@import '~bulmaswatch/spacelab/variables';
@import '~bulma';
@import '~buefy/src/scss/buefy';

// theme overrides
@import '~bulmaswatch/spacelab/overrides';

// font-awesome
$fa-font-path: '~font-awesome/fonts/';
@import '~font-awesome/scss/font-awesome';

.nprogress-container {
  position: fixed !important;
  left: 0px;
  width: 100%;
  height: 50px;
  z-index: 2048;
  pointer-events: none;
  #nprogress {
    $color: $danger;
    .bar {
      background: $color;
    }
    .peg {
      box-shadow: 0 0 10px $color, 0 0 5px $color;
    }
    .spinner-icon {
      border-top-color: $color;
      border-left-color: $color;
    }
  }
}
</style>
