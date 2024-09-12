
// От сервера требуется два endpoints/uri:
// один для получения данных ip и города,
// другой для отправки данных на сервер
const getProxyEndpoint = '/geo.php';
const sendEndpoint = '/send.php';


const getGeoData = async (proxyUri) => {
    const response = await fetch(proxyUri);
    const json = await response.json();
    return {
        ip: json.ip,
        city: json.city,
        platform: navigator.userAgent
    };
};

const sendData = async (uri, data) => {
    return await fetch(uri, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    });

}


(async () => {
    const data = await getGeoData(getProxyEndpoint);
    await sendData(sendEndpoint, data);
})();