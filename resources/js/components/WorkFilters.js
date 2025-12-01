export class WorkFilters {
    constructor() {
        this.searchTimeout = null;
        this.init();
    }

    init() {
        this.setupFilterToggle();
        this.setupFilters();
        this.applyAllFilters();
    }

    setupFilterToggle() {
        const filterToggle = document.getElementById('filterToggle');
        const filterColumn = document.getElementById('filterColumn');
        const closeFilters = document.getElementById('closeFilters');

        if (filterToggle && filterColumn) {
            filterToggle.addEventListener('click', () => {
                filterColumn.classList.toggle('hidden');
                filterToggle.innerHTML = filterColumn.classList.contains('hidden') 
                    ? '<i class="fas fa-filter mr-2"></i>Mostrar Filtros'
                    : '<i class="fas fa-times mr-2"></i>Ocultar Filtros';
            });
        }

        if (closeFilters) {
            closeFilters.addEventListener('click', () => {
                filterColumn.classList.add('hidden');
                filterToggle.innerHTML = '<i class="fas fa-filter mr-2"></i>Mostrar Filtros';
            });
        }
    }

    setupFilters() {
        const searchInput = document.getElementById('searchWork');
        const typeFilters = document.querySelectorAll('.type-filter');
        const yearFilter = document.getElementById('yearFilter');
        const actorsCountFilter = document.getElementById('actorsCountFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');

        if (searchInput) {
            searchInput.addEventListener('input', () => this.applyAllFilters());
        }

        if (typeFilters.length > 0) {
            typeFilters.forEach(filter => {
                filter.addEventListener('change', () => this.applyAllFilters());
            });
        }

        if (yearFilter) {
            yearFilter.addEventListener('input', () => this.applyAllFilters());
        }

        if (actorsCountFilter) {
            actorsCountFilter.addEventListener('change', () => this.applyAllFilters());
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', () => {
                searchInput.value = '';
                yearFilter.value = '';
                actorsCountFilter.value = '';
                typeFilters.forEach(filter => {
                    filter.checked = false;
                });
                this.applyAllFilters();
            });
        }
    }

    applyAllFilters() {
        clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            const searchTerm = document.getElementById('searchWork')?.value.toLowerCase().trim() || '';
            const selectedTypes = Array.from(document.querySelectorAll('.type-filter:checked')).map(cb => cb.value);
            const selectedYear = document.getElementById('yearFilter')?.value;
            const selectedActorsCount = document.getElementById('actorsCountFilter')?.value;

            this.filterWorks(searchTerm, selectedTypes, selectedYear, selectedActorsCount);
        }, 300);
    }

    filterWorks(searchTerm, selectedTypes, selectedYear, selectedActorsCount) {
        const workCards = document.querySelectorAll('.work-card');
        const noResults = document.getElementById('noResults');
        const resultsCount = document.getElementById('resultsCount');
        const paginationContainer = document.getElementById('paginationContainer');
        
        let visibleCount = 0;
        
        workCards.forEach(card => {
            const workTitle = card.getAttribute('data-title');
            const workType = card.getAttribute('data-type');
            const workYear = parseInt(card.getAttribute('data-year')) || 0;
            const workActorsCount = parseInt(card.getAttribute('data-actors-count'));

            const matchesSearch = !searchTerm || workTitle.includes(searchTerm);
            const matchesTypes = selectedTypes.length === 0 || 
                               selectedTypes.every(type => workType === type);
            const matchesYear = !selectedYear || workYear >= parseInt(selectedYear);
            const matchesActorsCount = !selectedActorsCount || workActorsCount >= parseInt(selectedActorsCount);

            const isVisible = matchesSearch && matchesTypes && matchesYear && matchesActorsCount;
            
            if (isVisible) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        resultsCount.textContent = visibleCount;
        
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            paginationContainer.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            paginationContainer.classList.remove('hidden');
        }
    }
}