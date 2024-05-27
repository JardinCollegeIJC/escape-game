document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('codeForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const correctCode = 'BONJOURCODECESAR'; // Code correct en majuscules
        const userInput = document.getElementById('codeInput').value.toUpperCase().replace(/\s+/g, '');
        const resultMessage = document.getElementById('resultMessage');
        
        if (userInput === correctCode) {
            resultMessage.textContent = 'Code correct !';
            resultMessage.style.color = 'green';
            saveProgress(true);
        } else {
            resultMessage.textContent = 'Code incorrect !';
            resultMessage.style.color = 'red';
        }
    });

    function saveProgress(isValid) {
        fetch('update_saves.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ epreuve1: isValid })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Progress saved successfully.');
            } else {
                console.error('Error saving progress:', data.message);
            }
        })
        .catch(error => console.error('Fetch error:', error));
    }
});
