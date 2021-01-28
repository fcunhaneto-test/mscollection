export default {
    getUser: state => { return state.user },
    getTable: state => { return state.table },
    getChannel: state => { return state.channel },
    getTitles: state => { return state.titles },
    getTitle: state => { return state.title },
    getMsTitle: state => { return state.ms_title },
    getPage: state => { return state.page },
    getPerPage: state => { return state.per_page },
    getLetters: state => { return state.letters },
    getLetter: state => { return state.letter },
    getHeaderAux: state => { return state.header_aux },
    getResetSort: state => { return state.resetSort },
}