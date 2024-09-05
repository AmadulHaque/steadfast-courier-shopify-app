(async () => {
    const request = async (url, method, data) => {
        const response = await fetch(url, {
            method: method,
            body: data,
            headers: {
                "Content-Type": "application/json",
            },
        });
        return await response.json();
    };
    const data = await request(`https://storelocator.octspace.com/widget/locations?shop=${Shopify.shop}`, "GET");
    if (data.status) {
        document.querySelector("body").insertAdjacentHTML('beforeend', data.widget)
    }
    document.addEventListener("click", function (e) {
        var parent = document.querySelector('#octSpaceLocator');
        if (parent && (parent.contains(e.target) || parent == e.target)) {
            e.preventDefault();
            e.stopPropagation();
            if (!document.querySelector('#octSpaceLocatorContent')) {
                document.body.style.overflow = "hidden";
                document.querySelector('body').insertAdjacentHTML('beforeend',
                    `<div id="octSpaceLocatorContent" style="padding:30px 50px;width:100vw;height:100vh;position:fixed;display:block;background:#f1f1f1;z-index:+999;">
                        <iframe allow="geolocation https://storelocator.octspace.com" width="100%" height="100%"
                            src="https://storelocator.octspace.com/shop/locations?shop=${Shopify.shop}" frameborder="0" style="background:white;border-radius:5px;"></iframe>
                        <span style="font-size:20px;color:black;position:absolute;right:20px;top:0px;cursor:pointer;" onclick="this.closest('#octSpaceLocatorContent').remove();document.body.style.overflow = 'scroll';">&times;</span>
                    </div>
                `)
            }
        }
    });
})();
