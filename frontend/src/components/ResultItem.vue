<template>
  <tr>
    <td>{{ result._id }}</td>
    <td>{{ result._source.name }}</td>
    <td>{{ result._source.username }}</td>
  </tr>
</template>

<script>
export default {
  name: 'ResultItem',
  props: ['result'],
}
</script>

<style>
</style>
