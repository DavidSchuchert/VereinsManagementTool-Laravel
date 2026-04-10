<?php

namespace App\Livewire;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentManager extends Component
{
    use WithFileUploads;

    public $files = [];
    public $title;
    public $description;
    public $search = '';

    protected $listeners = ['refresh-documents' => '$refresh'];

    public function updatedFiles()
    {
        $this->validate([
            'files.*' => 'file|max:20480', // 20MB Max
        ]);
    }

    public function save()
    {
        $this->validate([
            'files' => 'required',
            'title' => 'required|string|min:3',
        ]);

        foreach ($this->files as $file) {
            $path = $file->store('documents', 'public');

            Document::create([
                'title' => $this->title,
                'description' => $this->description,
                'uploaded_by' => Auth::id(),
                'file_path' => $path,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        $this->reset(['files', 'title', 'description']);
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Dokument(e) erfolgreich hochgeladen.'
        ]);
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        return Storage::disk('public')->download($document->file_path, $document->title);
    }

    public function delete($id)
    {
        $document = Document::findOrFail($id);
        
        // Delete physical file
        Storage::disk('public')->delete($document->file_path);
        
        // Soft delete record
        $document->delete();

        $this->dispatch('notify', [
            'type' => 'info',
            'message' => 'Dokument wurde gelöscht.'
        ]);
    }

    public function render()
    {
        $documents = Document::with('user')
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.document-manager', [
            'documents' => $documents,
        ]);
    }
}
