<template>
    <div class="container is-widescreen">
        <div class="columns is-centered">
            <div class="column mt-5">
                <div class="level mb-3">
                    <div class="level-item">
                        <transition
                            name="bounce"
                            enter-active-class="bounceInLeft"
                            leave-active-class="bounceOutRight">
                            <h1 v-if="header" class="title is-3 has-text-right">
                                <span v-if="table === 'movies'">Filmes</span>
                                <span v-else>Séries</span>
                                {{ header }}
                            </h1>
                        </transition>
                    </div>
                    <div class="level-item">
                        <div class="field is-horizontal">
                            <button v-if="!isSearch" class="button is-link mr-6" @click="searchFor()">
                                Pesquisar
                            </button>
                            <button v-if="isSearch" class="button is-link is-hovered mr-6" @click="clearSearch()">
                                Pesquisa<span class="ml-3"><i class="fas fa-times"></i></span>
                            </button>

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
                <div v-if="isSearch" class="columns is-centered">
                    <div class="column is-1">
                        <div class="field">
                            <label for="year" class="label">Ano</label>
                            <div class="control">
                                <input id="year" class="input" type="text" v-model="year" @keyup.enter="searchYear">
                            </div>
                        </div>
                    </div>
                    <div v-if="table === 'movies'" class="column is-2">
                        <div class="field">
                            <label class="label">Tempo entre</label>
                            <div class="level">
                                <div class="level-item">
                                    <input class="input" type="time" v-model="start">
                                    <input class="input" type="time" v-model="end" @keyup.enter="searchTime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column is-2">
                        <div class="field">
                            <label class="label" for="rating">Avaliação</label>
                            <div class="select">
                                <select id="rating" v-model="rating">
                                    <option value=0>Sem Avaliação</option>
                                    <option value=1>1 estrela</option>
                                    <option value=2>2 estrelas</option>
                                    <option value=3>3 estrelas</option>
                                    <option value=4>4 estrelas</option>
                                    <option value=5>5 estrelas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="column is-3">
                        <category-search></category-search>
                    </div>
                </div>
                <div v-else class="mb-3">
                    <titles-pagination :pages="pages"></titles-pagination>
                </div>
                <titles-table @closeTableOrder="closeTableOrder"></titles-table>
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
            isSearch: false,
            selected: null,
            pages: 1,
            page_copy: 1,
            titles_copy: null,
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
        rating() {
            axios.get(`/api/${this.table}/search-channel-rating/${this.channel}/${this.rating}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
            }).catch(errors => console.log(erros))
        }
    },
    methods: {
        searchFor() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.titles_copy = this.titles
            this.isSearch = !this.isSearch
        },
        searchYear() {
            axios.get(`/api/${this.table}/search-channel-year/${this.channel}/${this.year}`).then(response => {
                this.$store.commit('SET_HEADER_AUX', `Ano ${this.year}`)
                this.$store.commit('SET_TITLES', response.data)
            }).catch(errors => console.log(erros))
        },
        searchTime() {
            axios.get(`/api/${this.table}/search-channel-time/${this.channel}/${this.start}/${this.end}`)
                .then(response => {
                    this.$store.commit('SET_TITLES', response.data)
                })
                .catch(errors => console.log(erros))
        },
        clearSearch() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.isSearch = !this.isSearch
            this.$store.commit('SET_TITLES', this.titles_copy)
        },
        closeTableOrder() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
        },
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
