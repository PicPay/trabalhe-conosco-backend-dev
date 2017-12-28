<template lang="html">
  <div class="browser">
    <section class="hero is-dark">
      <div class="hero-body">
        <div class="container">
          <h1 class="title">
            Browser
          </h1>
          <h2 class="subtitle">
            List all users
          </h2>
        </div>
      </div>
    </section>

    <div class="container" >
      <div class="notification is-danger" v-show="getUsersStatus === 'fail'">
        {{getUsersFailureMessage}}
      </div>

      <custom-table
      :data="usersList"
      :fields="['name', 'username']"
      :status="getUsersStatus" />

      <div class="records-info">
        <strong>{{usersList.length}}</strong> from
        <strong>{{usersTotalCount}}</strong> records
      </div>

      <pagination
      :current-page="currentPage"
      :total-pages="usersTotalPages"
      :itens-per-page="15"
      @page-changed="pageChanged" />
    </div>
  </div>
</template>

<script>
  import CustomTable from './CustomTable.vue';
  import Pagination from './Pagination.vue';
  import { mapActions, mapGetters } from 'vuex';

  export default {
    data() {
      return {
        currentPage: 1
      }
    },

    methods: {
      ...mapActions([
        'getUsers'
      ]),
      pageChanged(page) {
        this.currentPage = page;
        this.getUsers({ page });
      }
    },

    computed: {
      ...mapGetters([
        'usersList',
        'usersPage',
        'usersTotalPages',
        'usersTotalCount',
        'getUsersStatus',
        'getUsersFailureMessage'
      ])
    },

    components: {
      CustomTable,
      Pagination
    },

    created() {
      this.getUsers();
    }
  }
</script>

<style lang="css">
  .browser .records-info {
    width: 100%;
    margin-bottom: 20px;
  }

  .browser .loader {
    text-align: center;
  }
</style>
