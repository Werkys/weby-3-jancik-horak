<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Config: RecipeConfig
 * Konfigurační soubor pro nastavení aplikace Receptář
 *
 * Popis konfiguračních proměnných:
 * - $recipesPerPage: Počet receptů zobrazených na jedné stránce v přehledu receptů.
 *   Typ: int, Výchozí: 12, Povolené hodnoty: 6, 9, 12, 24, 48
 *
 * - $imagesPerPage: Počet obrázků zobrazených na jedné stránce v galerii.
 *   Typ: int, Výchozí: 12, Povolené hodnoty: 6, 12, 18, 24, 36
 *
 * - $categoriesPerPage: Počet kategorií na jedné stránce.
 *   Typ: int, Výchozí: 10, Povolené hodnoty: 5, 10, 20, 50
 *
 * - $maxUploadSizeMB: Maximální velikost nahrávaného souboru v megabytech.
 *   Typ: int, Výchozí: 5, Povolené hodnoty: 1-20
 *
 * - $allowedImageTypes: Seznam povolených MIME typů pro nahrávání obrázků.
 *   Typ: array<string>, Výchozí: ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
 *
 * - $tinymceApiKey: API klíč pro TinyMCE WYSIWYG editor.
 *   Typ: string, Výchozí: 'no-api-key' (pro lokální vývoj), Pro produkci zadejte vlastní klíč z tiny.cloud
 *
 * - $appName: Název aplikace zobrazovaný v hlavičce a zápatí.
 *   Typ: string, Výchozí: 'Receptář'
 */
class RecipeConfig extends BaseConfig
{
    /**
     * Počet receptů na stránku v přehledu receptů
     * Povolené hodnoty: 6, 9, 12, 24, 48
     */
    public int $recipesPerPage = 12;

    /**
     * Počet obrázků na stránku v galerii
     * Povolené hodnoty: 6, 12, 18, 24, 36
     */
    public int $imagesPerPage = 12;

    /**
     * Počet kategorií na stránku
     * Povolené hodnoty: 5, 10, 20, 50
     */
    public int $categoriesPerPage = 10;

    /**
     * Maximální velikost nahrávaného souboru v MB
     * Povolené hodnoty: 1-20
     */
    public int $maxUploadSizeMB = 5;

    /**
     * Povolené MIME typy pro nahrávání obrázků
     */
    public array $allowedImageTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * API klíč pro TinyMCE editor
     * Získejte vlastní klíč na https://www.tiny.cloud/
     */
    public string $tinymceApiKey = 'no-api-key';

    /**
     * Název aplikace
     */
    public string $appName = 'Receptář';
}
