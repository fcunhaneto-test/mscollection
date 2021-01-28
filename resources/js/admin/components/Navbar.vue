<template>
    <b-navbar v-show="user" wrapper-class="container" type="is-dark">
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ path: '/' }">MSCollection</b-navbar-item>
        </template>
        <template slot="start">
            <b-navbar-dropdown label="Filmes">
                <b-navbar-item tag="router-link" :to="{ name: 'movies-view' }">Visão</b-navbar-item>
                <b-navbar-item href="#">Inserir</b-navbar-item>
            </b-navbar-dropdown>
            <b-navbar-dropdown label="Séries">
                <b-navbar-item tag="router-link" :to="{ name: 'series-view' }">Visão</b-navbar-item>
                <b-navbar-item href="#">Editar</b-navbar-item>
                <b-navbar-item href="#">Inserir</b-navbar-item>
            </b-navbar-dropdown>
        </template>

        <template slot="end">
            <b-navbar-dropdown :label="user.name">
                <b-navbar-item tag="button" class="button is-white" @click="toFrontend">frontend</b-navbar-item>
                <b-navbar-item href="#">edit</b-navbar-item>
            </b-navbar-dropdown>
        </template>
    </b-navbar>
</template>


<script>
export default {
    name: "Navbar",
    computed: {
        user() {
            return this.$store.getters.getUser
        }
    },
    data() {
        return {
            media_movie: null,
            media_series: null,
        }
    },
    methods: {
        toFrontend() {
            window.location.href = '/'
        }
    },
}
</script>

<style scoped>

</style>
