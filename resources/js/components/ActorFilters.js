export class ActorFilters {
    constructor() {
        this.searchTimeout = null;
        this.init();
    }

    init() {
        this.setupFilterToggle();
        this.setupAudioSystem();
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

    setupAudioSystem() {
        this.currentAudio = null;
        this.currentPlayButton = null;
        this.currentPauseButton = null;

        const photoContainers = document.querySelectorAll('.photo-container');
        
        photoContainers.forEach(container => {
            const audioSrc = container.getAttribute('data-audio-src');
            
            if (audioSrc) {
                const playButton = container.querySelector('.audio-play');
                const pauseButton = container.querySelector('.audio-pause');
                
                container.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    if (this.currentPlayButton === playButton && this.currentAudio && !this.currentAudio.paused) {
                        this.pauseAudio(playButton, pauseButton);
                    } else {
                        this.playAudio(audioSrc, playButton, pauseButton);
                    }
                });
                
                if (playButton) {
                    playButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.playAudio(audioSrc, playButton, pauseButton);
                    });
                }
                
                if (pauseButton) {
                    pauseButton.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.pauseAudio(playButton, pauseButton);
                    });
                }
            }
        });

        document.addEventListener('click', () => {
            if (this.currentAudio && this.currentPlayButton && this.currentPauseButton) {
                this.pauseAudio(this.currentPlayButton, this.currentPauseButton);
            }
        });
    }

    setupFilters() {
        const searchInput = document.getElementById('searchActor');
        const filterInputs = document.querySelectorAll('#filter-form input[type="checkbox"], #filter-form input[type="radio"]');
        const clearFiltersBtn = document.getElementById('clearFilters');

        if (searchInput) {
            searchInput.addEventListener('input', () => this.applyAllFilters());
        }

        if (filterInputs.length > 0) {
            filterInputs.forEach(input => {
                input.addEventListener('change', () => this.applyAllFilters());
            });
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = clearFiltersBtn.href;
            });
        }
    }

    applyAllFilters() {
        clearTimeout(this.searchTimeout);
        
        this.searchTimeout = setTimeout(() => {
            const searchTerm = document.getElementById('searchActor')?.value.toLowerCase().trim() || '';
            const selectedAvailability = document.querySelector('input[name="availability"]:checked')?.value;
            const selectedGenders = Array.from(document.querySelectorAll('input[name="genders[]"]:checked')).map(cb => cb.value.toLowerCase());
            const selectedVoiceAges = Array.from(document.querySelectorAll('input[name="voice_ages[]"]:checked')).map(cb => cb.value.toLowerCase());
            const selectedSchools = Array.from(document.querySelectorAll('input[name="schools[]"]:checked')).map(cb => cb.value);

            this.filterActors(searchTerm, selectedAvailability, selectedGenders, selectedVoiceAges, selectedSchools);
        }, 300);
    }

    filterActors(searchTerm, selectedAvailability, selectedGenders, selectedVoiceAges, selectedSchools) {
        const actorCards = document.querySelectorAll('.actor-card');
        const noResults = document.getElementById('noResults');
        const resultsCount = document.getElementById('resultsCount');
        const paginationContainer = document.getElementById('paginationContainer');
        
        let visibleCount = 0;
        
        actorCards.forEach(card => {
            const actorName = card.getAttribute('data-name');
            const actorGenders = card.getAttribute('data-genders').split(',').map(g => g.trim().toLowerCase()).filter(g => g);
            const actorVoiceAges = card.getAttribute('data-voice-ages').split(',').map(v => v.trim().toLowerCase()).filter(v => v);
            const actorAvailable = card.getAttribute('data-available');
            const actorSchools = card.getAttribute('data-schools').split(',').map(s => s.trim()).filter(s => s);

            const matchesSearch = !searchTerm || actorName.includes(searchTerm);
            const matchesAvailability = !selectedAvailability || 
                                      (selectedAvailability === '1' && actorAvailable === 'true') ||
                                      (selectedAvailability === '0' && actorAvailable === 'false');
            const matchesGenders = selectedGenders.length === 0 || 
                                 selectedGenders.every(gender => actorGenders.includes(gender.toLowerCase()));
            const matchesVoiceAges = selectedVoiceAges.length === 0 || 
                                   selectedVoiceAges.every(age => actorVoiceAges.includes(age.toLowerCase()));
            const matchesSchools = selectedSchools.length === 0 || 
                                 selectedSchools.every(school => actorSchools.includes(school));
            
            const isVisible = matchesSearch && matchesAvailability && matchesGenders && matchesVoiceAges && matchesSchools;
            
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

    playAudio(audioSrc, playBtn, pauseBtn) {
        const globalAudio = document.getElementById('globalAudio');
        
        if (this.currentAudio && this.currentAudio !== globalAudio) {
            this.currentAudio.pause();
            if (this.currentPlayButton && this.currentPauseButton) {
                this.currentPlayButton.classList.remove('hidden');
                this.currentPauseButton.classList.add('hidden');
            }
        }
        
        globalAudio.src = audioSrc;
        globalAudio.play();
        
        playBtn.classList.add('hidden');
        pauseBtn.classList.remove('hidden');
        
        this.currentAudio = globalAudio;
        this.currentPlayButton = playBtn;
        this.currentPauseButton = pauseBtn;
        
        globalAudio.onended = () => {
            this.pauseAudio(playBtn, pauseBtn);
        };
    }

    pauseAudio(playBtn, pauseBtn) {
        const globalAudio = document.getElementById('globalAudio');
        
        if (globalAudio) {
            globalAudio.pause();
            globalAudio.currentTime = 0;
        }
        
        playBtn.classList.remove('hidden');
        pauseBtn.classList.add('hidden');
        
        this.currentAudio = null;
        this.currentPlayButton = null;
        this.currentPauseButton = null;
    }
}