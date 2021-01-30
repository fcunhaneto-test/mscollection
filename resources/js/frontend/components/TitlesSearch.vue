<template>
    <b-field v-if="titles_channel" has-icons-right>
        <b-autocomplete
            v-model="title"
            id="title"
            placeholder="título"
            :open-on-focus=true
            :data="filteredDataArray"
            field="title"
            icon-right="chevron-down"
            @select="option => (selected = option)"
        >
            <template slot="empty">No results found</template>
        </b-autocomplete>
    </b-field>
</template>

<script>
export default {
    name: "TitlesSearch",
    data() {
        return {
            title: '',
            selected: null,
            titles_channel: null
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        channel() {
            return this.$store.getters.getChannel
        },
        filteredDataArray() {
            return this.titles_channel.filter((option) => {
                return option.title
                    .toString()
                    .toLowerCase()
                    .indexOf(this.title.toLowerCase()) >= 0
            })
        },
    },
    watch: {
        selected() {
            console.log('TITLE SELECTED', this.selected.id, this.selected.title)
            axios.get(`/api/${this.table}/show/${this.selected.id}`).then(response => {
                console.log(response.data)
                this.$store.commit('SET_TITLES', response.data)
                this.$store.commit('SET_HEADER_AUX', `Título = ${this.selected.title}`)
                return {}
            }).catch(errors => console.log(errors))
        }
    },
    created() {
        axios.get(`/api/${this.table}/channel/${this.channel}`).then(response => {
            this.titles_channel = response.data
        }).catch(errors => console.log(errors))
    }
}
</script>

<style scoped>

</style>
