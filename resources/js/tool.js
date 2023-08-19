let inactivityTime = function () {
    let time;
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.keydown = resetTimer;

    function lock() {
        Nova.request()
            .get(Nova.config('nls')['lock_url'])
            .then((res) => {
                if (res.data.locked) {
                    window.location.href = res.data.url
                }
            });
    }
    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(lock, Nova.config("nls")["lock_timeout"])
    }
};
window.onload = function () {
    inactivityTime();
}
