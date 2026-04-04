function updateTime() {
    const clockElement = document.getElementById('real-time-clock');
    if (clockElement) {
        const now = new Date();
        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        clockElement.textContent = now.toLocaleTimeString(undefined, options);
    }
}
updateTime();
setInterval(updateTime, 1000);

