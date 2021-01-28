<template>
    <nav v-if="letters" class="pagination is-small is-centered pt-4" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
            <li v-if="letter" class="" v-for="(l, key) in letters" :key="key">
                <a
                    class="pagination-link"
                   :class= "{
                        'is-current': (letter === l.letter && l.exist),
                        'is-disabled': (!l.exist)
                    }"
                   href="#"
                   @click="searchLetter(l.letter)"
                   :disable="!l.exist"
                >
                    {{ l.letter }}
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "TitlesLetters",
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        letter() {
            return this.$store.getters.getLetter
        },
        letters() {
            return this.$store.getters.getLetters
        }
    },
    methods: {
        searchLetter(letter) {
            this.$store.commit('SET_LETTER', letter)
            axios.get(`/api/${this.table}/admin/${this.letter}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
            }).catch(error => console.log(error))
        },
    }
}
</script>

<style scoped>

</style>
