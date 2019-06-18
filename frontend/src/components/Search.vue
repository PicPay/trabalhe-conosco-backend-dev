<template>
  <div class="search">
        <div class="search-bar">
            <div class="bar">
                <input v-model='search' title="search" placeholder="Palavra Chave"/>
                <button @click="fetchUsers" class="btn">Buscar</button>
            </div>
              <a></a>
              <table id="tableUsers" class="nowrap responsive table table-hover table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th v-for="(cab, index) in cabecalho" :key="index">{{ cab }}</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                </tfoot>
                <tbody>
                  <tr v-for="(obj, index) in items" :key="index">
                      <td>{{ obj.id }}</td>
                      <td>{{obj.name}}</td>
                      <td>{{ obj.username }}</td>
                  </tr>
                </tbody>
              </table>

              <b-pagination :total-rows="100" v-model="currentPage" :per-page="15" @change="fetchUsers">
                <div>currentPage: {{currentPage}}</div>
              </b-pagination>
      </div>
  </div>

</template>
 <script>
import axios from 'axios'

export default {
    data () {
        return {
        search: '',
        items: [],
        currentPage: 1,
        cabecalho: ['Id', 'Nome', 'Username']
      }
    },
    methods: {
    fetchUsers () {
        const baseURL = 'http://localhost:3000/search/'+ this.currentPage;
        axios.post(baseURL, this.search)
        .then((result) => {
          let users = result.data;
          if(this.items.length)
            this.items = [];
          users.forEach(element => {
            this.items.push(element)
          });
        })
      this.inicializarDataTable()
    },
    inicializarDataTable() {
      if(window.tabelaHistoricoVenda != null){
        window.tabelaHistoricoVenda.destroy();
        window.tabelaHistoricoVenda = null;
      }
    },
  }
}
</script>
<style scoped>  
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.limiter {
  width: 100%;
  margin: 0 auto;
}
.search-bar{
  float: center;
  width: 80%;
  min-width: 320px;
  max-width: 1000px;
  background: #fff;
  position: absolute;
  top: 30%;
  left: 10%;
}
.b-pagination {
   color: green !important
}
input {
    width: 80%;
    padding: .5em 0;
    border: none;
    padding-bottom: 1.25em;
    margin-bottom: .5em;
}
input:focus {
   outline: none
}

.btn {
    background: #42b983;
    border: 0.5px #87dab4;
    color: white;
    margin-right: .5em;
    margin-bottom: .5em;
}
.btn:hover {
    background:  #7bd4ac;
}

</style>