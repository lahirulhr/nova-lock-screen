import Tool from "./pages/Tool";

Nova.booting((app, store) => {
  Nova.inertia("NovaLockscreen", Tool);
});

setInterval(function () {
  if (
    Nova.config("nls")["enabled"] &&
    !Nova.config("nls")["excluded_urls"].includes(
      window.location.pathname.slice(1)
    )
  ) {
    Nova.request()
      .get("/nova/nova-lockscreen/check")
      .then((res) => {
        Nova.visit(res.data.url);
      });
  }
}, 3000);
