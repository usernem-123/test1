document.getElementById('addButton').addEventListener('click', function() {
    const fileInput = document.getElementById('fileInput');
    const playlist = document.getElementById('playlist');
    const audioPlayer = document.getElementById('audioPlayer');

    const files = fileInput.files;

    // Clear the playlist before adding new items
    playlist.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const listItem = document.createElement('li');
        listItem.textContent = file.name;

        // Create a URL for the audio file
        const audioURL = URL.createObjectURL(file);

        // Add click event to play the audio
        listItem.addEventListener('click', function() {
            audioPlayer.src = audioURL;
            audioPlayer.play();
        });

        playlist.appendChild(listItem);
    }

    // Clear the file input
    fileInput.value = '';
});