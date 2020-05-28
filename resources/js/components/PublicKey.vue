<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Setting up your app...
                    </div>

                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
const openpgp = require("openpgp");
import updateUserKeys from "../functions/updateUserKeys";

export default {
    data: () => {
        return {};
    },

    computed: mapState({
        user: state => state.user.user,
        encryptionPassword: state => state.user.encryptionPassword,
        publicKey: state => state.user.publicKey,
        privateKey: state => state.user.privateKey
    }),

    async mounted() {
        if (this.user.public_key !== null) {
            console.log("User has public key", this.user);

            this.$store.dispatch("user/setPublicKey", {
                publicKey: window.atob(this.user.public_key)
            });

            try {
                const { data: decrypted } = await openpgp.decrypt({
                    message: await openpgp.message.readArmored(
                        window.atob(this.user.private_key)
                    ),
                    passwords: [this.encryptionPassword]
                });
                // We restored user private key after decrypting with user password
                this.$store.dispatch("user/setPrivateKey", {
                    privateKey: decrypted
                });
            } catch (error) {
                localStorage.removeItem("encryptionPassword");
                this.$store.dispatch("user/clearEncryptionData");
            }
        } else {
            console.log("User doesnt have public key");

            const {
                privateKeyArmored,
                publicKeyArmored
            } = await openpgp.generateKey({
                userIds: [{ email: this.user.email }],
                curve: "curve25519"
            });

            const encryptedPrivateKey = await openpgp.encrypt({
                message: openpgp.message.fromText(privateKeyArmored),
                passwords: [this.encryptionPassword]
            });

            await updateUserKeys({
                public_key: window.btoa(publicKeyArmored),
                private_key: window.btoa(encryptedPrivateKey.data)
            });

            window.location.reload(true);

            await this.$store.dispatch("user/getUser");
        }
    },

    methods: {}
};
</script>
