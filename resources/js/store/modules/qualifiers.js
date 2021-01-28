export default {
    state: {
        categories: null,
        keywords: null,
        media: null,
        cast: null
    },
    getters: {
        getCategories(state) { return state.categories },
        getKeywords(state) { return state.keywords },
        getMedia(state) { return state.media },
        getCast(state) { return state.cast },
    },
    mutations: {
        SET_CATEGORIES: (state, payload) => { state.categories = payload },
        SET_KEYWORDS: (state, payload) => { state.keywords = payload  },
        SET_MEDIA: (state, payload) => { state.media = payload },
        SET_CAST: (state, payload) => { state.cast = payload },
    },
    actions: {
        setQualifiers(context, payload) {
            const set_option = 'SET_' + payload.toUpperCase()
            axios.get(`/api/${payload}`).then(response => {
                context.commit(set_option, response.data)
            }).catch(errors => console.log(errors))
        }
    }
}
