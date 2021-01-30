<template>
    <section class="section-table" v-if="titles">
        <div class="level mb-3">
            <div class="level-left">
                <button v-if="!isSearch" class="button is-link my-3 ml-3" @click="searchFor">
                    Pesquisar<span class="ml-3"><i class="fas fa-search"></i></span>
                </button>
                <button v-else class="button is-link my-3 ml-3" @click="clearSearch">
                    Fechar Pesquisa<span class="ml-3"><i class="fas fa-times"></i></span>
                </button>
            </div>
            <div class="level-right">
                <button class="button is-danger my-3 mr-3" @click="closeTableOrder">
                    Limpar Ordenação<span><i class="fas fa-times"></i></span>
                </button>
            </div>
        </div>
        <div v-if="isSearch" class="level ml-6 mb-3">
            <div class="level-left">
                <div class="level-item has-borders ml-3">
                    <label class="label mt-2 ml-2 mr-3">Categoria:</label>
                    <category-search></category-search>
                </div>
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
        <b-modal v-if="title" v-model="isModalActive" :width="640" scroll="keep">
            <div class="card">
                <div class="has-text-right">
                    <button class="button is-light is-small mt-1 mr-1" @click="closeModal">
                        <i class="fas fa-times"></i></button>
                </div>
                <div class="card-content pt-0">
                    <div class="media has-background-black">
                        <div class="media-left">
                            <figure class="image">
                                <img v-if="title.poster" :src="'../images/poster/' + title.poster"
                                     alt="Poster do Filme">
                                <img v-else :src="'../images/poster/faker-poster.png'" alt="Poster do Filme">
                            </figure>
                        </div>
                        <div class="media-content">
                            <div class="mt-3">
                                <h2 class="title is-4 has-text-white">{{ title.title }}</h2>
                            </div>
                            <div class="is-inline-block mt-4">
                                <b-tag class="mr-2" type="is-info">Ano: {{ title.year }}</b-tag>
                                <b-tag class="mr-4" v-if="title.time" type="is-info">Duração: {{
                                        title.time | strTime
                                    }}
                                </b-tag>
                                <span>
                                    <b-icon v-for="(star, key) in title.rating" class="has-text-warning"
                                            :key="key+'y'"
                                            pack="fas"
                                            icon="star"
                                    ></b-icon>
                                    <b-icon v-for="(star, key) in (5 - title.rating)" class="has-text-white"
                                            :key="key+'w'"
                                            pack="fas"
                                            icon="star"
                                    ></b-icon>
                                </span>
                            </div>
                            <b-taglist class="mt-2 mb-0">
                                <b-tag v-if="title.category_2" type="is-light" class="has-text-black">Categorias:
                                    {{ title.category_1 }},
                                    {{ title.category_2 }}
                                </b-tag>
                                <b-tag v-else type="is-dark">Categoria: {{ title.category_1 }}</b-tag>
                            </b-taglist>
                        </div>
                    </div>

                    <div class="content">
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-5">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6">Ator/Personagem</th>
                                <th class="title is-6"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ac in cast">
                                <td class="pl-5">{{ ac.actor }}</td>
                                <td>{{ ac.character }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="directors.length > 0" class="table table is-fullwidth mt-5">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6">
                                    <span v-if="table === 'movies'">Diretor(es)</span>
                                    <span v-else>Criador(es)</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="director in directors">
                                <td class="pl-5">{{ director.name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-6 mt-6 ml-2">
                            <h3 class="title is-6 mb-2 pb-0">Resumo:</h3>
                            <p>{{ title.synopsis }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
    </section>
</template>

<script>
import CategorySearch from "./CategorySearch"
import YearSearch from "./YearSearch"
import RatingSearch from "./RatingSearch"
import TimeSearch from "./TimeSearch"

export default {
    name: "MoviesTable",
    components: {
        CategorySearch,
        YearSearch,
        RatingSearch,
        TimeSearch
    },
    props: {
        title_footer: String,
    },
    data() {
        return {
            isSearch: false,
            isModalActive: false,
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
        }
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
        },
        clearSearch() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.isSearch = !this.isSearch
            this.$store.commit('SET_TITLES', this.titles_copy)
            this.$store.commit('SET_HEADER_AUX', null)
        },
        closeTableOrder() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
        },
        closeModal() {
            this.isModalActive = false
            this.title = null
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
