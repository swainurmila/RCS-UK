<?php

namespace Database\Seeders;

use App\Models\SocietySectorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocietySectorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $sectors = [
            ['cooperative_sector_name' => "Primary Agricultural Credit Society (PACS)"],
            ['cooperative_sector_name' => "Urban Cooperative Bank (UCB)"],
            ['cooperative_sector_name' => "Dairy Cooperative"],
            ['cooperative_sector_name' => "Fishery Cooperative"],
            ['cooperative_sector_name' => "Sugar Mills Cooperative"],
            ['cooperative_sector_name' => "Handloom Textile & Weavers Cooperative"],
            ['cooperative_sector_name' => "Handicraft Cooperative"],
            ['cooperative_sector_name' => "Women Welfare Cooperative Society"],
            ['cooperative_sector_name' => "Multipurpose Cooperative"],
            ['cooperative_sector_name' => "Credit & Thrift Society"],
            ['cooperative_sector_name' => "Miscellaneous Non Credit"],
            ['cooperative_sector_name' => "Agro Processing / Industrial Cooperative"],
            ['cooperative_sector_name' => "Housing Cooperative Society"],
            ['cooperative_sector_name' => "Labour Cooperative"],
            ['cooperative_sector_name' => "Livestock & Poultry Cooperative"],
            ['cooperative_sector_name' => "Transport Cooperative"],
            ['cooperative_sector_name' => "Agriculture & Allied Cooperative"],
            ['cooperative_sector_name' => "Bee Farming Cooperative"],
            ['cooperative_sector_name' => "Consumer Cooperative"],
            ['cooperative_sector_name' => "Marketing Cooperative Society"],
            ['cooperative_sector_name' => "Educational & Training Cooperatives"],
            ['cooperative_sector_name' => "Sericulture Cooperative"],
            ['cooperative_sector_name' => "Social Welfare & Cultural Cooperative"],
            ['cooperative_sector_name' => "Tourism Cooperative"],
            ['cooperative_sector_name' => "Tribal-SC/ST Cooperative"],
        ];

        foreach ($sectors as $sector) {
            SocietySectorType::updateOrCreate([
                'cooperative_sector_name' => $sector['cooperative_sector_name'],
            ]);
        }

        $this->command->info('Society Sector Types seeded successfully!');
    }
}
