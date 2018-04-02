<template>
    <section>
        <b-field>
            <b-input placeholder="Search..."
                     type="search"
                     size="is-large"
                     icon="magnify"
                     @input="onQueryChange">
            </b-input>
        </b-field>
        <b-table
                :data="data"
                :loading="loading"

                paginated
                backend-pagination
                :total="total"
                :per-page="perPage"
                @page-change="onPageChange">

            <template slot-scope="props">
                <b-table-column field="original_title" label="Id">
                    {{ props.row.id }}
                </b-table-column>

                <b-table-column label="Nome">
                    {{ props.row.name }}
                </b-table-column>
                <b-table-column label="Username">
                    {{ props.row.username }}
                </b-table-column>
                <b-table-column label="Prioridade">
                    {{ props.row.priority.name }}
                </b-table-column>
            </template>
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                    icon="emoticon-sad"
                                    size="is-large">
                            </b-icon>
                        </p>
                        <p>Nenhum usuário foi encontrado.</p>
                    </div>
                </section>
            </template>
        </b-table>
    </section>
</template>

<script>
    export default {
        name: 'userList',

        data() {
            return {
                data: [],
                total: 0,
                loading: false,
                page: 1,
                perPage: 25,
                query: ''
            }
        },
        methods: {
            /*
             * Load async data
             */
            loadAsyncData() {
                const params = [
                    `query=${this.query}`,
                    `page=${this.page}`
                ].join('&')

                this.loading = true
                this.$http.get(`/api/users?${params}`)
                    .then(({ data }) => {
                        this.data = data.results;
                        this.total = data.total_results;
                        this.loading = false
                    })
                    .catch((error) => {
                        this.data = []
                        this.total = 0
                        this.loading = false
                        throw error
                    })
            },
            /*
             * Handle page-change event
             */
            onPageChange(page) {
                this.page = page;
                this.loadAsyncData()
            },
            onQueryChange(query) {
                this.query = query;
                this.loadAsyncData();
            }
        },
        mounted() {
            this.loadAsyncData()
        }
    }
</script>
