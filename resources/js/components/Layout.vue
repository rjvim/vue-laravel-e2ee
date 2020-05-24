<template>
    <div v-if="ready"></div>
</template>

<script>
import getUser from "../functions/getUser.js";
import getVirgilToken from "../functions/getVirgilToken.js";
import initializeEThree from "../functions/initializeEThree.js";
import registerUser from "../functions/registerUser.js";
import unregisterUser from "../functions/unregisterUser.js";
import findUserPublicKey from "../functions/findUserPublicKey.js";
import CreateNote from "./CreateNote";
import AllNote from "./AllNote";
import { EThree } from "@virgilsecurity/e3kit-browser";

export default {
    data: () => {
        return {
            ready: false
        };
    },
    components: {
        CreateNote,
        AllNote
    },

    async mounted() {
        // First register user

        // Ask user for password

        // Backup to virgil
        appUser = await getUser();
        let virgilToken = await getVirgilToken();
        eThree = await initializeEThree(virgilToken);
        // await registerUser(virgilToken);
        const hasLocalPrivateKey = await eThree.hasLocalPrivateKey();

        console.log("hasLocalPrivateKey", hasLocalPrivateKey);

        // await unregisterUser();
        // const publicKeys = await eThree.findUsers([appUser.email]);

        // const { loginPassword, backupPassword } = await EThree.derivePasswords(
        //     "password"
        // );

        // console.log(loginPassword, backupPassword);

        this.ready = true;
        Bus.$emit("virgilReady");
    }
};
</script>
