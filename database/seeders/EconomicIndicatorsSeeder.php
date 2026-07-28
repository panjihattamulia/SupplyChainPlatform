<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EconomicIndicatorsSeeder extends Seeder
{
    public function run(): void
    {
        $year = (int)date('Y') - 1;
        $now  = now();

        $indicators = [
            'ID' => ['gdp' => 1319100000000, 'gdp_per_capita' => 4788, 'inflation_rate' => 3.6, 'unemployment_rate' => 5.3, 'population' => 275500000, 'exports_usd' => 292000000000, 'imports_usd' => 237000000000],
            'CN' => ['gdp' => 17963000000000, 'gdp_per_capita' => 12720, 'inflation_rate' => 0.2, 'unemployment_rate' => 5.2, 'population' => 1411000000, 'exports_usd' => 3593000000000, 'imports_usd' => 3179000000000],
            'DE' => ['gdp' => 4456000000000, 'gdp_per_capita' => 52824, 'inflation_rate' => 5.9, 'unemployment_rate' => 3.1, 'population' => 84400000, 'exports_usd' => 2060000000000, 'imports_usd' => 1930000000000],
            'AU' => ['gdp' => 1723000000000, 'gdp_per_capita' => 64712, 'inflation_rate' => 5.6, 'unemployment_rate' => 3.7, 'population' => 26600000, 'exports_usd' => 410000000000, 'imports_usd' => 360000000000],
            'US' => ['gdp' => 27360000000000, 'gdp_per_capita' => 81632, 'inflation_rate' => 4.1, 'unemployment_rate' => 3.6, 'population' => 335000000, 'exports_usd' => 3050000000000, 'imports_usd' => 3830000000000],
            'GB' => ['gdp' => 3340000000000, 'gdp_per_capita' => 48866, 'inflation_rate' => 7.3, 'unemployment_rate' => 4.0, 'population' => 67700000, 'exports_usd' => 1020000000000, 'imports_usd' => 1090000000000],
            'JP' => ['gdp' => 4210000000000, 'gdp_per_capita' => 33834, 'inflation_rate' => 3.3, 'unemployment_rate' => 2.6, 'population' => 124500000, 'exports_usd' => 920000000000, 'imports_usd' => 960000000000],
            'KR' => ['gdp' => 1710000000000, 'gdp_per_capita' => 33121, 'inflation_rate' => 3.6, 'unemployment_rate' => 2.7, 'population' => 51700000, 'exports_usd' => 750000000000, 'imports_usd' => 710000000000],
            'IN' => ['gdp' => 3550000000000, 'gdp_per_capita' => 2484, 'inflation_rate' => 5.7, 'unemployment_rate' => 7.8, 'population' => 1428000000, 'exports_usd' => 770000000000, 'imports_usd' => 890000000000],
            'SG' => ['gdp' => 501000000000, 'gdp_per_capita' => 84734, 'inflation_rate' => 4.8, 'unemployment_rate' => 1.9, 'population' => 5900000, 'exports_usd' => 670000000000, 'imports_usd' => 590000000000],
            'MY' => ['gdp' => 400000000000, 'gdp_per_capita' => 11972, 'inflation_rate' => 2.5, 'unemployment_rate' => 3.4, 'population' => 33400000, 'exports_usd' => 310000000000, 'imports_usd' => 265000000000],
            'TH' => ['gdp' => 514000000000, 'gdp_per_capita' => 7172, 'inflation_rate' => 1.2, 'unemployment_rate' => 1.0, 'population' => 71800000, 'exports_usd' => 340000000000, 'imports_usd' => 315000000000],
            'VN' => ['gdp' => 430000000000, 'gdp_per_capita' => 4347, 'inflation_rate' => 3.3, 'unemployment_rate' => 2.3, 'population' => 98900000, 'exports_usd' => 375000000000, 'imports_usd' => 350000000000],
            'PH' => ['gdp' => 437000000000, 'gdp_per_capita' => 3726, 'inflation_rate' => 6.0, 'unemployment_rate' => 4.3, 'population' => 117300000, 'exports_usd' => 105000000000, 'imports_usd' => 140000000000],
            'AE' => ['gdp' => 504000000000, 'gdp_per_capita' => 52977, 'inflation_rate' => 3.1, 'unemployment_rate' => 2.75, 'population' => 9500000, 'exports_usd' => 560000000000, 'imports_usd' => 420000000000],
            'SA' => ['gdp' => 1070000000000, 'gdp_per_capita' => 32586, 'inflation_rate' => 2.3, 'unemployment_rate' => 5.1, 'population' => 32800000, 'exports_usd' => 410000000000, 'imports_usd' => 240000000000],
            'BR' => ['gdp' => 2170000000000, 'gdp_per_capita' => 10041, 'inflation_rate' => 4.6, 'unemployment_rate' => 7.8, 'population' => 216400000, 'exports_usd' => 380000000000, 'imports_usd' => 310000000000],
            'NL' => ['gdp' => 1090000000000, 'gdp_per_capita' => 61098, 'inflation_rate' => 4.1, 'unemployment_rate' => 3.6, 'population' => 17800000, 'exports_usd' => 880000000000, 'imports_usd' => 790000000000],
            'FR' => ['gdp' => 3030000000000, 'gdp_per_capita' => 44408, 'inflation_rate' => 4.9, 'unemployment_rate' => 7.3, 'population' => 68200000, 'exports_usd' => 950000000000, 'imports_usd' => 1050000000000],
            'CA' => ['gdp' => 2140000000000, 'gdp_per_capita' => 53372, 'inflation_rate' => 3.9, 'unemployment_rate' => 5.4, 'population' => 40100000, 'exports_usd' => 770000000000, 'imports_usd' => 750000000000],
            'ZA' => ['gdp' => 378000000000, 'gdp_per_capita' => 6190, 'inflation_rate' => 6.1, 'unemployment_rate' => 32.1, 'population' => 60400000, 'exports_usd' => 135000000000, 'imports_usd' => 140000000000],
            'EG' => ['gdp' => 395000000000, 'gdp_per_capita' => 3513, 'inflation_rate' => 33.8, 'unemployment_rate' => 7.0, 'population' => 112700000, 'exports_usd' => 52000000000, 'imports_usd' => 90000000000],
            'RU' => ['gdp' => 2020000000000, 'gdp_per_capita' => 13817, 'inflation_rate' => 5.9, 'unemployment_rate' => 3.0, 'population' => 144200000, 'exports_usd' => 590000000000, 'imports_usd' => 380000000000],
            'TR' => ['gdp' => 1110000000000, 'gdp_per_capita' => 12986, 'inflation_rate' => 53.9, 'unemployment_rate' => 9.4, 'population' => 85800000, 'exports_usd' => 350000000000, 'imports_usd' => 380000000000],
            'MX' => ['gdp' => 1790000000000, 'gdp_per_capita' => 13926, 'inflation_rate' => 5.5, 'unemployment_rate' => 2.8, 'population' => 128500000, 'exports_usd' => 610000000000, 'imports_usd' => 620000000000],
        ];

        foreach ($indicators as $code => $data) {
            $tb = $data['exports_usd'] - $data['imports_usd'];
            DB::table('economic_indicators')->updateOrInsert(
                ['country_code' => $code, 'year' => $year],
                array_merge($data, [
                    'trade_balance' => $tb,
                    'fetched_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now
                ])
            );
        }
    }
}
