<template>
    <div>
        <navbar></navbar>
        <router-view></router-view>
    </div>
</template>

<script>
import Navbar from "./admin/components/Navbar";

export default {
    name: "Admin",
    components: {Navbar},
    props: {
        name: String,
        role: String,
    },
    beforeMount() {
        this.$store.commit('SET_USER', { name: this.name, role: this.role })
    }

}
</script>

<style scoped>

</style>
