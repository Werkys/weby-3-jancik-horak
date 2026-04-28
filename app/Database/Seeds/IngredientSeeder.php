<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: IngredientSeeder
 * Naplní tabulku ingrediencí pro recepty
 */
class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Mouka hladká', 'unit' => 'g'],
            ['name' => 'Mouka polohrubá', 'unit' => 'g'],
            ['name' => 'Mouka hrubá', 'unit' => 'g'],
            ['name' => 'Cukr krystal', 'unit' => 'g'],
            ['name' => 'Cukr moučka', 'unit' => 'g'],
            ['name' => 'Máslo', 'unit' => 'g'],
            ['name' => 'Olej řepkový', 'unit' => 'ml'],
            ['name' => 'Olej olivový', 'unit' => 'ml'],
            ['name' => 'Vejce', 'unit' => 'ks'],
            ['name' => 'Mléko', 'unit' => 'ml'],
            ['name' => 'Smetana ke šlehání', 'unit' => 'ml'],
            ['name' => 'Smetana kyselá', 'unit' => 'ml'],
            ['name' => 'Sůl', 'unit' => 'g'],
            ['name' => 'Pepř černý mletý', 'unit' => 'g'],
            ['name' => 'Česnek', 'unit' => 'stroužek'],
            ['name' => 'Cibule', 'unit' => 'ks'],
            ['name' => 'Mrkev', 'unit' => 'ks'],
            ['name' => 'Brambory', 'unit' => 'g'],
            ['name' => 'Rajčata', 'unit' => 'ks'],
            ['name' => 'Paprika červená', 'unit' => 'ks'],
            ['name' => 'Paprika zelená', 'unit' => 'ks'],
            ['name' => 'Zelí bílé', 'unit' => 'g'],
            ['name' => 'Špenát', 'unit' => 'g'],
            ['name' => 'Brokolice', 'unit' => 'g'],
            ['name' => 'Kuřecí prsa', 'unit' => 'g'],
            ['name' => 'Kuřecí stehna', 'unit' => 'g'],
            ['name' => 'Vepřová plec', 'unit' => 'g'],
            ['name' => 'Vepřové maso mleté', 'unit' => 'g'],
            ['name' => 'Hovězí maso', 'unit' => 'g'],
            ['name' => 'Ryba losos', 'unit' => 'g'],
            ['name' => 'Ryba treska', 'unit' => 'g'],
            ['name' => 'Krevety', 'unit' => 'g'],
            ['name' => 'Sýr eidam', 'unit' => 'g'],
            ['name' => 'Sýr parmazán', 'unit' => 'g'],
            ['name' => 'Tvaroh', 'unit' => 'g'],
            ['name' => 'Jogurt bílý', 'unit' => 'g'],
            ['name' => 'Rýže', 'unit' => 'g'],
            ['name' => 'Těstoviny', 'unit' => 'g'],
            ['name' => 'Chléb', 'unit' => 'g'],
            ['name' => 'Housky', 'unit' => 'ks'],
            ['name' => 'Droždí', 'unit' => 'g'],
            ['name' => 'Prášek do pečiva', 'unit' => 'g'],
            ['name' => 'Soda bicarbona', 'unit' => 'g'],
            ['name' => 'Čokoláda tmavá', 'unit' => 'g'],
            ['name' => 'Čokoláda mléčná', 'unit' => 'g'],
            ['name' => 'Kakao', 'unit' => 'g'],
            ['name' => 'Vanilkový cukr', 'unit' => 'g'],
            ['name' => 'Skořice', 'unit' => 'g'],
            ['name' => 'Paprika sladká', 'unit' => 'g'],
            ['name' => 'Kmín celý', 'unit' => 'g'],
            ['name' => 'Majoránka', 'unit' => 'g'],
            ['name' => 'Oregano', 'unit' => 'g'],
            ['name' => 'Bazalka', 'unit' => 'g'],
            ['name' => 'Petržel', 'unit' => 'g'],
            ['name' => 'Pažitka', 'unit' => 'g'],
            ['name' => 'Med', 'unit' => 'g'],
            ['name' => 'Ocet', 'unit' => 'ml'],
            ['name' => 'Citronová šťáva', 'unit' => 'ml'],
            ['name' => 'Sójová omáčka', 'unit' => 'ml'],
            ['name' => 'Kečup', 'unit' => 'g'],
            ['name' => 'Hořčice', 'unit' => 'g'],
            ['name' => 'Majonéza', 'unit' => 'g'],
            ['name' => 'Bílé víno', 'unit' => 'ml'],
            ['name' => 'Červené víno', 'unit' => 'ml'],
            ['name' => 'Vývar kuřecí', 'unit' => 'ml'],
            ['name' => 'Vývar hovězí', 'unit' => 'ml'],
            ['name' => 'Kukuřice', 'unit' => 'g'],
            ['name' => 'Hrách', 'unit' => 'g'],
            ['name' => 'Čočka', 'unit' => 'g'],
            ['name' => 'Fazole', 'unit' => 'g'],
            ['name' => 'Cizrna', 'unit' => 'g'],
            ['name' => 'Houby žampiony', 'unit' => 'g'],
            ['name' => 'Houby lišky', 'unit' => 'g'],
            ['name' => 'Tofu', 'unit' => 'g'],
            ['name' => 'Kokosové mléko', 'unit' => 'ml'],
            ['name' => 'Kari pasta', 'unit' => 'g'],
            ['name' => 'Zázvora čerstvý', 'unit' => 'g'],
            ['name' => 'Chilli paprička', 'unit' => 'ks'],
            ['name' => 'Avokádo', 'unit' => 'ks'],
            ['name' => 'Banán', 'unit' => 'ks'],
            ['name' => 'Jablko', 'unit' => 'ks'],
            ['name' => 'Hruška', 'unit' => 'ks'],
            ['name' => 'Jahody', 'unit' => 'g'],
            ['name' => 'Borůvky', 'unit' => 'g'],
            ['name' => 'Maliny', 'unit' => 'g'],
            ['name' => 'Mandle', 'unit' => 'g'],
            ['name' => 'Vlašské ořechy', 'unit' => 'g'],
            ['name' => 'Kešu ořechy', 'unit' => 'g'],
            ['name' => 'Slunečnicová semínka', 'unit' => 'g'],
            ['name' => 'Chia semínka', 'unit' => 'g'],
            ['name' => 'Ovesné vločky', 'unit' => 'g'],
            ['name' => 'Strouhaná čokoláda', 'unit' => 'g'],
            ['name' => 'Šlehačka', 'unit' => 'ml'],
            ['name' => 'Gelatin', 'unit' => 'g'],
            ['name' => 'Škrob kukuřičný', 'unit' => 'g'],
            ['name' => 'Sezam', 'unit' => 'g'],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($ingredients as &$ing) {
            $ing['created_at'] = $now;
            $ing['updated_at'] = $now;
        }

        $this->db->table('ingredients')->insertBatch($ingredients);
    }
}
