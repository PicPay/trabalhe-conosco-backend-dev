<!--
  Based on tutorial from Fareez Ahamed.
  http://fareez.info/blog/pagination-component-using-vuejs/.
 -->

<template lang="html">
  <nav class="pagination is-centered" role="navigation" aria-label="pagination">
    <a class="pagination-previous" @click.prevent="pageChanged(
      currentPage > 1 ? currentPage - 1 : 1
    )">Previous</a>
    <a class="pagination-next" @click.prevent="pageChanged(
      currentPage < lastPage ? currentPage + 1 : lastPage
    )">Next page</a>
    <ul class="pagination-list">
      <li v-show="currentPage >= visiblePages">
        <a class="pagination-link"
        aria-label="Back to page 1"
        @click="pageChanged(1)">1</a>
        <span class="pagination-ellipsis">&hellip;</span>
      </li>
      <li v-for="page in paginationRange">
        <a class="pagination-link"
          aria-label="Goto page"
          :class="isCurrent(page)"
          @click.prevent="pageChanged(page)"
        >{{page}}</a>
      </li>
      <li v-show="(currentPage + 20) < lastPage">
        <span class="pagination-ellipsis">&hellip;</span>
        <a class="pagination-link"
        aria-label="More 20 pages"
        @click="pageChanged(
          (currentPage + 20) < lastPage ? currentPage + 20 : lastPage
        )">+20</a>
      </li>
    </ul>
  </nav>
</template>

<script>
  export default {
    props: {
      currentPage: {
        type: Number,
        required: true
      },
      totalPages: Number,
      itensPerPage: Number,
      totalItens: Number,
      visiblePages: {
        type: Number,
        default: 3,
        coerce: (val) => parseInt(val)
      }
    },

    data() {
      return {}
    },

    computed: {
      lastPage() {
        if (this.totalPages) {
          return this.totalPages;
        }

        return this.totalItems % this.itemsPerPage === 0
          ? this.totalItems / this.itemsPerPage
          : Math.floor(this.totalItems / this.itemsPerPage) + 1;
      },
      paginationRange () {
        const lowerBound = (num, limit) => num >= limit ? num : limit;

        let start = this.currentPage - this.visiblePages / 2 <= 0
                      ? 1 : this.currentPage + this.visiblePages / 2 > this.lastPage
                      ? lowerBound(this.lastPage - this.visiblePages + 1, 1)
                      : Math.ceil(this.currentPage - this.visiblePages / 2);

        let range = [];

        for (let i = 0; i < this.visiblePages && i < this.lastPage; i++) {
          range.push(start + i);
        }

        return range;
      }
    },

    methods: {
      pageChanged(page) {
        this.$emit('page-changed', page);
      },
      isCurrent(page) {
        return this.currentPage === page ? 'is-current' : '';
      }
    }
  }
</script>

<style lang="css">
</style>
