export default {
    deleteTitle(context, payload) {
        axios.delete(`/api/${payload.table}/id`)
    }
}
