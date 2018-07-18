<template>

  <div v-hotkey="keymap"
       class="search">
    <div class="columns">
      <div class="column">
        <form @submit.prevent="load">
          <b-field label="Pesquise por um usuário">
            <b-input v-model="keyword"
                     placeholder="ex. Rafael"
                     icon="search"
                     @input="onInput"
                     v-focus></b-input>
          </b-field>
        </form>
      </div>
      <div class="column"></div>
    </div>
    <div v-if="keyword.length > 2">
      <p class="has-text-grey-light is-size-7">Total de
        <strong>{{total}}</strong> resultados encontrados para o termo:
        <strong>"{{keyword}}"</strong>
      </p>
      <p class="has-text-grey-light is-size-7">
        Navegue pelas páginas utilizando as teclas:
        <span class="has-text-grey-light is-size-7">
          <kbd>ctrl</kbd>+
          <kbd>alt</kbd>+
          <kbd>→</kbd>
          &
          <kbd>ctrl</kbd>+
          <kbd>alt</kbd>+
          <kbd>←</kbd>
        </span>
      </p>
      <br />
      <table class="table is-fullwidth is-hoverable is-striped"
             v-if="users.length > 0">
        <thead>
          <tr>
            <th class="is-primary"></th>
            <th class="is-primary">Id</th>
            <th class="is-primary">Username</th>
            <th class="is-primary">Nome</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users"
              :key="user.id">
            <td class="markup">
              <b-icon type="is-warning"
                      pack="fa"
                      icon="star"
                      v-if="user.priority == 1" />
              <b-icon type="is-warning"
                      pack="fa"
                      icon="star-o"
                      v-else-if="user.priority == 2" />
            </td>
            <td class="td375">{{user.id}}</td>
            <td class="td375">
              <span v-html="user.username"></span>
            </td>
            <td>
              <span v-html="user.nome"></span>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3">
              <b-pagination :total="total"
                            :per-page="perPage"
                            :current.sync="page"
                            size="is-small"
                            order="is-centered"
                            @change="onPageChange">
              </b-pagination>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

</template>

<script>
import user from '@/components/user.vue'
import { mapGetters } from 'vuex'

export default {
  name: 'home',
  data() {
    return {
      keyword: '',
      page: 1,
      perPage: 15
    }
  },
  components: {
    user
  },
  computed: {
    keymap() {
      return {
        'ctrl+alt+left': this.prevPage,
        'ctrl+alt+right': this.nextPage
      }
    },
    ...mapGetters({
      users: 'users/list',
      total: 'users/total'
    })
  },
  methods: {
    load() {
      let skip = this.perPage * (this.page - 1)
      this.$store.dispatch('users/getUsers', {
        keyword: this.keyword,
        skip: skip
      })
    },
    onInput() {
      if (this.keyword.length > 2) this.onPageChange(1)
    },
    nextPage() {
      if (this.page < Math.ceil(this.total / this.perPage))
        this.onPageChange(this.page + 1)
    },
    prevPage() {
      if (this.page > 1) this.onPageChange(this.page - 1)
    },
    onPageChange(page) {
      this.page = page
      this.load()
    }
  }
}
</script>

<style lang="scss" >
.search {
  padding: 10px;
}

.td375 {
  width: 375px;
}

.markup {
  width: 25px;
  text-align: center;
}

kbd {
  display: inline-block;
  padding: 3px 5px;
  font: 11px 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier,
    monospace;
  line-height: 10px;
  color: #444d56;
  vertical-align: middle;
  background-color: #fcfcfc;
  border: solid 1px #c6cbd1;
  border-bottom-color: #959da5;
  border-radius: 3px;
  box-shadow: inset 0 -1px 0 #959da5;
  .hero-section {
    margin-top: 1.5rem;
  }
}
</style>
