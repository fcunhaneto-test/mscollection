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
                    <label class="label mt-2 ml-2 mr-3">Avaliação:</label>
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
            <b-table-column field="rating" label="Avaliação" centered sortable v-slot="props">
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
        <b-modal v-if="title" v-model="isModalActive" :width="860" scroll="keep">
            <div class="card">
                <div class="has-text-right mb-1">
                    <button class="button is-link mt-1 mr-1 " @click="closeModal">
                        Fechar <i class="fas fa-times ml-2"></i></button>
                </div>
                <div class="card-content pt-0">
                    <div class="media has-background-black">
                        <div class="media-left mt-1 ml-1">
                            <img v-if="title.poster" :src="'../images/poster/' + title.poster"
                                 alt="Poster do Filme" width="120" height="162">
                            <img v-else :src="'../images/poster/faker-poster.png'" alt="Poster do Filme"
                                 width="120" height="162">
                        </div>
                        <div class="media-content">
                            <div class="mt-3">
                                <h2 class="title is-4 has-text-orange">{{ title.title }}</h2>
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
                                <b-tag v-if="title.category_2" type="is-link">Categorias:
                                    {{ title.category_1 }},
                                    {{ title.category_2 }}
                                </b-tag>
                                <b-tag v-else type="is-dark">Categoria: {{ title.category_1 }}</b-tag>
                            </b-taglist>
                        </div>
                    </div>
                    <div class="content mt-3">
                        <h3 class="title is-5 ml-3 has-text-dark">
                            Título Original: <span class="ml-5">{{ title.original_title }}</span>
                        </h3>
                        <div>
                            <h4 class="title is-6 mb-0 py-2 px-3">Resumo:</h4>
                            <hr>
                            <div class="mb-2 mx-3 has-text-black">{{ title.synopsis }}</div>
                            <hr>
                        </div>
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-4">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6">Ator/Personagem</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ac in cast">
                                <td class="pl-5">{{ ac.actor }}</td>
                                <td>{{ ac.character }}</td>
                            </tr>
                            </tbody>
                            <hr>
                        </table>
                        <table v-if="directors.length > 0" class="table table is-fullwidth mb-6">
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
                            <hr>
                        </table>
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
        },
    },
    watch: {
        title() {
            if (this.title) {
                axios.get(`/api/${this.table}/cast/${this.title.id}`).then(response => {
                    this.cast = response.data
                }).catch(errors => console.log(errors))
                axios.get(`/api/${this.table}/producers/${this.title.id}`).then(response => {
                    this.directors = response.data
                })
                this.isModalActive = true
            }
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
        closeModal() {
            this.isModalActive = false
            this.title = null
        }
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

hr {
    height: 2px;
    margin: 0 0 0.75rem 0;
    border-width: 0;
    color: #dbdbdb;
    background-color: #dbdbdb;
}
</style>
