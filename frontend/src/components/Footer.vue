<template>
  <footer class="page-footer">
    <div class="container">
      <div class="row">
        <div class="col l12">
          <h5 class="white-text">API de Busca PicPay</h5>
          <p class="grey-text text-lighten-4">Front-end desenvolvido em <a href="https://vuejs.org/">Vue.js</a>, API PHP em <a href="https://lumen.laravel.com/">Lumen</a> e utilizando o <a href="https://www.elastic.co/products/elasticsearch">ElasticSearch</a> como motor de busca.</p>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      © 2018 Augusto Ribeiro
      <a class="grey-text text-lighten-4 right" href="https://github.com/cesaribeiro/trabalhe-conosco-backend-dev">Github</a>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer'
}
</script>

<style>
.page-footer {
  background-color: #424242;
}
.footer-copyright {
  background-color: #616161 !important;
}
</style>
