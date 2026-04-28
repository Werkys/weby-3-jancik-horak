<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: RecipeSeeder
 * Naplní tabulku receptů s 500+ záznamy
 */
class RecipeSeeder extends Seeder
{
    private array $recipeNames = [
        'Svíčková na smetaně', 'Guláš s houskovým knedlíkem', 'Řízek vídeňský', 'Rajská polévka',
        'Čočková polévka', 'Zelňačka', 'Bramboračka', 'Kulajda', 'Kuřecí vývar s nudlemi',
        'Česnečka', 'Tomato soup', 'Houbová polévka', 'Hrachová polévka', 'Boršč',
        'Francouzská cibulačka', 'Kuřecí na paprice', 'Svíčková pečeně', 'Vepřová pečeně',
        'Hovězí roštěná', 'Losos na bylinkách', 'Treska v rajčatové omáčce', 'Krevety na česneku',
        'Smažené kuře', 'Pečené kuře s rozmarýnem', 'Kuřecí stehna na grilu', 'Burger domácí',
        'Pizza Margherita', 'Pizza Quattro Formaggi', 'Lazagne boloňské', 'Těstoviny carbonara',
        'Pasta arrabiata', 'Risotto s houbami', 'Risotto s hráškem', 'Gnocchi s rajčatovou omáčkou',
        'Španělský ptáček', 'Plněná paprika', 'Sekaná', 'Fašírky', 'Řecký salát', 'Caesarův salát',
        'Waldorfský salát', 'Bramborový salát', 'Coleslaw', 'Salát s quinoa', 'Okurkový salát',
        'Čínský zeleninový salát', 'Thajský papájový salát', 'Insalata caprese', 'Hummus',
        'Guacamole', 'Tzatziki', 'Baba ghanoush', 'Bruschetta', 'Crostini s ricottou',
        'Quiche Lorraine', 'Španělská tortilla', 'Frittata se zeleninou', 'Vejce Benedikt',
        'Vaječná pomazánka', 'Palacinky s džemem', 'Americké lívance', 'Crepes suzette',
        'Waffles', 'Francouzský toast', 'Granola domácí', 'Müsli', 'Jogurt s ovocem',
        'Ovesná kaše', 'Chia pudink', 'Açaí bowl', 'Smoothie bowl', 'Smoothie zelené',
        'Limonáda domácí', 'Svařené víno', 'Horká čokoláda', 'Matcha latte', 'Chai latte',
        'Ledový čaj', 'Koktejl Mojito', 'Tiramisu', 'Panna cotta', 'Crème brûlée',
        'Cheesecake', 'Čokoládový fondán', 'Brownies', 'Perníky', 'Vánoční cukroví',
        'Medovník', 'Punčový dort', 'Ovocný dort', 'Dort piškotový', 'Marcipánový dort',
        'Mrkvový dort', 'Bábovka', 'Buchta s borůvkami', 'Tvarohový koláč', 'Štrůdl jablečný',
        'Makový závin', 'Tvarohový závin', 'Croissanty', 'Bagety', 'Chléb kváskový',
        'Celozrnný chléb', 'Rohlíky', 'Housky', 'Fougasse', 'Focaccia', 'Baguette',
        'Knedlíky houskové', 'Knedlíky bramborové', 'Knedlíky kynuté', 'Halusky',
        'Gnocchi domácí', 'Polenta', 'Bulgur s grilovanou zeleninou', 'Quinoa s avokádem',
        'Kuskus marocký', 'Pilaf', 'Biryani', 'Fried rice', 'Sushi', 'Miso polévka',
        'Ramen', 'Pad Thai', 'Tom Yum', 'Green curry', 'Butter chicken', 'Dal',
        'Falafel', 'Shawarma', 'Kebab', 'Tacos', 'Burrito', 'Quesadilla', 'Enchiladas',
        'Chili con carne', 'Nachos', 'Tortilla chips domácí', 'Ceviche', 'Paella',
        'Gazpacho', 'Chorizo con patatas', 'Moussaka', 'Spanakopita', 'Souvlaki',
        'Hummus s pitou', 'Bifteki', 'Dolmades', 'Avgolemono', 'Spanisch omelette',
        'Croûtons domácí', 'Aioli', 'Pesto bazalkové', 'Pesto červené', 'Bolognese omáčka',
        'Béchamel', 'Hollandaise', 'Chimichurri', 'Tahini dressing', 'Ranch dressing',
        'Vinaigrettte', 'Thousand island dressing', 'Teriyaki omáčka', 'Barbecue omáčka',
        'Rajčatová salsa', 'Mango chutney', 'Cibulový džem', 'Šípkový džem', 'Meruňkový džem',
        'Jahodový džem', 'Višňový kompot', 'Ovocné smoothie', 'Detox nápoj', 'Zlaté mléko',
        'Kefír domácí', 'Fermentovaná zelenina', 'Kimchi', 'Pickled okurky', 'Kvašené zelí',
        'Kysaná smetana domácí', 'Máslo přepuštěné', 'Domácí sýr', 'Ricotta domácí',
        'Crème fraîche', 'Zmrzlina vanilková', 'Zmrzlina čokoládová', 'Sorbet citronový',
        'Sorbet malinový', 'Parfait', 'Gelato pistáciové', 'Semifreddo', 'Popis zmrzliny',
        'Vafle zmrzlinové', 'Profiteroles', 'Eclair', 'Mille-feuille', 'Macaron', 'Opera dort',
        'Sachertorte', 'Schwarzwaldský dort', 'Dobostorte', 'Baumkuchen', 'Stolen',
        'Pandoro', 'Panettone', 'Baklava', 'Halva', 'Loukoumades', 'Churros',
        'Churros s čokoládou', 'Beignets', 'Donuty', 'Muffiny borůvkové', 'Muffiny čokoládové',
        'Cupcakes', 'Dortíčky petit fours', 'Pralinky', 'Truffles', 'Fudge', 'Caramel',
        'Karamelové bonbony', 'Slaný karamel', 'Popcorn slaný', 'Popcorn karamelový',
        'Müsli tyčinky', 'Energetické kuličky', 'Proteinové tyčinky', 'Granola tyčinky',
    ];

    private string $longDescription = 'Toto je podrobný popis receptu, který obsahuje veškeré informace potřebné pro přípravu tohoto výborného jídla. Příprava tohoto pokrmu vyžaduje pečlivost a trpělivost, ale výsledek stojí za to. Začněte tím, že si připravíte všechny potřebné ingredience a kuchyňské náčiní. Důkladně umyjte a nakrájejte všechnu zeleninu na stejně velké kousky, aby se vařila rovnoměrně. Maso nechte předem vychladnout na pokojovou teplotu, aby se při tepelné úpravě propeklo rovnoměrně. Dbejte na správnou teplotu oleje při smažení - příliš studený olej způsobí, že jídlo bude mastné, příliš horký olej může jídlo připálit. Sůl přidávejte postupně a chuť průběžně kontrolujte. Koření používejte střídmě, ale nebojte se experimentovat. Každý kuchař má svůj vlastní rukopis a právě to dělá vaření tak zajímavým. Pamatujte, že nejdůležitější ingrediencí je láska a trpělivost. Hotové jídlo podávejte ihned po přípravě, aby neztrácelo na chuti a kvalitě. Přeji vám dobrou chuť a hodně úspěchů v kuchyni! Nezapomeňte, že vaření je umění, které se zdokonaluje praxí. Čím více budete vařit, tím lepší budete. Sdílejte své výtvory s přáteli a rodinou a sbírejte jejich zpětnou vazbu. Vždy hledejte nové recepty a techniky, které vás inspirují. Experimentujte s různými ingrediencemi a nebojte se dělat chyby - i z chyb se člověk učí. Každé jídlo je příležitost se zdokonalit a přinést radost druhým. Toto jídlo má bohatou historii a tradici, která sahá staletí zpátky. Bylo oblíbeno mnoha generacemi a stalo se součástí naší kulinářské kultury. Příprava tohoto pokrmu je rituál, který spojuje lidi a vytváří vzpomínky. Ať již vaříte pro sebe nebo pro ostatní, věnujte tomu čas a péči, a výsledek vás potěší.';

    public function run(): void
    {
        $categories = $this->db->table('categories')->get()->getResultArray();
        $users      = $this->db->table('users')->get()->getResultArray();

        if (empty($categories) || empty($users)) {
            echo "Run CategorySeeder and UserSeeder first!\n";
            return;
        }

        $recipes = [];
        $count   = 0;

        foreach ($this->recipeNames as $name) {
            for ($i = 0; $i < 3; $i++) {
                $category     = $categories[array_rand($categories)];
                $user         = $users[array_rand($users)];
                $createdDate  = date('Y-m-d H:i:s', strtotime('-' . rand(1, 730) . ' days'));

                $recipes[] = [
                    'title'             => $name . ($i > 0 ? ' (varianta ' . ($i + 1) . ')' : ''),
                    'short_description' => 'Tradiční recept na ' . strtolower($name) . '. Snadná příprava a skvělá chuť zaručena.',
                    'description'       => $this->longDescription . ' Specificky pro recept ' . $name . ': tento pokrm se připravuje ' . ($i + 1) . '. způsobem.',
                    'image_path'        => null,
                    'user_id'           => $user['id'],
                    'category_id'       => $category['id'],
                    'prep_time_minutes' => rand(10, 180),
                    'servings'          => rand(2, 8),
                    'published_at'      => $createdDate,
                    'created_at'        => $createdDate,
                    'updated_at'        => $createdDate,
                ];

                $count++;
                if ($count % 100 === 0) {
                    $this->db->table('recipes')->insertBatch($recipes);
                    $recipes = [];
                }
            }
        }

        if (! empty($recipes)) {
            $this->db->table('recipes')->insertBatch($recipes);
        }
    }
}
