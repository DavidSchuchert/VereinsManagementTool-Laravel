# 🏆 VereinsManagementTool v2.2 Professional

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php)
![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker)

Das **VereinsManagementTool** ist eine hochmoderne, leistungsstarke Webanwendung zur effizienten Verwaltung von Vereinen. Entwickelt mit dem neuesten Technologie-Stack von 2026, bietet es eine nahtlose Benutzererfahrung, Revisionssicherheit und ein anspruchsvolles Design.

---

## ✨ Hauptmerkmale

### 💎 Modernstes UI/UX (Glassmorphism & Tailwind 4)
*   **Next-Gen Design:** Vollständiges Redesign mit Tailwind CSS 4 für ein flüssiges, modernes Look & Feel.
*   **Responsive Experience:** Optimiert für alle Endgeräte, inklusive nativer Mobile-Navigation und Skeleton-Loadern.
*   **Echtzeit-Interaktion:** Livewire 4 ermöglicht blitzschnelle Updates ohne Seiten-Reloads.

### 📊 Intelligente Verwaltung
*   **Echtzeit-Dashboard:** Interaktive Statistiken mit ApexCharts und automatischer Aktualisierung via Laravel Echo.
*   **Stammdaten-Kontrollzentrum:** Zentrale Verwaltung von Rängen, Kategorien und Standorten mit dem neuen Lookup-Manager.
*   **Audit-Trail & Revisionssicherheit:** Lückenlose Protokollierung aller Änderungen (Activity Logs) und Benutzerzuordnung bei Finanztransaktionen.

### 📂 Dokumente & Datenaustausch
*   **Dokumenten-Manager:** Drag & Drop Uploads mit integrierter Vorschau.
*   **Import/Export-Wizard:** Effizienter Datenaustausch via Excel (Maatwebsite Excel) mit benutzerfreundlichem Wizard.
*   **PDF-Reporting:** Professionelle Berichte für Finanzen, Mitglieder und Inventar.

### 🛡️ Sicherheit & Privatsphäre
*   **Rollen & Berechtigungen:** Granulare Zugriffskontrolle durch Spatie Laravel-Permission.
*   **Privacy by Design:** Globaler Schutz vor Suchmaschinen-Indizierung (`noindex`) und restriktive SEO-Steuerung.

---

## 🛠 Technologie-Stack (Upgrade April 2026)

| Komponente | Version |
| :--- | :--- |
| **Framework** | Laravel 13.x |
| **Laufzeit** | PHP 8.4.x |
| **Frontend** | Tailwind CSS 4.0 / Vite 8.0 |
| **Reaktivität** | Livewire 4.x / Alpine.js 3.15+ |
| **Infrastruktur** | Docker & Docker Compose |

---

## 🚀 Installation & Schnellstart

### 🐳 Docker (Empfohlen)

1.  **Repository klonen:**
    ```bash
    git clone https://github.com/dein-repo/VereinsManagementTool.git
    cd VereinsManagementTool
    ```

2.  **Container starten:**
    ```bash
    docker-compose up -d --build
    ```

3.  **Anwendung initialisieren:**
    ```bash
    docker-compose exec app php artisan migrate --seed
    docker-compose exec app php artisan storage:link
    ```

4.  **Zugriff:**
    Die Anwendung ist nun unter `http://localhost:8181` erreichbar.

### 🔑 Standard-Login
*   **Benutzer:** `admin@admin`
*   **Passwort:** `admin`

---

## 📜 Versionshistorie (Changelog)

### [v2.2.0] - Cutting Edge Upgrade (2026-04-13)
*   **Framework:** Upgrade auf **Laravel 13** und **PHP 8.4**.
*   **Frontend:** Umstellung auf **Tailwind CSS 4** und **Vite 8**.
*   **Livewire:** Upgrade auf **Livewire 4**.
*   **Charts:** Refactoring der ApexCharts-Integration (jetzt nativ via JS für bessere Performance).
*   **Refactoring:** PSR-4 Namespace-Korrekturen und Bereinigung veralteter Paket-Referenzen.

### [v2.1.0] - Master Data & Auditability (2026-04-10)
*   **Setup 2.0:** Neues tab-basiertes Kontrollzentrum für Stammdaten.
*   **Finanz-Audit:** Einführung der `user_id` für alle Zahlungen (Nachverfolgbarkeit).
*   **Strukturierte Standorte:** Umstellung von Freitext auf kategorisierte Stammdaten.
*   **Privacy:** Implementierung von globalem `noindex` und `robots.txt`.

### [v2.0.0] - Premium UI & Feature Upgrade
*   Einführung des Glassmorphism-Designs.
*   Implementierung des zentralen FilterService.
*   Integration von Echtzeit-Statistiken via Laravel Echo.

---

## 👨‍💻 Autor & Lizenz

Entwickelt von **David Schuchert**.
Dieses Projekt ist unter der MIT-Lizenz lizenziert.

---
**LIVE-DEMO:** [https://verein.david-schuchert.de/](https://verein.david-schuchert.de/)
