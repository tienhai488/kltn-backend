<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::whereNull('slug')->chunk(100)->each(function ($projects) {
            foreach ($projects as $project) {
                $project->update(['slug' => generateSlug($project->name, $project->id)]);
            }
        });
    }
}
