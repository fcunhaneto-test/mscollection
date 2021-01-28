<template>
    <section class="section-table" v-if="titles">
        <button class="button is-danger is-rounded is-small my-3 ml-6" @click="closeTableOrder">
            Limpar Ordenação das Colunas<span class="ml-3"><i class="fas fa-times"></i></span>
        </button>
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
            <template slot="footer">
                <div>
                    {{ title_footer }}
                </div>
            </template>
        </b-table>
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
export default {
    name: "MoviesTable",
    props: {
        title_footer: String,
    },
    data() {
        return {
            loading: true,
            isFullPage: false,
            row: 0,
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            title: null,
            isModalActive: false,
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
        closeModal() {
            this.isModalActive = false
            this.title = null
        },
        closeTableOrder() {
            this.$emit('closeTableOrder')
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
</style>
