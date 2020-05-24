import { EThree } from "@virgilsecurity/e3kit-browser";

export default function(text, recipientPublicKey) {
    return new Promise(async (resolve, reject) => {
        let benchmarking = false;
        let encryptedText = null;
        let repetitions = benchmarking ? 100 : 1;

        const then = new Date();
        try {
            for (let i = 0; i < repetitions; i++) {
                encryptedText = await eThree.authEncrypt(text);
            }
            let time = (new Date() - then) / repetitions;
            // console.log(
            //     `Encrypted and signed: '${encryptedText}'. Took: ${time}ms`
            // );

            // console.log(
            //     `Encrypted and signed: '${encryptedText}'. Took: ${time}ms`
            // );
        } catch (err) {
            this.log(`Failed encrypting and signing: ${err}`);
            reject();
        }

        resolve(encryptedText);
    });
}
