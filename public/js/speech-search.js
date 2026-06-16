// Speech-to-Text for Search (Dashboard + Search Page)

document.addEventListener('DOMContentLoaded', function () {

    const voiceSearchBtn = document.getElementById('voiceSearchBtn');
    const searchInput = document.getElementById('homeSearchInput');
    const searchForm = document.getElementById('homeSearchForm');
    const submitBtn = document.getElementById('submitSearchBtn');

    if (!voiceSearchBtn || !searchInput || !searchForm) return;

    if (!('webkitSpeechRecognition' in window)) {
        console.log("Speech recognition not supported in this browser.");
        return;
    }

    const recognition = new webkitSpeechRecognition();

    recognition.continuous = false;
    recognition.interimResults = false;

    recognition.lang =
        document.documentElement.lang === 'ar'
            ? 'ar-LY'
            : 'en-US';
    voiceSearchBtn.addEventListener('click', () => {
        recognition.start();
    });

    recognition.onstart = () => {
        voiceSearchBtn.innerHTML =
            '<i class="fa-solid fa-microphone-lines text-red-500"></i>';
    };
    recognition.onend = () => {
        voiceSearchBtn.innerHTML =
            '<i class="fa-solid fa-microphone"></i>';
    };

    recognition.onresult = (event) => {

        const transcript = event.results[0][0].transcript;

        searchInput.value = transcript;
        voiceSearchBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');

        searchForm.submit();
    };

    recognition.onerror = (event) => {
        console.log("Speech recognition error:", event.error);
    };

});