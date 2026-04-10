<div x-data="{ 
        notifications: [], 
        add(e) { 
            const id = Date.now();
            this.notifications.push({
                id: id,
                type: e.detail.type || 'info',
                message: e.detail.message,
            });
            setTimeout(() => {
                this.notifications = this.notifications.filter(n => n.id !== id);
            }, 5000);
        } 
    }" 
    @notify.window="add($event)"
    class="fixed top-4 right-4 z-[100] flex flex-col gap-2 w-full max-w-sm pointer-events-none">
    
    <template x-for="n in notifications" :key="n.id">
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="pointer-events-auto flex items-center p-4 rounded-lg shadow-lg border-l-4"
             :class="{
                'bg-green-50 border-green-500 text-green-800': n.type === 'success',
                'bg-red-50 border-red-500 text-red-800': n.type === 'error',
                'bg-blue-50 border-blue-500 text-blue-800': n.type === 'info',
                'bg-yellow-50 border-yellow-500 text-yellow-800': n.type === 'warning'
             }">
            <div class="flex-shrink-0">
                <template x-if="n.type === 'success'">
                    <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
                <template x-if="n.type === 'error'">
                    <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </template>
            </div>
            <div class="ml-3 text-sm font-medium" x-text="n.message"></div>
            <div class="ml-auto pl-3">
                <button @click="notifications = notifications.filter(i => i.id !== n.id)" class="inline-flex rounded-md p-1.5 focus:outline-none">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </template>
</div>
