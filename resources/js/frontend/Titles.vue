<template>
    <div class="container is-widescreen">
        <div class="columns is-centered">
            <div class="column mt-5">
                <div class="level mb-3">
                    <div class="level-item">
                        <h1 v-if="header" class="title is-3 has-text-right">
                            <span v-if="table === 'movies'">Filmes</span>
                            <span v-else>Séries</span>
                            {{ header }}
                        </h1>
                    </div>
                    <div class="level-item">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <label for="per_page" class="label mr-2 mt-2">Por página</label>
                                <div class="select mr-6">
                                    <select id="per_page" v-model="selected">
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                        <option value="20">25</option>
                                        <option value="30">30</option>
                                    </select>
                                </div>
                                <b-switch v-model="isCard">Tabela/Cartão</b-switch>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <titles-pagination :pages="pages"></titles-pagination>
                </div>
                <titles-table></titles-table>
            </div>
        </div>
    </div>
</template>

<script>
import TitlesPagination from "./components/TitlesPagination";
import TitlesTable from "./components/TitlesTable";
import CategorySearch from "./components/CategorySearch";

export default {
    name: "Titles",
    components: {
        TitlesPagination,
        TitlesTable,
        CategorySearch,
    },
    props: {
        header: String,
    },
    data() {
        return {
            isCard: false,
            selected: null,
            pages: 1,
            page_copy: 1,
            word: '',
            year: 1900,
            start: '01:00',
            end: '02:00',
            rating: 1
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        channel() {
            return this.$store.getters.getChannel
        },
        titles() {
            return this.$store.getters.getTitles
        },
        per_page() {
            return this.$store.getters.getPerPage
        },
    },
    watch: {
        selected() {
            if (navigator.cookieEnabled) {
                this.$cookies.set('per_page', this.selected)
            }
            this.$store.commit('SET_PER_PAGE', this.selected)
            this.$store.commit('SET_PAGE', 1)
            this.getTitles()
        },
    },
    methods: {
        getTitles() {
            axios.get(`/api/${this.table}/frontend-start/${this.channel}/${this.per_page}`).then(response => {
                this.pages = response.data[0]
                this.$store.commit('SET_TITLES', response.data[1])
            }).catch(errors => console.log(errors))
        }
    },
    beforeMount() {
        this.selected = this.$store.getters.getPerPage
        this.getTitles()
    }

}
</script>

<style scoped>

</style>
