<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

#[Signature('make:repository {name}')]
#[Description('create new class and interface repository patern')]
class MakeRepositoryCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $fileName = $this->argument('name');

        $repositoryPath = app_path("Repositories/{$fileName}Repository.php");
        $interfacePath = app_path("Repositories/Interfaces/{$fileName}RepositoryInterface.php");
        // $abstractPath = app_path("Repositories/Abstracts/Base{$fileName}.php");

        File::ensureDirectoryExists(app_path('Repositories'));
        File::ensureDirectoryExists(app_path('Repositories/Interfaces'));
        // File::ensureDirectoryExists(app_path('Repositories/Abstracts'));

        // create file
        $this->createRepositoryInterface($interfacePath, $fileName);
        $this->createRepository($repositoryPath, $fileName);

        $this->info("Repository pattern {$fileName} generated successfully.");
    }

    // interface
    private function createRepositoryInterface (string $path, string $name) : void
    {
        File::put($path, "<?php

namespace App\Repositories\Interfaces;

interface {$name}RepositoryInterface
{
    public function getAll();

    public function findById(\$id);

    public function create(array \$data);

    public function update(\$id, array \$data);
    
    public function delete(\$id);
}
");
    }

    // repository
    private function createRepository (string $path, string $name) : void
    {
        File::put($path , "<?php

namespace App\Repositories;

use App\Repositories\Interfaces\\{$name}RepositoryInterface;

class {$name}Repository extends {$name}RepositoryInterface
{
    public function getAll()
    {
        // 
    }

    public function findById(\$id)
    {
        // 
    }

    public function create(array \$data)
    {
        // 
    }

    public function update(\$id, array \$data)
    {
        // 
    }

    public function delete(\$id)
    {
        // 
    }
}
");
    }
}
