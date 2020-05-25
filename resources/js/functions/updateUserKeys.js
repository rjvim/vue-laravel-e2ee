export default function(payload) {
    return axios
        .post("api/update-user-keys", payload)
        .then(response => {
            return response.data;
        })
        .catch(error => {
            return error;
        });
}
