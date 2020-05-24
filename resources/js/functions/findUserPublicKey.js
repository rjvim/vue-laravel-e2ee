import { EThree } from "@virgilsecurity/e3kit-browser";

export default function(identities) {
    let findUsersResult = null;
    return new Promise(async (resolve, reject) => {
        try {
            findUsersResult = await eThree.findUsers(identities);
            resolve(findUsersResult);
            console.log(`Looked up ${identities}'s public key`);
        } catch (err) {
            console.log(`Failed looking up ${identities}'s public key: ${err}`);
            reject();
        }
    });
}
