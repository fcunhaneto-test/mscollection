<template>
    <div class="container is-widescreen">
        <div class="columns is-centered">
            <div class="column">
                <header class="level mt-4 mb-0">
                    <div class="level-item">
                        <h1 class="title is-3">
                            <span v-if="table === 'movies'">Filmes</span><span v-else>Séries</span> Administração</h1>
                        <h2 v-show="header_aux" class="title is-4 ml-5 pt-1">{{ header_aux }}</h2>
                    </div>
                </header>
                <div class="mt-3 mb-6">
                    <titles-letters></titles-letters>
                </div>
                <titles-view-table></titles-view-table>
            </div>
        </div>
    </div>
</template>

<script>
import TitlesLetters from "./components/TitlesLetters";
import TitlesViewTable from "./components/TitlesViewTable";

export default {
    name: "TitlesView",
    components: {
        TitlesLetters,
        TitlesViewTable,
    },
    props: {
        table: String
    },
    data() {
        return {
            isCard: false,
            isPagination: true,
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
    beforeMount() {
        this.$store.commit('SET_TABLE', this.table)
        axios.get(`/api/${this.table}/admin`).then(response => {
            this.startLetter = response.data[1]
            this.$store.commit('SET_LETTERS', response.data[0])
            this.$store.commit('SET_LETTER', response.data[1])
            this.$store.commit('SET_TITLES', response.data[2])
            this.isTitle = true
            this.loading = false
        }).catch(errors => {
            console.log(errors)
        })
    },
}
</script>

<style scoped>
#year, #start, #end {
    width: 90px;
    padding-left: 0.5rem;
    font-size: 1rem;
}
</style>
