<?php

namespace App\Livewire;

use App\Exports\MembersExport;
use App\Exports\InventarExport;
use App\Exports\ProtokollExport;
use App\Imports\MembersImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ImportExportWizard extends Component
{
    use WithFileUploads;

    public $activeTab = 'export'; // 'export', 'import'
    public $selectedEntity = 'members'; // 'members', 'inventory', 'protocols'
    public $importFile;
    public $importPreview = [];
    public $isProcessing = false;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->reset(['importFile', 'importPreview', 'isProcessing']);
    }

    public function export()
    {
        $filename = $this->selectedEntity . '_' . now()->format('Y-m-d_H-i') . '.xlsx';

        switch ($this->selectedEntity) {
            case 'members':
                return Excel::download(new MembersExport, $filename);
            case 'inventory':
                return Excel::download(new InventarExport, $filename);
            case 'protocols':
                return Excel::download(new ProtokollExport, $filename);
        }
    }

    public function updatedImportFile()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv,xls|max:10240',
        ]);

        // Simple preview (first 5 rows) - logic depends on package being installed
        // Since we can't run it now, we prepare the structure
        $this->importPreview = [
            ['Mitgliedsnummer', 'Vorname', 'Nachname', 'Email'],
            ['Vorschau aktiv nach Installation...', '...', '...', '...']
        ];
    }

    public function startImport()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,csv,xls|max:10240',
        ]);

        $this->isProcessing = true;

        try {
            if ($this->selectedEntity === 'members') {
                Excel::import(new MembersImport, $this->importFile);
                
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'Import erfolgreich abgeschlossen.'
                ]);
                $this->dispatch('refresh-member-list');
            } else {
                $this->dispatch('notify', [
                    'type' => 'warning',
                    'message' => 'Import für diese Kategorie noch nicht implementiert.'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Fehler beim Import: ' . $e->getMessage()
            ]);
        }

        $this->isProcessing = false;
        $this->reset(['importFile', 'importPreview']);
    }

    public function render()
    {
        return view('livewire.import-export-wizard');
    }
}
