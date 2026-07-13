<?php

namespace Database\Seeders;

use App\Models\Leagues;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leagues = [
            [
                'api_league_id' => 39,
                'name' => 'Premier League',
                'type' => 'League',
                'country' => 'England',
                'logo' => 'https://media.api-sports.io/football/leagues/39.png',
                'flag' => 'https://media.api-sports.io/flags/gb.svg',
                'season' => 2026,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'has_standings' => true,
                'meta' => [
                    'source' => 'seed',
                    'level' => 'top',
                ],
            ],
            [
                'api_league_id' => 140,
                'name' => 'La Liga',
                'type' => 'League',
                'country' => 'Spain',
                'logo' => 'https://media.api-sports.io/football/leagues/140.png',
                'flag' => 'https://media.api-sports.io/flags/es.svg',
                'season' => 2026,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'has_standings' => true,
                'meta' => [
                    'source' => 'seed',
                    'level' => 'top',
                ],
            ],
            [
                'api_league_id' => 135,
                'name' => 'Serie A',
                'type' => 'League',
                'country' => 'Italy',
                'logo' => 'https://media.api-sports.io/football/leagues/135.png',
                'flag' => 'https://media.api-sports.io/flags/it.svg',
                'season' => 2026,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'has_standings' => true,
                'meta' => [
                    'source' => 'seed',
                    'level' => 'top',
                ],
            ],
            [
                'api_league_id' => 78,
                'name' => 'Bundesliga',
                'type' => 'League',
                'country' => 'Germany',
                'logo' => 'https://media.api-sports.io/football/leagues/78.png',
                'flag' => 'https://media.api-sports.io/flags/de.svg',
                'season' => 2026,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'has_standings' => true,
                'meta' => [
                    'source' => 'seed',
                    'level' => 'top',
                ],
            ],
            [
                'api_league_id' => 61,
                'name' => 'Ligue 1',
                'type' => 'League',
                'country' => 'France',
                'logo' => 'https://media.api-sports.io/football/leagues/61.png',
                'flag' => 'https://media.api-sports.io/flags/fr.svg',
                'season' => 2026,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'has_standings' => true,
                'meta' => [
                    'source' => 'seed',
                    'level' => 'top',
                ],
            ],
        ];

        foreach ($leagues as $league) {
            Leagues::updateOrCreate(
                ['api_league_id' => $league['api_league_id']],
                $league
            );
        }
    }
}
