const toggleButton = document.querySelector('#mode-toggle-button');
const divToggleButton = document.querySelector('#mode');
const body = document.body;

toggleButton.addEventListener('click', () => {
    const currentText = toggleButton.textContent;

    if (currentText === 'Mode Light') {
        toggleButton.textContent = 'Dark Mode';
    } else {
        toggleButton.textContent = 'Light Mode';
    }
    body.classList.toggle('light-mode');
    body.classList.toggle('dark-mode');
    divToggleButton .classList.toggle('light-mode');
    divToggleButton.classList.toggle('dark-mode');
    toggleButton.classList.toggle('light-mode');
    toggleButton.classList.toggle('dark-mode');
});