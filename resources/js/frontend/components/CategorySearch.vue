<template>
    <b-field v-if="categories" label="Categoria:" has-icons-right>
        <b-autocomplete
            v-model="name"
            id="categories"
            placeholder="categorias"
            :open-on-focus=true
            :data="filteredDataArray"
            field="name"
            icon-right="chevron-down"
            @select="option => (selected = option)"
        >
            <template slot="empty">No results found</template>
        </b-autocomplete>
    </b-field>
</template>

<script>
export default {
    name: "CategorySearch",
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
        categories() {
            return this.$store.getters.getCategories
        },
        channel() {
            return this.$store.getters.getChannel
        },
        titles() {
            return this.$store.getters.getTitles
        },
        filteredDataArray() {
            return this.categories.filter((option) => {
                return option.name
                    .toString()
                    .toLowerCase()
                    .indexOf(this.name.toLowerCase()) >= 0
            })
        },
    },
    watch: {
        selected() {
            axios.get(`/api/${this.table}/search-channel-category/${this.channel}/${this.selected.name}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
                return {}
            }).catch(errors => console.log(errors))
        }
    },
    created() {
        if (!this.$store.getters.getCategories) {
            axios.get('/api/categories').then(response => {
                this.$store.commit('SET_CATEGORIES', response.data)
            }).catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
