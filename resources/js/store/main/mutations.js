export default {
    SET_USER: (state, payload) => { state.user = payload },
    SET_TABLE: (state, payload) => { state.table = payload },
    SET_CHANNEL: (state, payload) => { state.channel = payload },
    SET_TITLES: (state, payload) => { state.titles = payload },
    SET_TITLE: (state, payload) => { state.title = payload },
    SET_MS_TITLE: (state, payload) => { state.ms_title = payload },
    SET_PAGE: (state, payload) => { state.page = payload },
    SET_PER_PAGE: (state, payload) => { state.per_page = payload },
    SET_LETTERS: (state, payload) => { state.letters = payload },
    SET_LETTER: (state, payload) => { state.letter = payload },
    SET_HEADER_AUX: (state, payload) => { state.header_aux = payload },
    SET_RESET_SORT: (state, payload) => { state.resetSort = payload },
}
