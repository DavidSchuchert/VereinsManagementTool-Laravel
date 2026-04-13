<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/80 transition-opacity" aria-hidden="true" wire:click="$set('showModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                {{ $protokollId ? 'Protokoll bearbeiten' : 'Neues Protokoll' }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Titel</label>
                                    <input type="text" wire:model="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Inhalt</label>

                                        <div x-data="{
                                            init() {
                                                if (this.quillInstance) return;
                                                
                                                // Clean up any orphaned toolbars from previous Livewire states
                                                const existingToolbar = this.$el.querySelector('.ql-toolbar');
                                                if (existingToolbar) existingToolbar.remove();

                                                this.quillInstance = new Quill(this.$refs.quillEditor, {
                                                    theme: 'snow',
                                                    modules: {
                                                        toolbar: [
                                                            [{ 'header': [1, 2, 3, false] }],
                                                            ['bold', 'italic', 'underline', 'strike'],
                                                            [{ 'color': [] }, { 'background': [] }],
                                                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                                            ['link', 'clean']
                                                        ]
                                                    }
                                                });
                                                
                                                // Initialize content
                                                this.quillInstance.root.innerHTML = $wire.content || '';
                                                
                                                // Listen for changes and set Livewire state (deferred)
                                                this.quillInstance.on('text-change', () => {
                                                    $wire.content = this.quillInstance.root.innerHTML;
                                                });

                                                // Update if Livewire resets it externally
                                                this.$watch('$wire.content', value => {
                                                    if(this.quillInstance.root.innerHTML !== value) {
                                                        this.quillInstance.root.innerHTML = value || '';
                                                    }
                                                });
                                            }
                                        }">
                                            <div wire:ignore>
                                                <div x-ref="quillEditor" class="bg-white min-h-[300px] text-base border-gray-300 rounded-b-md shadow-sm"></div>
                                            </div>
                                        </div>
                                    @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Speichern
                            </button>
                            <button type="button" wire:click="$set('showModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Abbrechen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
