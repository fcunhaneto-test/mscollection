<template>
    <section  v-if="titles" class="section-table mt-3">
        <titles-search></titles-search>
        <b-table
            v-if="titles"
            v-model="title"
            :data="titles"
            :selected.sync="title"
            :key="resetSort"
            defaultSortDirection="asc"
            striped
            hoverable
            sticky-header
            mobile-cards
        >
            <b-table-column field="id" class="table-link-front" label="ID" :visible="false" numeric v-slot="props">
                {{ props.row.id }}
            </b-table-column>

            <b-table-column field="title" label="Título" sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.title }}</a>
            </b-table-column>

            <b-table-column field="year" label="Ano" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.year }}</a>
            </b-table-column>

            <b-table-column field="time" label="Tempo" :visible="table === 'movies'" centered sortable v-slot="props">
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
            <b-table-column field="keyword" label="Keywords" centered sortable v-slot="props">
                <a class="table-link-front" href="#">{{ props.row.keyword }}</a>
            </b-table-column>
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
                                     alt="Poster do Filme/Série">
                                <img v-else :src="'../images/poster/faker-poster.png'" alt="Poster do Filme">
                            </figure>
                        </div>
                        <div class="media-content">
                            <div class="mt-3">
                                <h3 class="has-text-white">{{ title.title }}</h3>
                            </div>
                            <div class="is-inline-block mt-4">
                                <b-tag class="mr-2" type="is-info">Ano: {{ title.year }}</b-tag>
                                <b-tag v-if="table === 'movies'" class="mr-4" type="is-info">Duração: {{
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
                        <b-loading :is-full-page="isFullPage" v-model="loading" :can-cancel="true"></b-loading>
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-5">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-5">Ator/Personagem</th>
                                <th class="title is-5"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ac in cast">
                                <td>{{ ac.actor }}</td>
                                <td>{{ ac.character }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-5">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6">
                                    <span v-if="table === 'movies'">Diretor(es)</span>
                                    <span v-if="table === 'series'">Criador(es)</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="producer in producers">
                                <td class="pl-5">{{ producer.name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-5">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6">Mídia(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="m in media">
                                <td class="pl-5">{{ m.name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-6 mt-2 ml-2">
                            <h5 class="title is-5 mb-2 pb-0">Resumo:</h5>
                            <p>{{ title.synopsis }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
    </section>
</template>

<script>
import TitlesSearch from "./TitlesSearch";
export default {
    name: "TitlesViewTable",
    components: {
        TitlesSearch
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
            producers: [],
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
                this.loading = true
                axios.get(`/api/${this.table}/admin/modal-data/${this.title.id}`).then(response => {
                    this.cast = response.data[0]
                    this.media = response.data[1];
                    this.producers = response.data[2];
                    this.loading = false
                }).catch(errors => console.log(errors))

                this.isModalActive = true
            }
        },
    },
    methods: {
        closeModal() {
            this.isModalActive = false
            this.title = null
        },
        closeTableOrder() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
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

