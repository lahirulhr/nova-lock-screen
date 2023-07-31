import Tool from "./pages/Tool";

Nova.booting((app, store) => {
    Nova.inertia("NovaLockscreen", Tool);
});

setInterval(function () {
    if (
        Nova.config("nls")["enabled"] &&
        !Nova.config("nls")["excluded_urls"].includes(
            "/" + window.location.pathname.slice(1)
        )
    ) {
        Nova.request()
            .get(Nova.config('nls')['polling_url'])
            .then((res) => {
                if(res.data.locked){
                    Nova.visit(res.data.url)
                }
            });
    }
}, Nova.config("nls")["polling_timeout"]);
