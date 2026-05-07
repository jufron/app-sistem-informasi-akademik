<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

#[Signature('make:service {name}')]
#[Description('create new class and interface service patern')]
class MakeServiceCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->argument('name');

        $servicePath = app_path("Services/{$fileName}Service.php");
        $interfacePath = app_path("Services/Interfaces/{$fileName}ServiceInterface.php");
        // $abstractPath = app_path("Services/Abstracts/Base{$fileName}.php");

        File::ensureDirectoryExists(app_path('Services'));
        File::ensureDirectoryExists(app_path('Services/Interfaces'));
        // File::ensureDirectoryExists(app_path('Services/Abstracts'));

        $this->createServiceInterface($interfacePath, $fileName);
        $this->createService($servicePath, $fileName);

        $this->info("Service pattern {$fileName} generated successfully.");
    }

    // interface
    private function createServiceInterface (string $path, string $name) : void
    {
        File::put($path , "<?php

namespace App\Services\Interfaces;

interface {$name}ServiceInterface
{
    //
}");
    }

    // Service
    private function createService (string $path, string $name) : void
    {
        File::put($path, "<?php

namespace App\Services;

use App\Services\Interfaces\\{$name}ServiceInterface;

class {$name}Service extends {$name}ServiceInterface
{
    //
}
");
    }
}
