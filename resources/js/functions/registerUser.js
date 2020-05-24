import { EThree } from "@virgilsecurity/e3kit-browser";

export default function() {
    return new Promise(async (resolve, reject) => {
        try {
            await eThree.register();
            // console.log("Registered");
            resolve();
        } catch (err) {
            console.log(`Failed registering: ${err}`);
            if (err.name === "IdentityAlreadyExistsError") {
                // await eThree.cleanup();
                // await eThree.rotatePrivateKey();
                resolve();
            }
        }
    });
}
