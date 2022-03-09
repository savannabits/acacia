<?php

namespace Savannabits\Acacia\Laravel;

use Savannabits\Acacia\FileRepository;

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
