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
    methods: {
        searchTime() {
            let start = this.strTime(this.start.toString())
            let end = this.strTime(this.end.toString())
            axios.get(`/api/movies/channel-time/${this.channel}/${start}/${end}`).then(response => {
                this.$store.commit('SET_TITLES', response.data)
            }).catch(errors => console.log(errors))
        },
    }
}
</script>

<style scoped>

</style>
