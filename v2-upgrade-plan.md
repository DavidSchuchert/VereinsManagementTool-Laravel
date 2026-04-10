# v2 Upgrade Plan

## Updated Features List (after your input)

### Core Features (Already in v1)
- User management (CRUD)
- Member management (CRUD) with Rangart (ranks)
- Inventory management (CRUD)
- Payment/Transaction management (CRUD) with Zahlungsart (payment methods)
- Protocol/Minutes management (CRUD)
- Profile management (Laravel Breeze)
- Setup (club name, logo via Setting model)
- Dashboard with ApexCharts
- PDF exports via DomPDF
- Soft deletes
- Search/filtering

### v2 Features (Added)

#### Phase 1 - Foundation & Refactoring (In Progress)
- ✅ Install Livewire
- ✅ Install Spatie Permission
- ✅ Create Category model for inventory categorization
- 🔄 Refactor Settings service
- ✅ Implement unified filtering pipeline (FilterService)

#### Phase 2 - Reactive Overhaul
- ✅ Convert index pages to Livewire components (Members, Inventory, Payments)
- ✅ "Search-as-you-type" functionality (All main modules)
- ✅ Modal/slide-over CRUD forms (All main modules)

#### Phase 3 - Module Expansion
- Document Management (Media Library)
- Event & Attendance module
- Import/Export wizard (Excel/CSV)

#### Phase 4 - Polish
- ✅ Real-time dashboard stats (Livewire + ApexCharts)
- ✅ Alpine.js UI Components (Dropdowns, Slide-overs, Toasts)
- 🔄 UI/UX polish + mobile responsiveness

## Important Notes
- ⚠️ **NO DATA DELETION** - All migrations ADD columns, never remove them
- ⚠️ Always backup database before migrations
- ⚠️ Test on staging first if possible
