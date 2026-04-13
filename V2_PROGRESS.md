# VereinsManagementTool v2 - Statusbericht

## ✅ Erledigt am 10. April 2026

### 1. Architektur & Modernisierung
- **Livewire Integration:** Alle Haupt-Listen (Mitglieder, Inventar, Zahlungen) auf Livewire umgestellt (reaktiv, ohne Page-Reload).
- **Zentraler FilterService:** Logik für Suche, Status, Datum und Dropdowns vereinheitlicht.
- **CRUD 2.0:** Umstellung von statischen Popups auf konsistente Alpine.js Slide-overs (rechts) für alle Module.
- **Real-time Dashboard:** Statistiken mit ApexCharts und automatischem Refresh via Polling/Echo vorbereitet.

### 2. Neue Module
- **Dokumenten-Management:** Upload (Drag & Drop), Vorschau und Verwaltung von PDFs/Bildern.
- **Event & Attendance:** Veranstaltungsplanung mit Teilnehmer-Registrierung und Anwesenheits-Tracking.
- **Import/Export Wizard:** Excel/CSV Schnittstelle für Mitglieder, Inventar und Protokolle.

### 3. Datenbank & Sicherheit
- **Spatie Permissions:** Rollen-System (Admin, Manager, Member) und Gates konfiguriert.
- **Audit Trail:** Automatisches Logging aller Änderungen (Wer, Was, Wann, IP) via `LogsActivity` Trait.
- **DB-Optimierung:** Konsistente SoftDeletes überall und Performance-Indizes auf allen Suchspalten.

### 4. UI/UX & Mobile
- **Tailwind Modernisierung:** Custom Brand Colors, Soft-Shadows und Animationen.
- **Mobile First:** Neues Hamburger-Menü und responsive Card-Layouts für Listen.
- **Feedback-System:** Globale Toast-Benachrichtigungen für alle Aktionen.

---

## 🛠 Offene Punkte für morgen (Next Steps)

### 1. Frontend Asset Build (Priorität 1)
- **Problem:** Die Feature-Tests schlagen fehl, weil das `Vite manifest` fehlt (`npm run build` wurde noch nicht ausgeführt).
- **Lösung:** Node.js im PHP-Container installieren oder Assets auf dem Host bauen und in den Container mounten.

### 2. Test-Coverage
- **Factories:** Weitere Factories für `Mitglied`, `Inventar` und `Event` erstellen, um die Datenbank-Tests vollständig zu automatisieren.
- **Livewire Tests:** Dedizierte Tests für die neuen Komponenten schreiben (z.B. `DocumentManagerTest`).

### 3. Refactoring "Protokolle" & "Einstellungen"
- Die Protokoll-Ansicht nutzt noch teilweise das alte Controller-System. Diese sollten ebenfalls vollständig in das neue Livewire-CRUD-Muster (Slide-over) überführt werden.

---

## ⚙️ Docker Info
- **Container:** `vereinsmanagement-php` und `vereinsmanagement-db` laufen.
- **DB:** MariaDB ist vollständig migriert und mit Rollen besiedelt.
- **Env:** `.env` ist auf Container-Kommunikation optimiert.
