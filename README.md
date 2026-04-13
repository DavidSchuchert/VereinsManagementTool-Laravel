# 🚀 VereinsManagementTool (VMT) - Professional Open Source

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Tailwind 4](https://img.shields.io/badge/TailwindCSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![License MIT](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

Das **VereinsManagementTool** ist eine hochmoderne Webanwendung zur Verwaltung von Vereinsmitgliedern, Finanzen, Inventar und Protokollen. In der aktuellen Version 2.2 wurde das System vollständig modernisiert und bietet eine intuitive Benutzeroberfläche sowie maximale Revisionssicherheit.

---

## ✨ Hauptmerkmale

*   💎 **Premium UI/UX:** Elegantes Glassmorphism-Design mit Tailwind CSS 4.
*   📊 **Echtzeit-Statistiken:** Interaktive Dashboards via Livewire 4 und ApexCharts.
*   🛡️ **Revisionssicherheit:** Lückenloser Audit-Trail (Aktivitätsprotokoll) und Benutzerzuordnung bei Finanzen.
*   👥 **Mitgliederverwaltung:** Digitale Akten, Rang-Management und Status-Tracking.
*   💰 **Finanzmanagement:** Einnahmen/Ausgaben-Journal mit automatischem PDF-Export.
*   📦 **Inventarverwaltung:** Strukturierte Lagerstandorte und Kategorien.
*   📄 **Dokumenten-Manager:** Zentraler Speicher für Satzungen und Verträge via Drag & Drop.

---

## 🌐 Live-Erlebnis (Demo)

Überzeuge dich selbst von der Geschwindigkeit und Eleganz des Systems! Wir haben eine voll funktionsfähige Demo-Umgebung bereitgestellt, in der du alle Premium-Features in Echtzeit testen kannst.

✨ **[JETZT DIE LIVE-DEMO STARTEN](https://verein.david-schuchert.de/)** ✨

**Login-Daten für die Demo:**
*   **E-Mail:** `admin@admin`
*   **Passwort:** `admin`

*Erlebe das flüssige Glassmorphism-Design und die blitzschnellen Livewire-Interaktionen direkt im Browser.*

---

## 📥 Installation & Setup

### Voraussetzungen
*   **PHP >= 8.4** (mit BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML Erweiterungen)
*   **Composer** (PHP Package Manager)
*   **MySQL 8.0+** oder **MariaDB 10.11+**
*   **Node.js & NPM** (für den Asset-Build)

### Setup-Schritte

1.  **Repository klonen:**
    ```bash
    git clone https://github.com/dein-repo/vereinsverwaltung-laravel.git
    cd vereinsverwaltung-laravel
    ```

2.  **Abhängigkeiten installieren:**
    ```bash
    composer install --no-dev --optimize-autoloader
    npm install
    npm run build
    ```

3.  **Umgebung konfigurieren:**
    Kopiere die Beispiel-Datei und passe sie an:
    ```bash
    cp .env.example .env
    ```
    **Wichtige Felder in der `.env`:**
    *   `APP_URL`: Die URL deiner Installation (z.B. `http://verein.test`).
    *   `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Deine Datenbank-Zugangsdaten.

4.  **Datenbank & App initialisieren:**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    php artisan storage:link
    ```

## 🔄 Upgrade-Anleitung (von v1 / v2.x auf v2.2)

Wenn du bereits eine ältere Version nutzt, befolge diese Schritte für ein reibungsloses Update auf den neuesten Tech-Stack:

1.  **Code aktualisieren:** `git pull` ausführen.
2.  **Abhängigkeiten erneuern:**
    Führe die folgenden Befehle nacheinander aus:
    ```bash
    composer install --no-dev --optimize-autoloader
    npm install
    npm run build
    ```
3.  **Datenbank migrieren:** `php artisan migrate --force`
4.  **Caches leeren:**
    ```bash
    php artisan optimize:clear
    ```

---

## 🔑 Standard-Zugangsdaten (nach Neu-Installation)

Nach einer frischen Installation mit dem Befehl `--seed` kannst du dich mit folgenden Daten anmelden:

*   **E-Mail:** `admin@admin`
*   **Passwort:** `admin`

*🔴 **WICHTIG:** Aus Sicherheitsgründen musst du diese Zugangsdaten **sofort** nach dem ersten Login ändern! Klicke dazu oben rechts auf deinen Namen und wähle den Bereich **"Profil"**. Dort kannst du sowohl deine E-Mail-Adresse als auch dein Passwort sicher aktualisieren.*

---

## 📜 Versionshistorie (Changelog v1 ➔ v2.2)

Das System wurde von Grund auf neu konzipiert. Hier sind die wichtigsten Änderungen im Vergleich zur klassischen v1:

### [v2.2.0] - The 2026 Update (Aktuell)
*   **Core:** Upgrade auf **Laravel 13** und **PHP 8.4**.
*   **Frontend:** Umstellung auf **Tailwind CSS 4.0** (Engine-Rewrite) und **Vite 8.0**.
*   **Reaktivität:** Upgrade auf **Livewire 4** für noch flüssigere Interaktionen.
*   **Performance:** Refactoring der Charts (native JS-Integration statt PHP-Wrapper).

### [v2.1.0] - Stammdaten & Revision
*   **Zentrales Setup:** Neues Kontrollzentrum für Ränge, Kategorien und Standorte.
*   **Finanz-Audit:** Jede Transaktion wird nun fest mit dem erfassenden Benutzer verknüpft.
*   **Lager-Struktur:** Umstellung von Freitext-Standorten auf eine gesicherte Auswahl via Stammdaten.
*   **Privacy:** Globaler Schutz vor Suchmaschinen-Indizierung (`noindex`) und `robots.txt` Steuerung.

### [v2.0.0] - Das große Redesign
*   **UI-Overhaul:** Einführung des Glassmorphism-Designs.
*   **Livewire CRUD:** Alle Formulare (Mitglieder, Inventar, Zahlungen) funktionieren nun ohne Seiten-Reload in Modals und Slide-overs.
*   **Echtzeit-Dashboard:** Statistiken aktualisieren sich automatisch bei Änderungen im Hintergrund.
*   **Filter-Engine:** Einführung eines zentralen Filter-Services für konsistente Suche und Sortierung.
*   **Dokumente:** Neuer Drag & Drop Uploader für Dokumente mit Vorschau-Funktion.

---

## 🤝 Mitwirken & Support
Beiträge sind herzlich willkommen!

**Autor:** David Schuchert  
**Live-Demo:** [https://verein.david-schuchert.de/](https://verein.david-schuchert.de/)

*Lizenz: MIT*
