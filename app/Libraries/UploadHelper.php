<?php

namespace App\Libraries;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * Library: UploadHelper
 * Pomocná knihovna pro nahrávání souborů (obrázků)
 */
class UploadHelper
{
    /** @var string Cesta pro ukládání nahraných souborů */
    private string $uploadPath;

    /** @var array Povolené typy MIME pro obrázky */
    private array $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /** @var int Maximální velikost souboru v bytech (5 MB) */
    private int $maxSize = 5 * 1024 * 1024;

    public function __construct()
    {
        $this->uploadPath = FCPATH . 'uploads/images/';
    }

    /**
     * Nahraje obrázek z requestu a vrátí název souboru
     *
     * @param IncomingRequest $request HTTP požadavek obsahující soubor
     * @param string          $field   Název pole formuláře s souborem
     * @return string|null             Název uloženého souboru nebo null při chybě
     * @throws \RuntimeException       Pokud soubor není platný nebo příliš velký
     */
    public function uploadImage(IncomingRequest $request, string $field = 'image'): ?string
    {
        $file = $request->getFile($field);

        if ($file === null || ! $file->isValid() || $file->hasMoved()) {
            return null;
        }

        if (! in_array($file->getMimeType(), $this->allowedMimes, true)) {
            throw new \RuntimeException('Povoleny jsou pouze formáty JPEG, PNG, GIF a WebP.');
        }

        if ($file->getSize() > $this->maxSize) {
            throw new \RuntimeException('Soubor je příliš velký. Maximální velikost je 5 MB.');
        }

        $newName = $file->getRandomName();
        $file->move($this->uploadPath, $newName);

        return $newName;
    }

    /**
     * Odstraní soubor obrázku z disku
     *
     * @param string $filename Název souboru k odstranění
     * @return bool            True pokud byl soubor úspěšně odstraněn
     */
    public function deleteImage(string $filename): bool
    {
        $path = $this->uploadPath . $filename;
        if (is_file($path)) {
            return unlink($path);
        }
        return false;
    }

    /**
     * Vrátí URL adresu obrázku
     *
     * @param string|null $filename Název souboru
     * @param string      $default  Výchozí obrázek (placeholder)
     * @return string               Absolutní URL obrázku
     */
    public function getImageUrl(?string $filename, string $default = 'placeholder.jpg'): string
    {
        if ($filename && is_file($this->uploadPath . $filename)) {
            return base_url('uploads/images/' . $filename);
        }
        return base_url('img/' . $default);
    }
}
