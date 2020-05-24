import { EThree } from "@virgilsecurity/e3kit-browser";

export default function() {
    return new Promise(async (resolve, reject) => {
        try {
            await eThree.unregister();
            console.log("unregistered");
            resolve();
        } catch (err) {
            console.log(`Failed unregister: ${err}`);
        }
    });
}
