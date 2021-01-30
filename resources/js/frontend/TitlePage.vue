<template>
    <div class="container is-widescreen">
        <div class="columns is-centered">
            <div class="column is-two-thirds mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image">
                                    <img v-if="title.poster" :src="'../images/poster/' + title.poster"
                                         alt="Poster do Filme">
                                    <img v-else :src="'../images/poster/faker-poster.png'" alt="Poster do Filme">
                                </figure>
                            </div>
                            <div class="media-content" >
                                <div class="mt-3">
                                    <h1 class="title is-4 has-text-orange">{{ title.title }}</h1>
                                    <p class="subtitle is-5 has-text-light">Título Original: {{ title.original_title }}</p>
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
                    <div class="card-content">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                        <a href="#">#css</a> <a href="#">#responsive</a>
                        <br>
                        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
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
</style>
