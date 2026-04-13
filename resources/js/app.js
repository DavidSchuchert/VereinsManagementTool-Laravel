import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

// In Livewire 3, Alpine is handled automatically. 
// We only need to start it if Livewire is not present on the page.
document.addEventListener('livewire:init', () => {
    // Livewire 3 handles Alpine.start() automatically.
});

