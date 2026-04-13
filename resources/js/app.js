import './bootstrap';
import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

// Use the Alpine instance bundled with Livewire 3
document.addEventListener('livewire:init', () => {
    console.log('[LIVEWIRE] Initialized');
    
    // Debug: Monitor all Livewire events
    Livewire.on('*', ({ name, params }) => {
        console.log(`[LIVEWIRE] Event received: ${name}`, params);
    });
});


