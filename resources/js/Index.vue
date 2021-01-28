<template>
    <div class="main">
        <router-view :header="header"></router-view>
        <pages-footer></pages-footer>
    </div>
</template>

<script>
import PagesFooter from "./components/PagesFooter";

export default {
    name: "Index",
    components: {PagesFooter},
    props: {
        header: String,
        table: String
    },
    beforeMount() {
        if (navigator.cookieEnabled) {
            if (this.$cookies.isKey('per_page')) {
                this.$store.commit('SET_PER_PAGE', this.$cookies.get('per_page'))
            } else {
                this.$cookies.set('per_page', 10)
            }
        }
        this.$store.commit('SET_CHANNEL', this.$route.params.channel)
        this.$store.commit('SET_TABLE', this.table)
    }
}
</script>

<style scoped>

</style>
