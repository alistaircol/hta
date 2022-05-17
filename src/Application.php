<?php

declare(strict_types=1);

namespace Alistaircol\Hta;

use Alistaircol\Hta\Domain\Basket\Concerns\BasketInterface;
use Alistaircol\Hta\Domain\Basket\InMemoryBasket;
use Alistaircol\Hta\Domain\Basket\SqliteBasket;
use League\Container\Container;
use PDO;

class Application
{
    protected Container $container;

    public function __construct()
    {
        $this->container = new Container();

        // Default is inmemory
        $this->container->add(BasketInterface::class, InMemoryBasket::class);

        // Bind InMemoryBasket to the basket container as default
        $this->container->add(InMemoryBasket::class);

        // Add sqlite basket implementation to container
        $this->container->add(SqliteBasket::class)->addMethodCall('setPdo', [PDO::class]);

        // Add PDO implementation to container
        // TODO: replace with .env and use vlucas/dotenv but this is a prototype
        $this->container->add(PDO::class)
            ->addArgument('sqlite:data.sqlite')
            ->addArgument('username')
            ->addArgument('password')
            ->addArgument([/* options */]);
    }

    public function container(): Container
    {
        return $this->container;
    }
}
