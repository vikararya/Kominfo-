function previewImage(event, previewId) {
    const reader = new FileReader();
    const imageElement = document.getElementById(previewId);

    reader.onload = function() {
        if (reader.readyState === 2) {
            imageElement.src = reader.result;
            imageElement.style.display = 'block'; // Tampilkan gambar
        }
    }

    reader.readAsDataURL(event.target.files[0]); // Baca file yang dipilih
}