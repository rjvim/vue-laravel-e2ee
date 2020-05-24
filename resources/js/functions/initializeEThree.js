import { EThree } from "@virgilsecurity/e3kit-browser";

export default function(token) {
    return EThree.initialize(() => {
        return token;
    }).then(response => {
        return response;
    });
}
