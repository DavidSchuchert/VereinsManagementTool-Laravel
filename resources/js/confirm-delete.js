document.addEventListener("DOMContentLoaded", function () {
    // Wähle alle Formulare mit der Methode DELETE aus
    const deleteForms = document.querySelectorAll(
        'form[method="POST"] input[name="_method"][value="DELETE"]'
    );

    deleteForms.forEach((input) => {
        const form = input.closest("form");
        form.addEventListener("submit", function (event) {
            if (
                !confirm(
                    "Bist du sicher, dass du diesen Eintrag löschen möchtest?"
                )
            ) {
                event.preventDefault(); // Verhindere das Absenden des Formulars
            }
        });
    });
});
