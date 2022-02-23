<?php

namespace Savannabits\AcaciaGenerator\Lumen;

use Savannabits\AcaciaGenerator\FileRepository;

class LumenFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
