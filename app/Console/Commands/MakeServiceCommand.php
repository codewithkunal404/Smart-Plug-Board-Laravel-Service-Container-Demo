<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Str;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new service class in app/Services directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $name = Str::studly($name); // Convert to PascalCase
        $directory = app_path('Services');
        $path = "{$directory}/{$name}.php";

        // Create folder if not exists
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Check if file already exists
        if (file_exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        // File content
        $content = <<<PHP
<?php

namespace App\Services;

class {$name}
{
    public function handle()
    {
        // Your business logic here
    }
}
PHP;

        // Write file
        file_put_contents($path, $content);

        $this->info("✅ Service created: app/Services/{$name}.php");
    }
}
