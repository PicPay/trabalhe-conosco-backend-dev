<template lang="html">
  <table class="table is-bordered is-striped is-fullwidth custom-table is-loading">
    <thead>
      <tr>
        <th v-for="field in fields">{{field}}</th>
      </tr>
    </thead>
    <tbody v-show="status === 'pending'">
      <tr v-for="i in mockData">
        <td v-for="field in fields">Loading...</td>
      </tr>
    </tbody>
    <tbody v-show="status === 'success'">
      <tr v-for="(item, i) in data">
        <td v-for="field in fields">
          <span>{{item[field]}}</span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
  export default {
    props: {
      data: {
        type: Array,
        required: true
      },
      fields: {
        type: Array,
        required: true,
      },
      status: {
        type: String,
        default: 'success'
      }
    },
    data() {
      return {
        mockData: new Array(15)
      }
    }
  }
</script>

<style lang="css">
  .custom-table th {
    text-transform: capitalize;
  }

  .custom-table {
    white-space: nowrap;
  }
</style>
