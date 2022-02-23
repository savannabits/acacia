<?php

namespace Savannabits\AcaciaGenerator\Laravel;

use Savannabits\AcaciaGenerator\FileRepository;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
