<template>
    <div class="container" v-if="privateKey">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <CreateNote />
            </div>
        </div>

        <AllNote
            :private-key="privateKey"
            :public-key="publicKey"
            :user="user"
        />
    </div>
</template>

<script>
const openpgp = require("openpgp");
import CreateNote from "./CreateNote";
import AllNote from "./AllNote";
import { mapState } from "vuex";

export default {
    components: {
        CreateNote,
        AllNote
    },

    computed: mapState({
        user: state => state.user.user,
        encryptionPassword: state => state.user.encryptionPassword,
        publicKey: state => state.user.publicKey,
        privateKey: state => state.user.privateKey
    }),

    async mounted() {}
};
</script>
