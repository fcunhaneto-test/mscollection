<template>
    <section class="section-table" v-if="titles">
        <div class="level mb-3">
            <div class="level-left">
                <div class="level-item">
                    <button v-if="!isSearch" class="button is-link my-3 ml-3" @click="searchFor">
                        Pesquisar<span class="ml-3"><i class="fas fa-search"></i></span>
                    </button>
                    <button v-else class="button is-link my-3 ml-3" @click="clearSearch">
                        Fechar Pesquisa<span class="ml-3"><i class="fas fa-times ml-3"></i></span>
                    </button>
                    <p v-if="isSearch" class="title is-4 ml-3">{{ header_aux }}</p>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <button class="button is-danger my-3 mr-3" @click="closeTableOrder">
                        Limpar Ordenação<span><i class="fas fa-times ml-3"></i></span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="isSearch" class="level ml-6 mb-3">
            <div class="level-left">
                <div class="level-item has-borders">
                    <label class="label mt-2 ml-2 mr-3">Títulos:</label>
                    <titles-search></titles-search>
                </div>
                <div class="level-item has-borders ml-3">
                    <label class="label mt-2 ml-2 mr-3">Categoria:</label>
                    <category-search></category-search>
                </div>
            </div>
        </div>
        <div v-if="isSearch" class="level ml-6 mb-3">
            <div class="level-left">
                <div class="level-item has-borders">
                    <label class="label mt-2 ml-2 mr-3">Ano:</label>
                    <year-search></year-search>
                </div>
                <div class="level-item has-borders">
                    <label class="label mt-2 ml-2 mr-3">Rating:</label>
                    <rating-search></rating-search>
                </div>
                <div v-show="table === 'movies'" class="level-item has-borders">
                    <label class="label mt-2 ml-2 mr-3">Tempo:</label>
                    <time-search></time-search>
                </div>
            </div>
        </div>
        <b-table
            v-model="title"
            :data="titles"
            :selected.sync="title"
            :key="resetSort"
            striped
            hoverable
            sticky-header
            mobile-cards
        >
            <b-table-column field="title" label="Título" sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.title }}</a>
            </b-table-column>
            <b-table-column field="year" label="Ano" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.year }}</a>
            </b-table-column>
            <b-table-column v-if="table === 'movies'" field="time" label="Tempo" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.time | strTime }}</a>
            </b-table-column>
            <b-table-column field="rating" label="Ranking" centered sortable v-slot="props">
                <a href="#" id="span-stars">
                    <b-icon v-for="(star, key) in props.row.rating"
                            :key="key+'y'"
                            pack="fas"
                            icon="star"
                    ></b-icon>
                    <b-icon v-for="(star, key) in (5 - props.row.rating)"
                            class="has-text-dark"
                            :key="key+'w'"
                            pack="far"
                            icon="star"
                    ></b-icon>
                </a>
            </b-table-column>
            <b-table-column field="category_1" label="Categoria 1" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.category_1 }}</a>
            </b-table-column>
            <b-table-column field="category_2" label="Categoria 2" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.category_2 }}</a>
            </b-table-column>
        </b-table>
        <div class="table-footer"></div>
    </section>
</template>

<script>
import CategorySearch from "./CategorySearch"
import YearSearch from "./YearSearch"
import RatingSearch from "./RatingSearch"
import TimeSearch from "./TimeSearch"
import TitlesSearch from "./TitlesSearch";

export default {
    name: "MoviesTable",
    components: {
        CategorySearch,
        YearSearch,
        RatingSearch,
        TimeSearch,
        TitlesSearch
    },
    props: {
        title_footer: String,
    },
    data() {
        return {
            isSearch: false,
            row: 0,
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            title: null,
            titles_copy: null,
            cast: [],
            media: [],
            directors: [],
        }
    },
    computed: {
        resetSort() {
            return this.$store.getters.getResetSort
        },
        table() {
            return this.$store.getters.getTable
        },
        titles() {
            return this.$store.getters.getTitles
        },
        header_aux() {
            return this.$store.getters.getHeaderAux
        },
    },
    watch: {
        title() {
            this.$store.commit('SET_TITLE', this.title)
            this.$router.push('/filme')
        }
    },
    methods: {
        searchFor() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.titles_copy = this.titles
            this.isSearch = !this.isSearch
            this.$emit('searching', this.isSearch)
        },
        clearSearch() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.isSearch = !this.isSearch
            this.$store.commit('SET_TITLES', this.titles_copy)
            this.$store.commit('SET_HEADER_AUX', null)
            this.$emit('searching', this.isSearch)
        },
        closeTableOrder() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
        },
    },
}
</script>

<style scoped>
.media-content {
    margin: auto;
}

.table tbody tr td {
    font-size: 1rem;
}

</style>
