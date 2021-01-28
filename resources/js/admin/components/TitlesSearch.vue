<template>
    <div>
        <div class="columns px-3 mb-0">
            <div class="column is-12 mb-0">
                <div class="level-item mb-0">
                    <div class="control mb-0 mr-6">
                        <button v-if="!isSearch" class="button is-link is-outlined" @click="searchFor">
                            Pesquisar
                        </button>
                        <button v-if="isSearch" class="button is-link is-outlined" @click="closeSearch">
                            Pesquisa<span class="ml-3"><i class="fas fa-times"></i></span>
                        </button>
                        <button class="button is-outlined mr-6" @click="closeTableOrder()">
                            Ordenação<span class="ml-3"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isSearch" class="columns my-0">
            <div class="column is-4 my-0">
                <search-media></search-media>
            </div>
            <div class="column is-4 my-0">
                <search-category></search-category>
            </div>
            <div class="column is-4 my-0">
                <p>Pesquisar Keyword</p>
            </div>
        </div>
        <div v-if="isSearch" class="columns my-0">
            <div class="column is-2 my-0">
                <div class="control my-0">
                    <label for="year" class="label">Ano:</label>
                    <div class="field is-horizontal">
                        <input id="year" maxlength="4" type="text" v-model="year"
                               @keyup.enter="searchYear"></input>
                        <button class="button" @click="closeSearch"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
            <div class="column is-3 my-0">
                <div class="control my-0">
                    <label for="year" class="label">Tempo entre:</label>
                    <div class="field is-horizontal">
                        <input id="start" maxlength="5" type="time" v-model="start" class="mr-2"></input>
                        <input id="end" maxlength="5" type="time" v-model="end"
                               @keyup.enter.prevent="searchTime"></input>
                        <button class="button" @click="closeSearch"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SearchCategory from "./SearchCategory";
import SearchMedia from "./SearchMedia";

export default {
    name: "TitlesSearch",
    components: {
        SearchCategory,
        SearchMedia
    },
    data() {
        return {
            isSearch: false,
            year: 1900,
            start: '00:00',
            end: '01:00',
            titles_copy: null,
        }
    },
    computed: {
        titles() {
            return this.$store.getters.getTitles
        },
        header_aux() {
            return this.$store.getters.getHeaderAux
        },
    },
    methods: {
        searchFor() {
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.titles_copy = this.titles
            this.isSearch = !this.isSearch
        },
        searchYear() {
            axios.get(`/api/${this.table}/year/${this.year}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
                this.$store.commit('SET_HEADER_AUX', `Ano ${this.year}`)
            }).catch(errors => console.log(errors))
        },
        searchTime() {
            //
        },
        closeSearch() {
            this.year = 1900
            this.start = '00:00'
            this.end = '01:00'
            this.isSearch = !this.isSearch
            this.$store.commit('SET_RESET_SORT', new Date().toLocaleString())
            this.$store.commit('SET_HEADER_AUX', '')
            this.$store.commit('SET_TITLES', this.titles_copy)
        },
    }
}

</script>

<style scoped>

</style>
