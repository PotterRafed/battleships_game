<?php

namespace Battleships;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Battleships extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}