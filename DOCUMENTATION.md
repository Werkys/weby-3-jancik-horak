# Receptář – Dokumentace projektu

## Projekt
**Název:** Receptář – webová aplikace pro správu receptů  
**Framework:** CodeIgniter 4  
**Jazyk aplikace:** Čeština (CZ)  
**Autoři:** Jančík & Horák  

---

## Rozdělení práce

| Část | Odpovědný |
|------|-----------|
| Databázový návrh a migrace | Jančík |
| Modely a datová vrstva | Jančík |
| Controllery (Recipe, Gallery) | Jančík |
| Controllery (Auth, Category, Home) | Horák |
| Views – layout a sdílené komponenty | Horák |
| Views – recepty a galerie | Jančík |
| Views – kategorie a přihlášení | Horák |
| Knihovny (SlugHelper, UploadHelper) | Jančík |
| Knihovny (BreadcrumbHelper, FormHelper) | Horák |
| Seedery a testovací data | Horák |
| Dokumentace | Oba |

---

## Konvence pojmenování

### Databáze
- **Jazyk názvů:** Angličtina (anglická slova)
- **Notace tabulek:** `snake_case` v množném čísle (např. `recipes`, `recipe_ingredients`)
- **Notace sloupců:** `snake_case` (např. `created_at`, `password_hash`, `short_description`)
- **Primární klíče:** vždy `id` (INT UNSIGNED AUTO_INCREMENT)
- **Cizí klíče:** `{odkazovaná_tabulka_jednotné_číslo}_id` (např. `recipe_id`, `user_id`, `category_id`)
- **Soft delete sloupec:** `deleted_at` (DATETIME, NULL = nezmazáno)
- **Časová razítka:** `created_at`, `updated_at` (DATETIME)

### PHP – Proměnné
- **Notace:** `camelCase` pro lokální proměnné a vlastnosti (např. `$recipeModel`, `$categoryId`)
- **Třídy:** `PascalCase` (např. `RecipeModel`, `AuthFilter`, `BreadcrumbHelper`)
- **Konstanty:** `UPPER_SNAKE_CASE`

### PHP – Třídy (pojmenování dle typu)
| Typ | Konvence | Příklad |
|-----|----------|---------|
| Model | `{Entita}Model` | `RecipeModel` |
| Controller | `{Entita}` nebo `{Akce}` | `Recipe`, `Gallery`, `Auth` |
| Library (knihovna) | `{Popis}Helper` nebo `{Popis}` | `SlugHelper`, `UploadHelper` |
| Filter | `{Popis}Filter` | `AuthFilter` |
| Config | `{Popis}Config` | `RecipeConfig` |

### Složky Views
- Pojmenovány malými písmeny dle controlleru: `recipe/`, `category/`, `gallery/`, `auth/`, `home/`, `layouts/`

### Metody v controllerech (uniformní pojmenování)
| Akce | Metoda | HTTP Metoda | Popis |
|------|--------|-------------|-------|
| Výpis | `index()` | GET | Zobrazí seznam záznamů |
| Detail | `show(int $id)` | GET | Zobrazí detail jednoho záznamu |
| Formulář přidání | `create()` | GET | Zobrazí formulář pro přidání |
| Uložení přidání | `store()` | POST | Zpracuje formulář pro přidání |
| Formulář editace | `edit(int $id)` | GET | Zobrazí formulář pro editaci |
| Uložení editace | `update(int $id)` | POST | Zpracuje formulář pro editaci |
| Smazání | `delete(int $id)` | POST | Provede soft delete záznamu |

---

## Databázové tabulky

### Přehled tabulek

| Tabulka | Popis | Typ relace |
|---------|-------|------------|
| `users` | Uživatelé systému | Hlavní |
| `categories` | Kategorie receptů | Hlavní |
| `recipes` | Recepty | Hlavní |
| `ingredients` | Ingredience | Hlavní |
| `recipe_ingredients` | Propojení receptů a ingrediencí | M:N |
| `images` | Obrázky přiřazené k receptům | Vedlejší |

### Tabulka `users`
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `username` | VARCHAR(100) | Přihlašovací jméno (unikátní) |
| `email` | VARCHAR(255) | E-mailová adresa (unikátní) |
| `password_hash` | VARCHAR(255) | Zahashované heslo (bcrypt) |
| `full_name` | VARCHAR(200) | Celé jméno uživatele |
| `role` | ENUM(admin,user) | Role uživatele v systému |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum poslední aktualizace |
| `deleted_at` | DATETIME | Datum soft delete (NULL = aktivní) |

### Tabulka `categories`
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `name` | VARCHAR(100) | Název kategorie |
| `description` | TEXT | Popis kategorie |
| `slug` | VARCHAR(120) | URL-friendly název (unikátní) |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum aktualizace |
| `deleted_at` | DATETIME | Datum soft delete |

### Tabulka `recipes`
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `title` | VARCHAR(255) | Název receptu |
| `short_description` | VARCHAR(500) | Krátký popis |
| `description` | LONGTEXT | Podrobný popis (WYSIWYG, 1000+ znaků) |
| `image_path` | VARCHAR(255) | Cesta k obrázku receptu |
| `user_id` | INT FK | Odkaz na autora (users.id) |
| `category_id` | INT FK | Odkaz na kategorii (categories.id) |
| `prep_time_minutes` | INT | Čas přípravy v minutách |
| `servings` | TINYINT | Počet porcí |
| `published_at` | DATETIME | Datum publikování |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum aktualizace |
| `deleted_at` | DATETIME | Datum soft delete |

### Tabulka `ingredients`
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `name` | VARCHAR(150) | Název ingredience |
| `unit` | VARCHAR(50) | Jednotka (g, ml, ks, ...) |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum aktualizace |
| `deleted_at` | DATETIME | Datum soft delete |

### Tabulka `recipe_ingredients` (M:N)
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `recipe_id` | INT FK | Odkaz na recept (recipes.id) |
| `ingredient_id` | INT FK | Odkaz na ingredienci (ingredients.id) |
| `amount` | DECIMAL(10,2) | Množství ingredience |
| `notes` | VARCHAR(255) | Poznámka (volitelně) |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum aktualizace |
| `deleted_at` | DATETIME | Datum soft delete |

### Tabulka `images`
| Sloupec | Typ | Popis |
|---------|-----|-------|
| `id` | INT PK | Primární klíč |
| `recipe_id` | INT FK | Odkaz na recept (recipes.id), může být NULL |
| `filename` | VARCHAR(255) | Název souboru obrázku |
| `alt_text` | VARCHAR(255) | Alternativní text obrázku |
| `created_at` | DATETIME | Datum vytvoření |
| `updated_at` | DATETIME | Datum aktualizace |
| `deleted_at` | DATETIME | Datum soft delete |

---

## Modely

### `UserModel` (`app/Models/UserModel.php`)
Spravuje data uživatelů. Využívá soft deletes a automatická časová razítka.
- **`findByUsername(string $username)`** – Vyhledá uživatele podle uživatelského jména. Vstup: username, Výstup: pole nebo null.
- **`findByEmail(string $email)`** – Vyhledá uživatele podle e-mailu. Vstup: email, Výstup: pole nebo null.

### `CategoryModel` (`app/Models/CategoryModel.php`)
Spravuje kategorie receptů.
- **`getDropdown()`** – Vrátí všechny kategorie jako pole [id => name] pro použití v dropdownu. Výstup: array.
- **`getWithRecipeCount()`** – Vrátí kategorie s počtem receptů (JOIN + agregace). Výstup: array.

### `RecipeModel` (`app/Models/RecipeModel.php`)
Hlavní model pro recepty. Využívá JOIN pro propojení s kategoriemi a uživateli.
- **`getWithDetails(int $perPage, ?int $categoryId)`** – Vrátí recepty s JOIN daty (kategorie, uživatel). Vstup: počet na stránku, ID kategorie (volitelné). Výstup: array.
- **`getWithDetailsById(int $id)`** – Vrátí jeden recept s JOIN daty. Vstup: ID. Výstup: array nebo null.
- **`getStats()`** – Vrátí statistiky receptů dle kategorií (agregace). Výstup: array.

### `IngredientModel` (`app/Models/IngredientModel.php`)
Spravuje ingredience.
- **`getDropdown()`** – Vrátí ingredience jako pole pro dropdown/multiselect. Výstup: array [id => name (unit)].

### `RecipeIngredientModel` (`app/Models/RecipeIngredientModel.php`)
Spravuje M:N relaci mezi recepty a ingrediencemi.
- **`getForRecipe(int $recipeId)`** – Vrátí ingredience pro daný recept s JOIN daty. Vstup: ID receptu. Výstup: array.
- **`replaceForRecipe(int $recipeId, array $ingredients)`** – Smaže a znovu vloží ingredience receptu. Vstup: ID receptu, pole ingrediencí. Výstup: void.

### `ImageModel` (`app/Models/ImageModel.php`)
Spravuje obrázky přiřazené k receptům.
- **`getForRecipe(int $recipeId)`** – Vrátí obrázky pro daný recept. Vstup: ID receptu. Výstup: array.
- **`getGallery(int $perPage, int $offset)`** – Vrátí stránkovanou galerii obrázků s JOIN daty. Vstup: počet na stránku, offset. Výstup: array.
- **`countGallery()`** – Vrátí celkový počet obrázků (pro stránkování). Výstup: int.

---

## Controllery

### `Home` (`app/Controllers/Home.php`)
Domovská stránka aplikace.
- **`index()`** – Zobrazí domovskou stránku s nejnovějšími recepty a statistikami kategorií.

### `Auth` (`app/Controllers/Auth.php`)
Spravuje přihlašování a odhlašování uživatelů.
- **`login()`** – Zobrazí přihlašovací formulář.
- **`loginPost()`** – Zpracuje přihlašovací formulář, ověří heslo a nastaví session.
- **`logout()`** – Vymaže session a přesměruje na login.

### `Recipe` (`app/Controllers/Recipe.php`)
CRUD operace pro recepty. Přidávání, editace a mazání pouze pro přihlášené.
- **`index(?int $categoryId, ?int $userId)`** – Zobrazí seznam receptů s filtrem (routa se 2 parametry).
- **`show(int $id)`** – Zobrazí detail receptu s ingrediencemi.
- **`create()`** – Zobrazí formulář pro přidání nového receptu (s TinyMCE editorem).
- **`store()`** – Zpracuje přidání receptu, nahraje obrázek.
- **`edit(int $id)`** – Zobrazí editační formulář.
- **`update(int $id)`** – Zpracuje editaci receptu.
- **`delete(int $id)`** – Provede soft delete receptu.

### `Category` (`app/Controllers/Category.php`)
CRUD operace pro kategorie. Využívá agregaci (počet receptů).
- **`index()`** – Zobrazí seznam kategorií s počty receptů (agregace).
- **`create()`** – Zobrazí formulář pro přidání kategorie.
- **`store()`** – Zpracuje přidání kategorie, auto-generuje slug.
- **`edit(int $id)`** – Zobrazí editační formulář.
- **`update(int $id)`** – Zpracuje editaci kategorie.
- **`delete(int $id)`** – Provede soft delete kategorie.

### `Gallery` (`app/Controllers/Gallery.php`)
Správa galerie obrázků, zobrazení jako karty se stránkováním.
- **`index(int $page)`** – Zobrazí galerii obrázků ve kartách, stránkování z konfigurace.
- **`create()`** – Zobrazí formulář pro přidání obrázku.
- **`store()`** – Zpracuje nahrání obrázku.
- **`delete(int $id)`** – Provede soft delete obrázku.

---

## Vlastní knihovny

### `SlugHelper` (`app/Libraries/SlugHelper.php`)
Pomocná knihovna pro generování URL-friendly slugů z českých textů.
- **`generate(string $text, string $sep)`** – Převede text na slug (odstraní diakritiku, speciální znaky). Vstup: text, oddělovač. Výstup: string.
- **`makeUnique(string $slug, string $table, string $column, ?int $excludeId)`** – Zajistí unikátnost slugu v DB. Vstup: slug, název tabulky, sloupce, ID záznamu k vyloučení. Výstup: unikátní string.

### `UploadHelper` (`app/Libraries/UploadHelper.php`)
Pomocná knihovna pro nahrávání a správu obrázků.
- **`uploadImage(IncomingRequest $request, string $field)`** – Nahraje obrázek a vrátí název souboru. Vstup: HTTP request, název pole. Výstup: string nebo null.
- **`deleteImage(string $filename)`** – Smaže soubor z disku. Vstup: název souboru. Výstup: bool.
- **`getImageUrl(?string $filename, string $default)`** – Vrátí URL obrázku nebo placeholderu. Vstup: název souboru, výchozí obrázek. Výstup: string URL.

### `BreadcrumbHelper` (`app/Libraries/BreadcrumbHelper.php`)
Pomocná knihovna pro generování drobečkové navigace (Bootstrap 5).
- **`add(string $title, ?string $url)`** – Přidá položku do breadcrumbu. Vstup: název, URL. Výstup: self (fluent).
- **`render()`** – Vygeneruje HTML kód breadcrumb navigace. Výstup: string HTML.
- **`reset()`** – Resetuje breadcrumb. Výstup: self (fluent).

### `FormHelper` (`app/Libraries/FormHelper.php`)
Vlastní helper pro generování Bootstrap 5 formulářových prvků. Snižuje opakování kódu ve views.
- **`input(string $name, string $label, ...)`** – Generuje Bootstrap textové pole s labelem a validační chybou. Výstup: string HTML.
- **`textarea(string $name, string $label, ...)`** – Generuje Bootstrap textarea s labelem. Výstup: string HTML.
- **`select(string $name, string $label, array $options, ...)`** – Generuje Bootstrap dropdown se zakázanou první volbou. Výstup: string HTML.
- **`button(string $label, string $type, string $variant)`** – Generuje Bootstrap tlačítko. Výstup: string HTML.

---

## Konfigurační proměnné (`app/Config/RecipeConfig.php`)

| Proměnná | Typ | Výchozí | Popis | Povolené hodnoty |
|----------|-----|---------|-------|-----------------|
| `$recipesPerPage` | int | 12 | Počet receptů na stránku v přehledu | 6, 9, 12, 24, 48 |
| `$imagesPerPage` | int | 12 | Počet obrázků na stránku v galerii | 6, 12, 18, 24, 36 |
| `$categoriesPerPage` | int | 10 | Počet kategorií na stránku | 5, 10, 20, 50 |
| `$maxUploadSizeMB` | int | 5 | Maximální velikost nahrávání v MB | 1-20 |
| `$allowedImageTypes` | array | viz soubor | Povolené MIME typy obrázků | MIME typy |
| `$tinymceApiKey` | string | 'no-api-key' | API klíč pro TinyMCE editor | string z tiny.cloud |
| `$appName` | string | 'Receptář' | Název aplikace v hlavičce | libovolný string |

---

## Využité externí nástroje

| Název | Verze | Autor | Licence | Odkaz |
|-------|-------|-------|---------|-------|
| CodeIgniter 4 | 4.x | CodeIgniter Foundation | MIT | https://codeigniter.com |
| Bootstrap | 5.3.2 | The Bootstrap Authors | MIT | https://getbootstrap.com |
| Bootstrap Icons | 1.11.3 | The Bootstrap Authors | MIT | https://icons.getbootstrap.com |
| TinyMCE | 7 | Tiny Technologies Inc. | MIT | https://www.tiny.cloud |

---

## Instalace a spuštění projektu

### Požadavky
- PHP >= 8.1
- MySQL >= 5.7 nebo MariaDB >= 10.2
- Composer

### Kroky instalace

1. **Klonování repozitáře:**
   ```bash
   git clone https://github.com/Werkys/weby-3-jancik-horak.git
   cd weby-3-jancik-horak
   ```

2. **Instalace závislostí:**
   ```bash
   composer install
   ```

3. **Konfigurace prostředí:**
   ```bash
   cp env .env
   # Upravte .env soubor - nastavte databázové přihlašovací údaje
   ```

4. **Vytvoření databáze:**
   ```sql
   CREATE DATABASE recepty_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

5. **Spuštění migrací:**
   ```bash
   php spark migrate
   ```

6. **Naplnění testovacími daty (5000+ záznamů):**
   ```bash
   php spark db:seed MainSeeder
   ```

7. **Spuštění vývojového serveru:**
   ```bash
   php spark serve
   ```

8. **Otevřete prohlížeč:** `http://localhost:8080`

### Výchozí přihlašovací údaje
| Uživatel | Heslo | Role |
|----------|-------|------|
| admin | Admin123! | admin |
| jancik | Jancik123! | user |
| horak | Horak123! | user |

---

## Technické požadavky – splnění

| Požadavek | Splněno | Popis |
|-----------|---------|-------|
| 5+ tabulek | ✅ | 6 tabulek (users, categories, recipes, ingredients, recipe_ingredients, images) |
| 15+ sloupců (bez PK/FK) | ✅ | 18+ sloupců bez primárních a cizích klíčů |
| 5000+ záznamů | ✅ | Seedery generují 600+ receptů, 100+ ingrediencí, 5000+ propojení |
| Sloupec s obrázky | ✅ | `images.filename`, `recipes.image_path` |
| Sloupec s datem | ✅ | `created_at`, `updated_at`, `published_at` |
| Sloupec s dlouhým textem | ✅ | `recipes.description` (LONGTEXT, 1000+ znaků) |
| CRUD pro jednu tabulku | ✅ | Recepty, kategorie, galerie |
| Mazání s modálním oknem | ✅ | Bootstrap modal s potvrzením |
| Flash zprávy po operacích | ✅ | Alert po přidání/editaci/smazání |
| Soft deletes | ✅ | `deleted_at` timestamp ve všech tabulkách |
| Dropdown (neválitelná první volba) | ✅ | Kategorie v receptu, recept v galerii |
| Upload souborů | ✅ | Obrázky v receptech a galerii |
| WYSIWYG editor | ✅ | TinyMCE pro popis receptu |
| Galerie v kartách se stránkováním | ✅ | Gallery controller s konfigurovatelným stránkováním |
| Breadcrumbs | ✅ | BreadcrumbHelper na všech stránkách |
| Přihlášení | ✅ | Auth controller + AuthFilter |
| Joiny | ✅ | RecipeModel::getWithDetails() - JOIN recipes+categories+users |
| Agregace | ✅ | CategoryModel::getWithRecipeCount() - COUNT receptů |
| Routa se 2 parametry | ✅ | `/recepty/kategorie/{id}/autor/{id}` |
| Malé controllery + knihovny | ✅ | SlugHelper, UploadHelper, BreadcrumbHelper, FormHelper |
| Komentáře u metod knihoven | ✅ | PHPDoc komentáře s @param a @return |
| Zobrazení/skrytí hesla | ✅ | JavaScript toggle na login stránce |
| Dokumentace | ✅ | Tento soubor |
