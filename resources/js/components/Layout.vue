<template>
    <div>
        <div v-if="user">
            <div v-if="encryptionPassword && publicKey">
                <router-view></router-view>
            </div>
            <div v-else>
                <div v-if="encryptionPassword">
                    <PublicKey />
                </div>
                <div v-else>
                    <BackupPassword />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
const openpgp = require("openpgp");
import BackupPassword from "./BackupPassword.vue";
import PublicKey from "./PublicKey.vue";

export default {
    data: () => {
        return {
            ready: false
        };
    },

    components: {
        BackupPassword,
        PublicKey
    },

    computed: mapState({
        user: state => state.user.user,
        encryptionPassword: state => state.user.encryptionPassword,
        publicKey: state => state.user.publicKey,
        privateKey: state => state.user.privateKey
    }),

    mounted() {},

    methods: {},

    async destroyed() {
        console.log("Destroyed");
    }
};
</script>
