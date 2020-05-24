import { EThree } from "@virgilsecurity/e3kit-browser";

export default function(text, senderPublicKey) {
    return new Promise(async (resolve, reject) => {
        let benchmarking = false;
        let decryptedText = null;
        let repetitions = benchmarking ? 100 : 1;

        const then = new Date();
        try {
            for (let i = 0; i < repetitions; i++) {
                decryptedText = await eThree.authDecrypt(text);
            }
            let time = (new Date() - then) / repetitions;
            // console.log(
            //     `Encrypted and signed: '${decryptedText}'. Took: ${time}ms`
            // );

            // console.log(
            //     `Encrypted and signed: '${decryptedText}'. Took: ${time}ms`
            // );
        } catch (err) {
            console.log(`Failed decrypting and signing: ${err}`);
            reject();
        }

        resolve(decryptedText);
    });
}
