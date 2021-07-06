<?php

declare(strict_types=1);

namespace App\Trait;

use Symfony\Component\Finder\Finder;

trait AutoloadFiles
{
    private function loadClassesInDir(string $dir = __DIR__, string $namespace): void
    {
        $finder = new Finder();
        $finder->files()->in($dir)->name('*.php')->notName('Abstract*')->notName('*Interface.php')->notName(
            '*Service.php'
        );

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getBasename('.php');

            // Trick to load classes to declared classes
            $vars = get_class_vars($namespace . "\\" . $absoluteFilePath);
        }
    }

    public function getClassesImplementingInterface(string $interface): array
    {
        $dir = __DIR__ . '/../';
        $namespaceFragments = explode('\\', $interface);
        $namespaceFragments = array_slice($namespaceFragments, 1, -1);
        $namespace = implode("/", $namespaceFragments);

        $this->loadClassesInDir($dir . $namespace, "App\\" . $namespace);

        $ret = [];
        foreach (get_declared_classes() as $className) {
            if (is_subclass_of(
                    $className,
                    $interface
                ) || in_array($interface, class_implements($className), true)) {
                $ret[] = $className;
            }
        }

        return $ret;
    }
}