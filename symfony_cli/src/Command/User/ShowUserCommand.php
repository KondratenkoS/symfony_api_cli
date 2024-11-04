<?php

namespace App\Command\User;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'ShowUserCommand',
    description: 'Show one user',
)]
class ShowUserCommand extends Command
{
    protected static $defaultName = 'app:user-show';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'User ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $response = $this->client->request('GET', "http://api_server/api/user/{$id}");
        $user = $response->toArray();

        $output->writeln(' User ID - '.$user['id'].', User name - '.$user['name'].', '.'User email - '.$user['email']);

        return Command::SUCCESS;
    }
}
