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
const openpgp = require("openpgp");

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
    // let virgilToken = await getVirgilToken();
    // eThree = await initializeEThree(virgilToken);
    // await registerUser(virgilToken);
    // const hasLocalPrivateKey = await eThree.hasLocalPrivateKey();

    // console.log("hasLocalPrivateKey", hasLocalPrivateKey);

    // await unregisterUser();
    // const publicKeys = await eThree.findUsers([appUser.email]);

    // const { loginPassword, backupPassword } = await EThree.derivePasswords(
    //     "password"
    // );

    // console.log(loginPassword, backupPassword);

    this.ready = true;
    Bus.$emit("virgilReady");
    this.pgp();
  },

  methods: {
    async pgp() {
      const { privateKeyArmored, publicKeyArmored } = await openpgp.generateKey(
        {
          curve: "ed25519" // ECC curve name
        }
      );

      console.log(privateKeyArmored); // '-----BEGIN PGP PRIVATE KEY BLOCK ... '
      console.log(publicKeyArmored); // '-----BEGIN PGP PUBLIC KEY BLOCK ... '

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
