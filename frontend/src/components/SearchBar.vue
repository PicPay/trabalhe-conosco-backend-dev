<template>
<div class="input-field">
  <input id="search" type="search" @input="onInput" placeholder="Busca" required>
  <label class="label-icon" for="search"><i class="material-icons">search</i></label>
  <i class="material-icons">close</i>
</div>
</template>

<script>
export default {
  name: 'SearchBar',
  methods: {
    onInput: function(event) {
      this.$emit('termChange', event.target.value);
    }
  }
};
</script>

<style>

</style>
