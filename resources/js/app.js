import './bootstrap';

// Cargar todos los componentes
Promise.all([
    import('./components/ActorFilters.js'),
    import('./components/SchoolFilters.js'), 
    import('./components/WorkFilters.js')
]).then(([actorModule, schoolModule, workModule]) => {
    // Guardar en window para acceso global
    window.ActorFilters = actorModule.ActorFilters;
    window.SchoolFilters = schoolModule.SchoolFilters;
    window.WorkFilters = workModule.WorkFilters;
    
    // Inicializar componentes
    initializeComponents();
}).catch(error => {
    console.error('Error cargando componentes:', error);
});

function initializeComponents() {
    // Actores
    if (document.getElementById('actorsContainer') && window.ActorFilters) {
        new window.ActorFilters();
    }
    
    // Escuelas
    if (document.getElementById('schoolsContainer') && window.SchoolFilters) {
        new window.SchoolFilters();
    }
    
    // Obras
    if (document.getElementById('worksContainer') && window.WorkFilters) {
        new window.WorkFilters();
    }
}

// Inicializar si el DOM ya está listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeComponents);
} else {
    initializeComponents();
}