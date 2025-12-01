export class SchoolFilters {
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
        const searchInput = document.getElementById('searchSchool');
        const cityFilters = document.querySelectorAll('.city-filter');
        const yearFilter = document.getElementById('yearFilter');
        const actorsCountFilter = document.getElementById('actorsCountFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');

        if (searchInput) {
            searchInput.addEventListener('input', () => this.applyAllFilters());
        }

        if (cityFilters.length > 0) {
            cityFilters.forEach(filter => {
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
                cityFilters.forEach(filter => {
                    filter.checked = false;
                });
                this.applyAllFilters();
            });
        }
    }

    applyAllFilters() {
        clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            const searchTerm = document.getElementById('searchSchool')?.value.toLowerCase().trim() || '';
            const selectedCities = Array.from(document.querySelectorAll('.city-filter:checked')).map(cb => cb.value.toLowerCase());
            const selectedYear = document.getElementById('yearFilter')?.value;
            const selectedActorsCount = document.getElementById('actorsCountFilter')?.value;

            this.filterSchools(searchTerm, selectedCities, selectedYear, selectedActorsCount);
        }, 300);
    }

    filterSchools(searchTerm, selectedCities, selectedYear, selectedActorsCount) {
        const schoolCards = document.querySelectorAll('.school-card');
        const noResults = document.getElementById('noResults');
        const resultsCount = document.getElementById('resultsCount');
        const paginationContainer = document.getElementById('paginationContainer');
        
        let visibleCount = 0;
        
        schoolCards.forEach(card => {
            const schoolName = card.getAttribute('data-name');
            const schoolCity = card.getAttribute('data-city').toLowerCase();
            const schoolYear = card.getAttribute('data-year');
            const schoolActorsCount = parseInt(card.getAttribute('data-actors-count'));

            const matchesSearch = !searchTerm || schoolName.includes(searchTerm);
            const matchesCities = selectedCities.length === 0 || 
                                 selectedCities.every(city => schoolCity === city.toLowerCase());
            const matchesYear = !selectedYear || 
                              (schoolYear && parseInt(schoolYear) >= parseInt(selectedYear));
            const matchesActorsCount = !selectedActorsCount || 
                                     schoolActorsCount >= parseInt(selectedActorsCount);
            
            const isVisible = matchesSearch && matchesCities && matchesYear && matchesActorsCount;
            
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