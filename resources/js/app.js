import './bootstrap';
document.addEventListener('DOMContentLoaded', function() {
    const testMode = 'day'; // Variable de prueba para cambiar el modo (puede ser 'day' o 'night')

    // Función para cambiar entre modo día y noche
    function setMode() {
        const hour = new Date().getHours();
        const bodyClass = (hour >= 7 && hour <= 19) ? 'day-mode' : 'night-mode';

        // Usar variable de prueba para establecer el modo
        document.body.classList.add(testMode === 'day' ? 'day-mode' : 'night-mode');
    }

    // Llama a la función para establecer el modo
    setMode();
});
