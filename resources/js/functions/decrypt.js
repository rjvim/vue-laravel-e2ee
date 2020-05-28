const openpgp = require("openpgp");

export default function(privateKey, text) {
    return new Promise(async (resolve, reject) => {
        let currentUserPrivateKey = (await openpgp.key.readArmored(privateKey))
            .keys[0];

        let title = await openpgp.decrypt({
            message: await openpgp.message.readArmored(window.atob(text)),
            privateKeys: [currentUserPrivateKey]
        });

        title = await openpgp.stream.readToEnd(title.data);

        resolve(title);
    });
}
