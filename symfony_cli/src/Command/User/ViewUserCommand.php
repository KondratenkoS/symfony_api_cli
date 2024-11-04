<?php

namespace App\Command\User;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'ViewUserCommand',
    description: 'Show all users',
)]
class ViewUserCommand extends Command
{
    protected static $defaultName = 'app:user-index';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->client->request('GET', 'http://api_server/api/user');
        $users = $response->toArray();

        foreach ($users as $user) {
            $output->writeln(' User ID - '.$user['id'].', User name - '.$user['name'].', User email - '.$user['email']);
        }

        return Command::SUCCESS;
    }
}