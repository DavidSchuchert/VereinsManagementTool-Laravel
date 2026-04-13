import './bootstrap';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

// Livewire 3 will automatically start Alpine if it's not already started.
// However, if we are on a non-Livewire page, we must start it manually.
if (!window.livewire_started) {
    Alpine.start();
}
