/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
window.Bus = new Vue();
import router from "./routes";
import store from "./store/index.js";
import Layout from "./components/Layout.vue";

const app = new Vue({
    el: "#app",
    store,
    router,
    components: {
        Layout
    },

    async mounted() {
        await this.$store.dispatch("user/getUser");
    },

    methods: {
        logout() {
            axios.post("/logout").then(response => {
                window.location.href = "/login";
            });
        }
    }
});
