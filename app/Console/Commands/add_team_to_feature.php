<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;

class add_team_to_feature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature:add_team_to_feature {team_name} {feature_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $team = Team::where('name', $this->argument('team_name'))->first();

        $users = User::where('team_id', $team->id)->get();

        $users->each(function ($user) {
            $user->giveFeature($this->argument('feature_name'));
        });

        $this->info("Gave access to '{$this->argument("feature_name")}' feature for {$users->count()} users");

        return 0;
    }
}
