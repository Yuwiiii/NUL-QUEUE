// For DATE AND TIME
function updateTime() {
    const dateElement = document.getElementById('date');
    const timeElement = document.getElementById('time');

    const now = new Date();

    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    const formattedDate = now.toLocaleDateString('en-US', options).toUpperCase();

    const hours = now.getHours();
    const formattedHours = hours >= 12 ? hours % 12 : hours; // Convert to 12-hour format

    // Ensure that 0 is displayed as 12 for midnight
    const displayHours = formattedHours === 0 ? 12 : formattedHours;

    const minutes = now.getMinutes(); // Get the minutes
    const ampm = hours >= 12 ? 'pm' : 'am';
    const formattedTime = `${displayHours}:${minutes.toString().padStart(2, '0')}${ampm}`;

    // Update the elements with the formatted date and time
    dateElement.textContent = formattedDate;
    timeElement.textContent = formattedTime;
}

// Update the time immediately and then every second
updateTime();
setInterval(updateTime, 1000);