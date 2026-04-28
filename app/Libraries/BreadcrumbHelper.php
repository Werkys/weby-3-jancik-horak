<?php

namespace App\Libraries;

/**
 * Library: BreadcrumbHelper
 * Pomocná knihovna pro generování breadcrumb navigace (drobečková navigace)
 */
class BreadcrumbHelper
{
    /** @var array Pole položek breadcrumb [['title' => ..., 'url' => ...]] */
    private array $items = [];

    /**
     * Přidá položku do breadcrumb navigace
     *
     * @param string      $title Název položky zobrazený uživateli
     * @param string|null $url   URL odkaz (null = aktivní/poslední položka bez odkazu)
     * @return self              Fluent interface pro řetězení
     */
    public function add(string $title, ?string $url = null): self
    {
        $this->items[] = ['title' => $title, 'url' => $url];
        return $this;
    }

    /**
     * Vygeneruje HTML kód breadcrumb navigace (Bootstrap 5)
     *
     * @return string HTML kód elementu <nav> s breadcrumb
     */
    public function render(): string
    {
        if (empty($this->items)) {
            return '';
        }

        $html  = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        $last  = count($this->items) - 1;

        foreach ($this->items as $i => $item) {
            if ($i === $last) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . esc($item['title']) . '</li>';
            } else {
                $url  = $item['url'] ?? '#';
                $html .= '<li class="breadcrumb-item"><a href="' . $url . '">' . esc($item['title']) . '</a></li>';
            }
        }

        $html .= '</ol></nav>';
        return $html;
    }

    /**
     * Resetuje breadcrumb navigaci
     *
     * @return self Fluent interface
     */
    public function reset(): self
    {
        $this->items = [];
        return $this;
    }
}
