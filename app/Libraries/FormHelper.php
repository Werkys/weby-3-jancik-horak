<?php

namespace App\Libraries;

/**
 * Library: FormHelper
 * Vlastní helper pro generování Bootstrap 5 formulářových prvků
 * Snižuje opakování kódu ve views
 */
class FormHelper
{
    /**
     * Vygeneruje Bootstrap 5 textové pole s labelem a chybovou hláškou
     *
     * @param string      $name        Název atributu (name/id)
     * @param string      $label       Text labelu
     * @param string      $value       Aktuální hodnota pole
     * @param array       $errors      Pole validačních chyb [field => message]
     * @param bool        $required    Zda je pole povinné
     * @param string      $type        Typ input elementu (text, email, password, ...)
     * @return string                  HTML kód formulářového prvku
     */
    public function input(
        string $name,
        string $label,
        string $value = '',
        array $errors = [],
        bool $required = false,
        string $type = 'text'
    ): string {
        $hasError    = isset($errors[$name]);
        $errorClass  = $hasError ? ' is-invalid' : '';
        $requiredAttr = $required ? ' required' : '';
        $requiredMark = $required ? ' <span class="text-danger">*</span>' : '';

        $html  = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">' . esc($label) . $requiredMark . '</label>';
        $html .= '<input type="' . esc($type) . '" class="form-control' . $errorClass . '" ';
        $html .= 'id="' . esc($name) . '" name="' . esc($name) . '" value="' . esc($value) . '"' . $requiredAttr . '>';
        if ($hasError) {
            $html .= '<div class="invalid-feedback">' . esc($errors[$name]) . '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Vygeneruje Bootstrap 5 textarea s labelem a chybovou hláškou
     *
     * @param string $name     Název atributu (name/id)
     * @param string $label    Text labelu
     * @param string $value    Aktuální hodnota pole
     * @param array  $errors   Pole validačních chyb
     * @param bool   $required Zda je pole povinné
     * @param int    $rows     Počet řádků textarea
     * @return string          HTML kód formulářového prvku
     */
    public function textarea(
        string $name,
        string $label,
        string $value = '',
        array $errors = [],
        bool $required = false,
        int $rows = 5
    ): string {
        $hasError    = isset($errors[$name]);
        $errorClass  = $hasError ? ' is-invalid' : '';
        $requiredAttr = $required ? ' required' : '';
        $requiredMark = $required ? ' <span class="text-danger">*</span>' : '';

        $html  = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">' . esc($label) . $requiredMark . '</label>';
        $html .= '<textarea class="form-control' . $errorClass . '" id="' . esc($name) . '" ';
        $html .= 'name="' . esc($name) . '" rows="' . $rows . '"' . $requiredAttr . '>' . esc($value) . '</textarea>';
        if ($hasError) {
            $html .= '<div class="invalid-feedback">' . esc($errors[$name]) . '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Vygeneruje Bootstrap 5 select (dropdown) s labelem
     * První volba je nevolitelná (placeholder)
     *
     * @param string $name        Název atributu (name/id)
     * @param string $label       Text labelu
     * @param array  $options     Pole možností [value => text]
     * @param mixed  $selected    Aktuálně vybraná hodnota
     * @param array  $errors      Pole validačních chyb
     * @param bool   $required    Zda je pole povinné
     * @param string $placeholder Text první nevolitelné volby
     * @return string             HTML kód formulářového prvku
     */
    public function select(
        string $name,
        string $label,
        array $options,
        $selected = null,
        array $errors = [],
        bool $required = false,
        string $placeholder = '-- Vyberte --'
    ): string {
        $hasError    = isset($errors[$name]);
        $errorClass  = $hasError ? ' is-invalid' : '';
        $requiredAttr = $required ? ' required' : '';
        $requiredMark = $required ? ' <span class="text-danger">*</span>' : '';

        $html  = '<div class="mb-3">';
        $html .= '<label for="' . esc($name) . '" class="form-label">' . esc($label) . $requiredMark . '</label>';
        $html .= '<select class="form-select' . $errorClass . '" id="' . esc($name) . '" name="' . esc($name) . '"' . $requiredAttr . '>';
        $html .= '<option value="" disabled selected>' . esc($placeholder) . '</option>';

        foreach ($options as $value => $text) {
            $isSelected = ((string) $selected === (string) $value) ? ' selected' : '';
            $html .= '<option value="' . esc($value) . '"' . $isSelected . '>' . esc($text) . '</option>';
        }

        $html .= '</select>';
        if ($hasError) {
            $html .= '<div class="invalid-feedback">' . esc($errors[$name]) . '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * Vygeneruje Bootstrap 5 tlačítko
     *
     * @param string $label   Text tlačítka
     * @param string $type    Typ tlačítka (submit, button, reset)
     * @param string $variant Bootstrap varianta (primary, danger, secondary, ...)
     * @return string         HTML kód tlačítka
     */
    public function button(string $label, string $type = 'submit', string $variant = 'primary'): string
    {
        return '<button type="' . esc($type) . '" class="btn btn-' . esc($variant) . '">' . esc($label) . '</button>';
    }
}
