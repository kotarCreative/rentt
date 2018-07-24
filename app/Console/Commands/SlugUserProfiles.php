<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Users\User;

class SlugUserProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates slugs for all users currently on the system.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->generateSlug();
            $user->save();
        }
    }
}
