<?php

use App\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->addProjects();
    }

    private function addProjects()
    {
        if (Project::all()->count() === 0) {
            for ($i = 1; $i <= 15; $i++) {
                Project::create([
                   'title' => 'Project ' . $i,
                ]);
            }
        }
    }
}
