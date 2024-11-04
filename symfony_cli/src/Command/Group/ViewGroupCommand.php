<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'ViewGroupCommand',
    description: 'View all groups',
)]
class ViewGroupCommand extends Command
{
    protected static $defaultName = 'app:group-index';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->request('GET', 'http://api_server/api/group');
        $groups = $response->toArray();

        foreach ($groups as $group) {
            $output->writeln( ' Group ID - '.$group['id'].', Group name - '.$group['name']);
        }

        return Command::SUCCESS;
    }
}