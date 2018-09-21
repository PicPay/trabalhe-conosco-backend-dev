<template>

<div id="body">
  <header>
    <nav>
      <div class="nav-wrapper">
        <SearchBar @termChange="onTermChange"></SearchBar>
      </div>
    </nav>
  </header>
  <main>
    <div class="container">
      <p>Encontrado <strong>{{ totalHits }}</strong> registros em <strong>{{ timeTook }}</strong> milisegundos.</p>
      <ResultList :results="results"></ResultList>
    </div>
  </main>
  <br>
  <Footer></Footer>
</div>

</template>

<script>
import axios from 'axios';
import SearchBar 	from './components/SearchBar';
import ResultList 	from './components/ResultList';
import ResultItem 	from './components/ResultItem';
import Footer 	from './components/Footer';

export default {
  name: 'app',
  components: {
    SearchBar,
    ResultList,
    ResultItem,
    Footer
  },
  data() {
    return {
      results:[],
      totalHits:0,
      timeTook:0
    }
  },
  methods: {
    onTermChange(searchTerm) {
      if (searchTerm != "") {
        axios.get('http://localhost:8080/user/search/'+searchTerm).then(response => {
          console.log(response.data);
          this.totalHits = response.data.hits.total;
          this.timeTook = response.data.took;
          this.results = response.data.hits.hits;
        });
      }
    }
  }
}
</script>

<style>
body, #body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
  font-family: 'Roboto';
  background-color: #f5f5f5;
}
main {
  flex: 1 0 auto;
}
nav {
  background-color: #4caf50;
}
</style>
