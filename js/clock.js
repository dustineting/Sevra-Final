// Live Clock
function updateClock() {
    const now = new Date();

    // Time
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    minutes = minutes.toString().padStart(2, '0');
    document.getElementById('clockTime').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;

    // Date with Ordinal Suffix
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const day = now.getDate();
    const suffix = (d) => {
        if (d >= 11 && d <= 13) return 'th';
        switch (d % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
            default: return 'th';
        }
    };
    document.getElementById('clockDate').textContent =
        `${days[now.getDay()]}, ${day}${suffix(day)} of ${months[now.getMonth()]}, ${now.getFullYear()}`;
}

updateClock();
setInterval(updateClock, 1000);