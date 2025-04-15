<?php

declare(strict_types=1);

namespace App\Console;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(name: 'app:security:login-rate-limiter:clear')]
final class ClearLoginRateLimiterCommand extends Command
{
    public function __construct(
        #[Autowire(service: 'cache.security.login_rate_limiter_pool')] private readonly CacheItemPoolInterface $loginRateLimiterPool
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        $this->loginRateLimiterPool->clear();

        $symfonyStyle->success('All login rate limiters have been cleared.');

        return self::SUCCESS;
    }
}