
# VereinsManagementTool

Das VereinsManagementTool ist eine umfassende Webanwendung zur Verwaltung von Vereinsmitgliedern, Inventar, Transaktionen und weiteren Modulen. Die Anwendung ist mit Laravel entwickelt und bietet eine benutzerfreundliche Oberfläche sowie eine Vielzahl von Funktionen, um die Vereinsverwaltung effizient zu gestalten.

## Funktionen

-   **Benutzerverwaltung**: Benutzer erstellen, bearbeiten und verwalten.
-   **Mitgliederverwaltung**: Mitgliederinformationen anzeigen und verwalten.
-   **Inventarverwaltung**: Artikel, Mengen, EAN und Lagerstandorte verwalten.
-   **Transaktionsverwaltung**: Einfache Anzeige und Verwaltung von Transaktionen.
-   **Profilverwaltung**: Benutzerprofile anpassen.
-   **Setup**: Festlegung des Vereinsnamens und Logos.
-   **Authentifizierung**: Benutzeranmeldung und Anlegen neuer Benutzer
-   **Update**: Automatische Information, sollte ein Update vorliegen

## Installation

Folgen Sie dieser Anleitung, um das VereinsManagementTool auf Ihrem lokalen Server einzurichten:

### Voraussetzungen

-   PHP >= 8.0
-   PHP Curl
-   Composer
-   MySQL oder eine andere unterstützte Datenbank
-   Node.js & npm


### Schritt-für-Schritt-Anleitung

1.  **Repository klonen:**

    `git clone https://github.com/DavidSchuchert/VereinsManagementTool-Laravel.git
    cd VereinsManagementTool` 
    
2.  **Abhängigkeiten installieren:**

    `composer install
    npm install
    npm run build` 
    
3.  **.env-Datei erstellen:** Erstellen Sie eine `.env`-Datei, indem Sie die `.env.example` kopieren:
    
    `cp .env.example .env` 
    
    Bearbeiten Sie die `.env`-Datei und fügen Sie Ihre Datenbankinformationen sowie weitere Konfigurationsdetails hinzu.
    
4.  **App-Schlüssel generieren:**
    
    `php artisan key:generate` 
    
5.  **Datenbankmigrationen ausführen:**
    
    `php artisan migrate --seed` 
    
    **Hinweis**: Der `--seed`-Befehl füllt die Datenbank mit einigen Beispieldaten und erzeugt den Admin benutzer.
    
6.  **Storage verlinken:**

    `php artisan storage:link` 
    
7.  **Webserver einrichten:** Richten Sie einen Webserver (z.B. Apache oder Nginx) ein, um die Anwendung in einer Produktionsumgebung auszuführen.

7.  **Rechte prüfen:** Bitte vergeben sie alle erforderlichen rechte für Laravel, wie z.B. den public ordner und die storage.
    

## Standard-Login-Daten

Nach der Installation können Sie sich mit den folgenden Standard-Login-Daten anmelden:

-   **E-Mail**: `admin@admin`
-   **Passwort**: `admin`

**Hinweis**: Ändern Sie die Standard-Login-Daten nach der ersten Anmeldung, um die Sicherheit zu gewährleisten.

## Weitere Informationen

-   **Environment Setup**: Stellen Sie sicher, dass alle Konfigurationsdaten korrekt in der `.env`-Datei eingetragen sind, z.B. Datenbankverbindungen.
-   **Seeds**: Die Datenbank wird mit Basisdaten für eine schnelle Übersicht gefüllt. Bearbeiten Sie die Seed-Dateien nach Bedarf.
-   **Storage Link**: Der Befehl `php artisan storage:link` erstellt eine symbolische Verknüpfung, um Dateien im `storage`-Verzeichnis öffentlich zugänglich zu machen.

## Mitwirken

Beiträge und Verbesserungsvorschläge sind herzlich willkommen! Bitte erstellen Sie einen Fork des Projekts, nehmen Sie Ihre Änderungen vor und senden Sie eine Pull-Request.# VereinsManagementTool

**DEMO:  https://verein.david-schuchert.de/**
E-Mail: admin@admin
Passwort: admin