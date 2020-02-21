<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'jobs',
            'sessions',
        ]);

        $this->call(AuthTableSeeder::class);
        $this->call('CountriesTableSeeder');
         $this->call('StatesTableSeeder');
         
        //Seed the airports
//        $this->call('AirportsSeeder');
//        $this->command->info('Seeded the airports!');

        Model::reguard();
    }
}
