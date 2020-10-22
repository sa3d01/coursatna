export async function fetchData(url) {
    return axios.get(url).then(data => {
        return data.data;
    });
}
