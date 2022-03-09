<?php

namespace Savannabits\Acacia\Lumen;

use Savannabits\Acacia\FileRepository;

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
