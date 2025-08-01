<?php

namespace Database\Seeders;

use App\Filament\Widgets\Stock;
use App\Models\Color;
use App\Models\Taille;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $stocks = [
            ['taille' => '200/260', 'color' => 'BEIGE', 'quantity' => 10],
            ['taille' => '200/260', 'color' => 'MARRON', 'quantity' => 20],
            ['taille' => '200/260', 'color' => 'BLEU', 'quantity' => 33],
            ['taille' => '200/280', 'color' => 'BEIGE', 'quantity' => 15],
            ['taille' => '200/280', 'color' => 'MARRON', 'quantity' => 8],
            ['taille' => '200/280', 'color' => 'BLEU', 'quantity' => 60],
        ];

        foreach ($stocks as $stock) {
            $taille = Taille::where('taille', $stock['taille'])->first();
            $color = Color::where('color', $stock['color'])->first();
            Stock::create(['taille_id' => $taille->id, 'color_id' => $color->id, 'quantity' => $stock['quantity']]);
        }
    }
}
