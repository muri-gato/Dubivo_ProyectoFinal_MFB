import './bootstrap';

console.log('✅ app.js cargado');

// Función simple para inicializar componentes
function initComponents() {
    console.log('🔧 Inicializando componentes...');
    
    // ActorFilters se auto-inicializa en su propio archivo
    // No necesitamos importarlo dinámicamente si ya está en la página
    
    // Verificar si estamos en página de actor
    if (document.querySelector('form[action*="actors"]')) {
        console.log('📝 Detectada página de edición de actor');
        // El scroll ya funciona con CSS, no necesita JS
    }
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initComponents);
} else {
    initComponents();
}