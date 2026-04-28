<?php

namespace App\Libraries;

/**
 * Library: SlugHelper
 * Pomocná knihovna pro generování slugů z textových řetězců
 */
class SlugHelper
{
    /**
     * Převede text na URL-friendly slug
     *
     * @param string $text   Vstupní text (např. název kategorie)
     * @param string $sep    Oddělovač slov (výchozí: '-')
     * @return string        URL-friendly slug (malá písmena, bez diakritiky, pomlčky místo mezer)
     */
    public function generate(string $text, string $sep = '-'): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        $czech = [
            'á' => 'a', 'č' => 'c', 'ď' => 'd', 'é' => 'e', 'ě' => 'e',
            'í' => 'i', 'ň' => 'n', 'ó' => 'o', 'ř' => 'r', 'š' => 's',
            'ť' => 't', 'ú' => 'u', 'ů' => 'u', 'ý' => 'y', 'ž' => 'z',
        ];

        $text = strtr($text, $czech);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', $sep, trim($text));

        return $text;
    }

    /**
     * Zajistí unikátnost slugu v databázi přidáním čísla na konec
     *
     * @param string $slug      Vstupní slug
     * @param string $table     Název tabulky v DB
     * @param string $column    Název sloupce se slugem
     * @param int|null $excludeId ID záznamu k vyloučení (při editaci)
     * @return string           Unikátní slug
     */
    public function makeUnique(string $slug, string $table, string $column = 'slug', ?int $excludeId = null): string
    {
        $db      = \Config\Database::connect();
        $base    = $slug;
        $counter = 1;

        while (true) {
            $builder = $db->table($table)->where($column, $slug);
            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }
            if ($builder->countAllResults() === 0) {
                break;
            }
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
