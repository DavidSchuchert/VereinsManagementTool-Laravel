<p align="center">
  <img src="public/assets/vmt-logo.png" width="200" alt="VMT Logo">
</p>

# 🚀 Das VereinsManagementTool (VMT)

### Endlich mehr Zeit für deinen Verein – weniger Zettelwirtschaft, mehr Gemeinschaft!

Das **VereinsManagementTool** ist dein digitaler Helfer im Vereinsalltag. Wir wissen, dass Vereinsarbeit Herzblut bedeutet – und oft viel Papierkram. Deshalb haben wir eine Lösung entwickelt, die deine Mitglieder, Finanzen und Dokumente an einem sicheren Ort verwaltet. Es ist modern, blitzschnell und so intuitiv, dass du kein Technik-Profi sein musst, um es zu lieben.

---

## ✨ Das macht dein Vereinsleben leichter

*   💎 **Moderne Optik:** Ein Design, das Spaß macht. Alles ist dort, wo du es erwartest.
*   👥 **Mitglieder im Überblick:** Digitale Akten statt verstaubter Ordner. Wer ist dabei? Welchen Rang hat er? Alles sofort griffbereit.
*   💰 **Sicherheit für den Kassenwart:** Erfasse Einnahmen und Ausgaben in Sekunden. Das System merkt sich jede Änderung – perfekt für eine entspannte Kassenprüfung.
*   📦 **Dein Inventar im Griff:** Von Trikots über Bälle bis hin zur Technik – du weißt immer genau, was dein Verein besitzt und wo es lagert.
*   📄 **Sicherer Dokumenten-Tresor:** Wichtige Dokumente wie Satzungen oder Verträge einfach hochladen und nie wieder suchen.

---

## 🌐 Erstmal reinschnuppern? (Live-Demo)

Du kannst das Tool sofort ausprobieren, ohne etwas installieren zu müssen. Schau dir unsere Demo an und erlebe, wie flüssig sich Vereinsarbeit anfühlen kann:

✨ **[JETZT DIE LIVE-DEMO STARTEN](https://verein.david-schuchert.de/)** ✨

**Deine Login-Daten für die Demo:**
*   **E-Mail:** `admin@admin`
*   **Passwort:** `admin`

---

## 📥 Für die IT-Experten (Installation)

Du möchtest das Tool für deinen eigenen Verein aufsetzen? Hier sind die technischen Details, die du für den Start benötigst.

### Voraussetzungen
*   **PHP >= 8.2**
*   **Composer** (PHP-Paketmanager)
*   **MySQL 8.0+** oder **MariaDB 10.11+**
*   **Node.js & NPM** (für das Design)

### In 4 Schritten startklar

1.  **Code holen:**
    ```
    git clone https://github.com/DavidSchuchert/VereinsManagementTool-Laravel.git
    cd VereinsManagementTool-Laravel
    ```

2.  **Werkzeuge vorbereiten:**
    ```
    composer install --no-dev --optimize-autoloader
    npm install && npm run build
    ```

3.  **Häuslich einrichten:**
    Kopiere die Datei `.env.example` zu `.env` und trage dort deine Internet-Adresse (`APP_URL`) und deine Datenbank-Daten ein.

4.  **Das digitale Vereinsheim einrichten:**
    ```
    php artisan key:generate
    php artisan migrate --seed
    php artisan storage:link
    php artisan livewire:publish --assets
    ```

---

## 🔄 Updates & Wartung (Produktion)

Wenn du das System aktualisieren möchtest, führe einfach diese Befehle nacheinander aus:

1.  `git pull`
2.  `composer install --no-dev --optimize-autoloader`
3.  `npm install && npm run build`
4.  `php artisan migrate --force`
5.  `php artisan livewire:publish --assets`
6.  `php artisan optimize`

---

## 🔑 Deine ersten Schritte

Nach der ersten Installation (mit `--seed`) kannst du dich so anmelden:
*   **E-Mail:** `admin@admin`
*   **Passwort:** `admin`

🔴 **WICHTIG:** Ändere bitte **sofort** nach dem ersten Login deine E-Mail und dein Passwort in deinem Profil (oben rechts auf deinen Namen klicken), um deinen Verein zu schützen!

---

## 🤝 Gemeinschaft & Support

Beiträge und Feedback sind immer willkommen! Gemeinsam machen wir das Vereinsleben ein Stück digitaler.

**Autor:** David Schuchert  
**Website:** [https://verein.david-schuchert.de/](https://verein.david-schuchert.de/)

*Lizenz: MIT*
