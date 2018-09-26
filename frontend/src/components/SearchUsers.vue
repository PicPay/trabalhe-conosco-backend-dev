<template>

  <div>
    <md-toolbar class="md-medium md-primary">
      <div class="md-toolbar-row md-gutter">

        <div class="md-layout-item md-size-90">
          <h3 class="md-title">Buscador de usuários</h3>
        </div>
        <div class="md-layout-item" style='color: white'>
          <md-button class="md-icon-button md-primary" @click="logout()">
            <md-icon>exit_to_app</md-icon>
          </md-button>
        </div>
      </div>
    </md-toolbar>

    <md-content>
      <div class='md-field'>
        <md-field>
          <label>Procurar...</label>
          <md-input v-model="keyWord" @keyup.enter="fetchData"></md-input>
          <span class="md-helper-text">A busca irá considerar name e UserName</span>
          <md-button class="md-icon-button" @click='fetchData'>
            <md-icon>search</md-icon>
          </md-button>
        </md-field>
      </div>

      <div class='users-table'>
        <div class="loading-overlay" v-if="loading">
          <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
        </div>

        <md-table v-model="users" md-sort="priority" md-sort-order="desc" md-card >
          <md-table-toolbar>
            <h1 class="md-title">Users</h1>
          </md-table-toolbar>

          <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="ID" md-numeric>{{ item.id }}</md-table-cell>
            <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
            <md-table-cell md-label="UserName" md-sort-by="userName">{{ item.userName }}</md-table-cell>
            <md-table-cell md-label="Priority" md-sort-by="priority">{{ item.priority }}</md-table-cell>
          </md-table-row>

          <md-table-empty-state
            class="md-primary"
            md-rounded
            md-icon="find_in_page"
            md-label="Nenhum usuário encontrado"
            md-description="Tente uma nova busca." v-if="visible">
          </md-table-empty-state>
        </md-table>

        <div class='pagination'>
          <div class="md-layout md-gutter md-alignment-center-center">

            <div class="md-layout-item">
              <md-button class="md-primary" :disabled='previous_button_disabled' @click='previousPage'>
                <md-icon>arrow_back_ios</md-icon>
              </md-button>
            </div>
            <div class="md-layout-item">
              <p class="md-caption">Page {{ page }}</p>
              <p class="md-caption">Results: {{ this.meta.total }}</p>
            </div>
            <div class="md-layout-item">
              <md-button class="md-primary" :disabled='next_button_disabled' @click='nextPage'>
                <md-icon>arrow_forward_ios</md-icon>
              </md-button>
            </div>
          </div>
        </div>
      </div>

    <md-snackbar :md-position="snackbarPosition" :md-duration="snackbarDuration" :md-active.sync="showSnackbar" md-persistent>
      <span>{{snackbarMessage}}</span>
    </md-snackbar>

    </md-content>

  </div>

</template>


<script>

export default {
  name: 'TableSort',
  data () {
    return {

      users: [],
      loading: true,
      visible: false,
      previous_button_disabled: true,
      next_button_disabled: false,
      page: 1,
      meta: {},
      keyWord: '',
      showSnackbar: false,
      snackbarPosition: 'center',
      snackbarDuration: 4000,
      snackbarMessage: ""
    }
  },

  mounted() {
    if(localStorage.getItem('user-token') == null) {
      this.$router.replace({ name: "Login" });
    }
  },

  methods: {
    logout() {
      localStorage.removeItem('user-token')
      this.$router.replace({ name: "Login" });
    },
    fetchData (page = 1) {
      this.loading = true;
      this.search(this.keyWord, page).
        then(users => {
          this.users = users.data,
            this.loading = false,
            this.visible = true,
            this.meta = users.meta

        }, err => {
          this.showSnackbar = true,
          this.snackbarMessage = err.message
        });
    },
    search(q, page){
      return this.$http
        .get('http://localhost:8000/api/users',{params: { q: q, page: page }, headers: {'Authorization': localStorage.getItem('user-token')}})
        .then(res => res.json(),
          err=>{
            console.log(err);
            throw new Error('Não foi possivel carregar os usuários: '+ err.status +' ' + err.statusText);
          }
        )
    },

    previousPage() {
      this.page = this.page - 1;
      this.fetchData (this.page);

      if(this.page == 1) {
        this.previous_button_disabled = true
      }
    },
    nextPage() {
      this.page = this.page + 1;
      this.fetchData (this.page);

      if(this.meta.last_page == this.page) {
        this.previous_button_disabled = true
      }
      if(this.page != 1) {
        this.previous_button_disabled = false
      }
    }
  },

  created() {
    this.fetchData();
  }
}
</script>


<style lang="scss">

.md-content {
  padding: 16px;
}

.users-table {
  position: relative;
}

.pagination {
  text-align: center;
}

.loading-overlay {
  z-index: 10;
  top: 0;
  left: 0;
  right: 0;
  position: absolute;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>


