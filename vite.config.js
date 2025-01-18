import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/dashboard/index.css",
                "resources/css/inventar/index.css",
                "resources/css/mitglieder/index.css",
                "resources/css/zahlungen/create.css",
                "resources/css/zahlungen/edit.css",
                "resources/css/zahlungen/index.css",
                "resources/css/alert.css",
                "resources/css/app.css",
                "resources/css/header.css",
                "resources/css/search.css",
                "resources/css/protokolle/editor.css",
                "resources/css/protokolle/index.css",
                "resources/js/app.js",
                "resources/js/confirm-delete.js",
            ],
            refresh: true,
        }),
    ],
});
