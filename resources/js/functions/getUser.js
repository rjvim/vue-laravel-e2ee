export default function() {
    return axios
        .get("api/user")
        .then(response => {
            return response.data;
        })
        .catch(error => {
            return error;
        });
}
