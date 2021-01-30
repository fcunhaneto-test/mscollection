<template>
    <div class="field is-horizontal">
        <input id="start" maxlength="5" type="time" class="input mr-2" v-model="start"></input>
        <input id="end" maxlength="5" type="time" class="input" v-model="end"
               @keyup.enter.prevent="searchTime"></input>
    </div>
</template>

<script>
export default {
    name: "TimeSearch",
    data() {
        return {
            start: '01:00',
            end: '02:00'
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
        searchTime() {
            axios.get(`/api/${this.table}/frontend-time/${this.channel}/${this.start}/${this.end}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
                this.$store.commit('SET_HEADER_AUX', `Tempo Entre ${this.start} e ${this.end}`)
                return {}
            }).catch(errors => console.log(errors))
        },
    }
}
</script>

<style scoped>

</style>
