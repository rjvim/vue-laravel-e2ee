export default function() {
    return axios
        .get("api/virgil-token")
        .then(response => {
            return response.data;
        })
        .catch(error => {
            return error;
        });
}
