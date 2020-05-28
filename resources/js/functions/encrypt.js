const openpgp = require("openpgp");

export default function(pubKeys, text) {
    console.log("Calling encrypt", pubKeys, text);

    return new Promise(async (resolve, reject) => {
        let publicKeysPromises = pubKeys.map(async key => {
            return (await openpgp.key.readArmored(key)).keys[0];
        });

        let encrypted = await openpgp.encrypt({
            message: openpgp.message.fromText(text),
            publicKeys: await Promise.all(publicKeysPromises)
        });

        resolve(window.btoa(encrypted.data));
    });
}
