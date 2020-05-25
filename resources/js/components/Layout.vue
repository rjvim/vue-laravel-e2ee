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

    methods: {
        async pgp() {
            const {
                privateKeyArmored,
                publicKeyArmored
            } = await openpgp.generateKey({
                userIds: [{ email: "jon@example.com" }], // you can pass multiple user IDs
                curve: "curve25519" // ECC curve name
            });

            // console.log(privateKeyArmored); // '-----BEGIN PGP PRIVATE KEY BLOCK ... '
            // console.log(publicKeyArmored); // '-----BEGIN PGP PUBLIC KEY BLOCK ... '

            let encoded = window.btoa(privateKeyArmored);

            console.log(encoded);
            console.log(window.atob(encoded));

            //   const privateKey = (await openpgp.key.readArmored([privateKeyArmored]))
            //     .keys[0];

            //   const encrypted = await openpgp.encrypt({
            //     message: openpgp.message.fromText("Hello World, Rajiv"), // input as Message object
            //     publicKeys: (await openpgp.key.readArmored(publicKeyArmored)).keys
            //   });

            //   const ciphertext = encrypted.data;

            //   console.log(ciphertext);

            //   const decrypted = await openpgp.decrypt({
            //     message: await openpgp.message.readArmored(ciphertext),
            //     privateKeys: [privateKey]
            //   });

            //   const plaintext = await openpgp.stream.readToEnd(decrypted.data);

            //   console.log(plaintext);

            //   console.log("encrypt");
            //   const { message } = await openpgp.encrypt({
            //     message: openpgp.message.fromText("Hello World, Rajiv"),
            //     passwords: ["secret stuff"],
            //     armor: false
            //   });
            //   const encrypted = message.packets.write();
            //   console.log("encrypted", encrypted);
            //   const { data: decrypted } = await openpgp.decrypt({
            //     message: await openpgp.message.read(encrypted), // parse encrypted bytes
            //     passwords: ["secret stuff"]
            //   });
            //   console.log(decrypted); // Uint8Array([0x01, 0x01, 0x01])
        }
    },

    async destroyed() {
        console.log("Destroyed");
    }
};
</script>
