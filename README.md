# VereinsManagementTool (v2.1 - Master Data & Auditability)

Das VereinsManagementTool ist eine umfassende Webanwendung zur Verwaltung von Vereinsmitgliedern, Inventar, Finanzen und Protokollen. In der Version 2.1 wurde die Anwendung um eine zentrale Stammdatenverwaltung und verbesserte Revisionssicherheit erweitert.

## Highlights der Version 2.1

-   **Premium UI/UX (Glassmorphism)**: Vollständiges Redesign mit modernen Transparenz-Effekten und flüssiger Navigation.
-   **Zentrales Kontrollzentrum**: Neue Stammdatenverwaltung für Ränge, Kategorien und Standorte in einer tab-basierten Oberfläche.
-   **Finanz-Revision**: Jede Zahlung wird dem erfassenden Benutzer zugeordnet, inklusive namentlicher Nennung im PDF-Journal.
-   **Strukturierte Lagerverwaltung**: Umstellung von Freitext-Standorten auf eine saubere, kategorisierte Standortwahl.
-   **Privacy by Design**: Automatischer Schutz vor Suchmaschinen-Indizierung (`noindex`) und konfigurierbare `robots.txt`.
-   **Mitglieder- & Dokumentenverwaltung**: Interaktive Slide-overs für schnellen Zugriff auf Zugangsdaten und Dokumente.
-   **Compliance PDF-Berichte**: Professionelle Berichte mit Seitenzahlen, Bilanz-Zusammenfassungen und namentlichem Erfassernachweis.
-   **Branding**: Personalisiertes David-Schuchert-Footer-System.

## Update von v1 auf v2 (Wichtig!)

Wenn Sie von der klassischen Version 1 auf die Premium-Version 2 aktualisieren, sind folgende Schritte für die UI-Umstellung zwingend erforderlich:

1.  **Code-Basis synchronisieren:** 
    Ziehen Sie den neuesten Stand aus dem Repository.
2.  **Abhängigkeiten aktualisieren:**
    ```bash
    composer install --no-dev --optimize-autoloader
    npm install
    ```
3.  **Veraltete Assets entfernen & neu bauen:**
    Da v2 ein komplett neues Design-System nutzt, müssen die CSS/JS-Dateien zwingend neu kompiliert werden:
    ```bash
    npm run build
    ```
4.  **Laravel-Caches bereinigen:**
    Wichtig, damit die neuen Pfade und Konfigurationen sofort aktiv werden:
    ```bash
    php artisan view:clear
    php artisan config:clear
    php artisan cache:clear
    ```
5.  **Datenbank-Updates:**
    ```bash
    php artisan migrate
    ```

## Installation (Neu-Setup)

### Voraussetzungen

-   PHP >= 8.2 (mit Curl-Erweiterung)
-   Composer
-   Datenbank (MySQL / MariaDB)
-   Node.js & npm

### Schritte

1.  **Repository klonen & Ordner öffnen.**
2.  **Abhängigkeiten installieren:** `composer install` & `npm install`.
3.  **Umgebung konfigurieren:** Kopieren Sie `.env.example` zu `.env` und tragen Sie Ihre Datenbank-Zugangsdaten sowie die `APP_URL` ein.
4.  **Setup ausführen:**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    php artisan storage:link
    npm run build
    ```
5.  **Starten:** Richten Sie Ihren Webserver (Apache/Nginx) auf den `public/`-Ordner aus.

## Standard-Login (nach Seed)

-   **E-Mail**: `admin@admin`
-   **Passwort**: `admin`

---
**DEMO: https://verein.david-schuchert.de/**