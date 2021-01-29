<template>
    <footer class="footer">
            <p class="has-text-right has-text-white mt-6 mr-6">
                MSCollection by Francisco Cunha Neto. O código fonte está sobe a licença
                <a class="has-text-dark" href="http://opensource.org/licenses/mit-license.php" target="_blank">
                 MIT</a>
                e você pode adquirir ele em
                <a class="has-text-dark" href="https://github.com/fcunhaneto-test/mscollection.git" target="_blank">
                    <i class="fab fa-github"></i> github
                </a>
            </p>
    </footer>
</template>

<script>
export default {
    name: "PagesFooter"
}
</script>

<style scoped>
.footer {
    position: absolute;
    width: 100%;
    height: 90px;
    bottom: 0;
    overflow: hidden;
    padding: 0;
    background-color: #0074d7;
}
a {
    text-decoration: underline;
}
</style>
