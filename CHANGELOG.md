# Changelog

Alle nennenswerten Änderungen an diesem Projekt werden in dieser Datei dokumentiert.

## [v2.1.0] - Master Data & Auditability (Aktuelle Version)

Diese Version erweitert die Premium-Infrastruktur um eine zentrale Stammdatenverwaltung, verbesserte Nachvollziehbarkeit bei Finanzen und strikte Privatsphäre-Einstellungen.

### Hinzugefügt
- **Zentrale Stammdatenverwaltung (Setup 2.0)**:
    - Neues tab-basiertes Kontrollzentrum für Ränge, Kategorien und Standorte.
    - Reusable **Lookup-Manager** für effizientes Inline-Editing von Stammdaten.
- **Finanz-Auditability**:
    - Einführung einer `user_id` für alle Zahlungen.
    - Anzeige des Erfassers ("Erfasst von...") in der Transaktionsliste und im PDF-Journal.
- **Strukturierte Standortverwaltung**:
    - Umstellung der Lagerstandorte im Inventar von Freitext auf eine gesicherte Auswahl via Stammdaten.
- **Privacy & SEO Control**:
    - Globales `noindex, nofollow` für alle Seiten zum Schutz vor Suchmaschinen-Listing.
    - Implementierung einer restriktiven `robots.txt`.
- **Personalisiertes Branding**:
    - Custom Footer mit "Created by David Schuchert" und direktem GitHub-Link.

### Geändert
- **User Management Redesign**: Komplette Überarbeitung der Benutzerliste und Profile im Premium-V2-Design (Glassmorphism, permanente Aktions-Buttons).
- **Profil-Bereich**: Modernisierung der Seite "Mein Konto" inklusive Sicherheitseinstellungen.
- **Navigation**: Umstellung der Dropdown-Logik auf eine globale Alpine.js Initialisierung zur Vermeidung von Aussetzern auf statischen Seiten.

### Behoben
- **Alpine.js Closing Bug**: Dropdowns schließen sich nun zuverlässig und flackern nicht mehr beim Laden (`x-cloak`).
- **User Management CRUD**: Wiederherstellung der Bearbeiten- und Löschen-Funktionen durch Korrektur der Routen-Logik.
- **SQL Field Error**: Behebung des Fehlers beim Anlegen von Kategorien durch automatische Zuweisung des Typs (`type='inventar'`).
- **PDF-Variable Error**: Korrektur eines Namensfehlers (`$item` vs `$zahlung`) im Zahlungs-Export.

## [v2.0.0] - Premium UI & Feature Upgrade
...

