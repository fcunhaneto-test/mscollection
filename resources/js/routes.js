import VueRouter from "vue-router";

import Titles from "./frontend/Titles";
import TitlesView from "./admin/TitlesView";
const routes = [
    {
        path: '/filmes/:channel',
        component: Titles,
        name: 'movies'
    },
    {
        path: '/series/:channel',
        component: Titles,
        name: 'series'
    },
    {
        path: '/admin/filmes',
        component: TitlesView,
        props: { table: 'movies' },
        name: 'movies-view'
    },
    {
        path: '/admin/series',
        component: TitlesView,
        props: { table: 'series' },
        name: 'series-view'
    },
];

const router = new VueRouter({
    mode: "history",
    routes
})

export default router;
