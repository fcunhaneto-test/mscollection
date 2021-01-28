<template>
    <b-field v-if="media" label="Mídias:" has-icons-right>
        <b-autocomplete
            v-model="name"
            id="media"
            placeholder="mídia"
            :open-on-focus=true
            :data="filteredDataArray"
            field="slug"
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
    name: "SearchMedia",
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
        media() {
            return this.$store.getters.getMedia
        },
        titles() {
            return this.$store.getters.getTitles
        },
        filteredDataArray() {
            return this.media.filter((option) => {
                return option.slug
                    .toString()
                    .toLowerCase()
                    .indexOf(this.name.toLowerCase()) >= 0
            })
        },
    },
    watch: {
        selected() {
            axios.get(`/api/${this.table}/media/${this.selected.id}`).then(response => {
                this.$store.commit('SET_HEADER_AUX', `Mídia ${this.selected.name}`)
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
            this.$emit('closeSearch')
        }
    },
    created() {
        if(!this.$store.getters.getMedia) {
            axios.get('/api/media').then(response => {
                this.$store.commit('SET_MEDIA', response.data)
            }).catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
