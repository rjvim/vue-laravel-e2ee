import VueRouter from "vue-router";
import Vue from "vue";

Vue.use(VueRouter);

let routes = [
    {
        path: "/",
        name: "home",
        component: require("./components/Dashboard").default
    }
];

export default new VueRouter({
    routes
});
