<template>
    <div class="container is-widescreen">
        <div class="columns is-centered">
            <div class="column is-two-thirds mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <div class="media-left pt-1 pl-1">
                                <img v-if="title.poster" :src="'../images/poster/' + title.poster"
                                     alt="Poster do Filme" width="120"
                                     height="162">
                                <img v-else :src="'../images/poster/faker_poster_120x162.png'"
                                     alt="Poster do Filme" width="120"
                                     height="162">
                            </div>
                            <div class="media-content">
                                <div class="mt-3">
                                    <h1 class="title is-4 has-text-orange">{{ title.title }}</h1>
                                    <p class="subtitle is-5 has-text-light">Título Original: {{
                                            title.original_title
                                        }}</p>
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
                    </div>
                    <div class="card-content mt-3 pt-0">
                        <table v-if="cast.length > 0" class="table table is-fullwidth mt-3">
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
                        </table>
                        <table v-if="producers.length > 0" class="table table is-fullwidth mt-3 pt-0">
                            <thead class="has-background-white">
                            <tr>
                                <th class="title is-6 pt-0">
                                    <span v-if="table === 'movies'">Diretor(es)</span>
                                    <span v-else>Criador(es)</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="producer in producers">
                                <td class="pl-5">{{ producer.name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="mb-6 mt-3 px-0">
                            <h5 class="title is-6 resume">Resumo:</h5>
                            <hr>
                            <p class="resume-body px-5">{{ title.synopsis }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TitlesCard",
    data() {
        return {
            cast: [],
            producers: [],
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        title() {
            return this.$store.getters.getTitle
        }
    },
    created() {
        console.log('TABLE', this.table)
        console.log('TITLE', this.title.title)
        axios.get(`/api/${this.table}/cast/${this.title.id}`).then(response => {
            this.cast = response.data
        }).catch(errors => console.log(errors))
        axios.get(`/api/${this.table}/producers/${this.title.id}`).then(response => {
            this.producers = response.data
        })
    }

}
</script>

<style scoped>
.card-header {
    width: 100%;
    background-color: #0a0a0a;
}
hr {
    height:2px;
    margin: 0.75rem 0;
    border-width:0;
    color:black;
    background-color:black;
}
table td {
    font-size: 1rem;
}
.resume {
    margin: 0;
    padding: 0 15px;
}
.resume-body {
    color: #000000;
    font-size: 1rem;
}
</style>
