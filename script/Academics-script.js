// Function to check for changes in queue data
let previousCourseQueueNumbers = {};

function checkQueueData() {
    $.ajax({
        url: 'display_queue.php',
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            // Iterate over each course
            $('.main-container .list-div').each(function () {
                const course = $(this).find('p b').text();
                const currentQueueNumbers = [];

                // Get the current queue numbers for the course
                $(this).find('.qn-div').each(function () {
                    currentQueueNumbers.push($(this).data('queue-number'));
                });

                // Compare the current queue numbers with the previous ones
                if (!arraysEqual(currentQueueNumbers, previousCourseQueueNumbers[course])) {
                    // Queue numbers have changed for this course, play audio
                    audio.play();
                }

                // Update the previous queue numbers for this course
                previousCourseQueueNumbers[course] = currentQueueNumbers;
                console.log(currentQueueNumbers);
            });

            // Update the container with the new data
            $('.main-container').html(data);
        }
    });
}

// Set up an interval to periodically check for changes
setInterval(checkQueueData, 1000);

// Play audio on button click
document.getElementById('playButton').addEventListener('click', () => {
    audio.play();
});

// Function to compare two arrays
function arraysEqual(arr1, arr2) {
    return JSON.stringify(arr1) === JSON.stringify(arr2);
}

// Initialize audio
const audio = new Audio('../queue/sound/queue_notification.mp3');
