<template>
    <div class="field is-horizontal">
        <div class="py-2 px-2">
            <a v-for="ys in yellow_star" href="#" :key="'yellow_' + ys" @click="delStar(ys)">
                <span class="icon icon-stars"><i class="fas fa-star"></i></span>
            </a>
            <a v-for="ws in white_star" href="#" :key="'white_'+ ws" @click="addStar(ws)">
                <span class="icon has-text-dark"><i class="far fa-star"></i></span>
            </a>
        </div>

        <button
            class="button is-link is-outlined"
            @click="searchRating"
            v-tooltip="{
                  content: msg,
                  placement: 'top-center',
                  classes: ['button', 'is-dark'],
                  targetClasses: ['it-has-a-tooltip'],
                  offset: 20,
            }"
        >
            <i class="fas fa-search"></i>
        </button>
    </div>

</template>

<script>
export default {
    name: "RatingSearch",
    data() {
        return {
            yellow_star: 0,
            white_star: 5,
            msg: 'Pesquisar Rating'
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
        delStar(ys) {
            if (parseInt(ys) === 1) {
                console.log('YS', ys)
                this.yellow_star = 0
                this.white_star = 5
            } else if(parseInt(ys) === 2)  {
                this.yellow_star = 1
                this.white_star = 4
            } else {
                this.yellow_star = ys
                this.white_star = 5 - this.yellow_star
            }
            console.log('YEllOW', this.yellow_star)
            console.log('WITHE', this.white_star)
        },
        addStar(ws) {
            this.yellow_star += ws
            this.white_star = 5 - this.yellow_star
        },
        searchRating() {
            axios.get(`/api/${this.table}/frontend-rating/${this.channel}/${this.yellow_star}`).then(reponse => {
                this.$store.commit('SET_TITLES', reponse.data)
            }).catch(errors => console.log(errors))
        }
    },
    beforeMount() {
        this.yellow_star = 0
        this.white_star = 5
    }

}
</script>

<style scoped>
.icon-stars {
    color: #F9A825;
}
</style>
