<template>
  <table>
    <thead>
      <tr>
        <td>ID</td>
        <td>Nome</td>
        <td>Username</td>
      </tr>
    </thead>
    <tbody>
      <ResultItem
        v-for="result in results"
        :result="result"
        :key="result.id"
      ></ResultItem>
    </tbody>
  </table>
</template>

<script>
import ResultItem from './ResultItem';

export default {
  name: 'ResultList',
  components: {
    ResultItem
  },
  props: ['results']
}
</script>