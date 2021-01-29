<template>
    <div class="field">
        <input class="input" id="year" maxlength="4" type="text" v-model="year"
               @keyup.enter="searchYear"></input>
    </div>
</template>

<script>
export default {
    name: "YearSearch",
    data() {
        return {
            year: 1900,
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        channel() {
            return this.$store.getters.getChannel
        },
    },
    methods: {
        searchYear() {
            axios.get(`/api/${this.table}/frontend-year/${this.channel}/${this.year}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
                this.$store.commit('SET_HEADER_AUX', `Ano = ${this.selected.name}`)
                return {}
            }).catch(errors => console.log(errors))
        },
        clearSearch() {
            this.$store.commit('SET_HEADER_AUX', '')
            this.name = ''
            this.$emit('clearYear')
        }
    }
}
</script>

<style scoped>
#year {
    max-width: 90px;
    padding-left: 0.5rem;
    font-size: 1rem;
}
</style>
