<template>
    <b-field v-if="keywords" label="Keywords:" has-icons-right>
        <b-autocomplete
            v-model="name"
            id="keywords"
            placeholder="keyword"
            :open-on-focus=true
            :data="filteredDataArray"
            field="name"
            icon-right="chevron-down"
            @select="option => (selected = option)"
        >
            <template slot="empty">No results found</template>
        </b-autocomplete>
        <b-button @click="clearSearch"><i class="fas fa-times"></i></b-button>
    </b-field>
</template>

<script>
export default {
    name: "SearchKeywords",
    data() {
        return {
            name: '',
            selected: null,
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        keywords() {
            return this.$store.getters.getKeywords
        },
        titles() {
            return this.$store.getters.getTitles
        },
        filteredDataArray() {
            return this.keywords.filter((option) => {
                return option.name
                    .toString()
                    .toLowerCase()
                    .indexOf(this.name.toLowerCase()) >= 0
            })
        },
    },
    watch: {
        selected() {
            axios.get(`/api/${this.table}/keyword/${this.selected.name}`).then(response => {
                this.$store.commit('SET_HEADER_AUX', `Keyword ${this.selected.name}`)
                this.$store.commit('SET_TITLES', response.data)
                this.$emit('endSearch')
                return {}
            }).catch(errors => console.log(errors))
        }
    },
    methods: {
        clearSearch() {
            this.$store.commit('SET_HEADER_AUX', '')
            this.name = ''
            this.$emit('closeSearch', false)
        }
    },
    created() {
        if(!this.$store.getters.getKeywords) {
            axios.get('/api/keywords').then(response => {
                console.log(response.data)
                this.$store.commit('SET_KEYWORDS', response.data)
            }).catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
