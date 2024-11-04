<?php

namespace App\Command\User;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'DeleteUserCommand',
    description: 'Delete a user',
)]
class DeleteUserCommand extends Command
{
    protected static $defaultName = 'app:user-delete';
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

        $this->client->request('DELETE', "http://api_server/api/user/{$id}");

        $output->writeln('User deleted with success');

        return Command::SUCCESS;
    }
}
