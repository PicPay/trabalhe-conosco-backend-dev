<template lang="html">
  <div class="search">

    <hero-search @handler="search" :status="getUsersStatus" />

    <div class="container">
      <div class="notification is-danger" v-show="getUsersStatus === 'fail'">
        {{getUsersFailureMessage}}
      </div>

      <div
      class="notification is-info"
      v-show="getUsersStatus === 'success' && usersList.length === 0 && searchKey">
        No results to <strong>{{searchKey}}</strong>
      </div>

      <div v-show="getUsersStatus === 'success'">
        <custom-table
        :data="usersList"
        :fields="['name', 'username']" />
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
  </div>
</template>

<script>
  import CustomTable from './CustomTable.vue';
  import Pagination from './Pagination.vue';
  import HeroSearch from './HeroSearch.vue';
  import { mapActions, mapGetters } from 'vuex';

  export default {
    data() {
      return {
        currentPage: 1,
        searchKey: null
      }
    },

    methods: {
      ...mapActions([
        'getUsers',
        'clearUsers'
      ]),
      search(key) {
        if (key) {
          this.searchKey = key;
          this.getUsers({ search: key });
        }
      },
      pageChanged(page) {
        this.currentPage = page;

        if (this.searchKey && page) {
          this.getUsers({ page, search: this.searchKey });
        }
      }
    },

    computed: {
      ...mapGetters([
        'usersList',
        'usersPage',
        'usersTotalPages',
        'usersTotalCount',
        'getUsersStatus',
        'getUsersFailureMessage',
      ])
    },

    components: {
      CustomTable,
      HeroSearch,
      Pagination
    },

    created() {
      this.clearUsers();
    }
  }
</script>

<style lang="css">
  .search .records-info {
    width: 100%;
    margin-bottom: 20px;
  }
</style>
