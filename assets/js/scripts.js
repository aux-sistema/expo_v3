document.addEventListener('DOMContentLoaded', () => {
    const facturaSwitch = document.getElementById('facturaSwitch');
    const facturaFields = document.getElementById('facturaFields');
    
    if (facturaSwitch && facturaFields) {
        facturaSwitch.addEventListener('change', () => {
            facturaFields.style.display = facturaSwitch.checked ? 'block' : 'none';
        });
    }
});