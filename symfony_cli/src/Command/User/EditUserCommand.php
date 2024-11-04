<?php

namespace App\Command\User;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'EditUserCommand',
    description: 'Edit user',
)]
class EditUserCommand extends Command
{
    protected static $defaultName = 'api:edit-user';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'User ID')
            ->addArgument('name', InputArgument::OPTIONAL, 'User name')
            ->addArgument('email', InputArgument::OPTIONAL, 'User email');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $response = $this->client->request('PATCH', "http://api_server/api/user/{$id}/edit",
            [
                'json' => [
                    'name' => $input->getArgument('name'),
                    'email' => $input->getArgument('email'),
                ],
            ]);
        $user = $response->toArray();
        $output->writeln(' Edited user ID - '.$user['id'].', User name - '.$user['name'].', User email - '.$user['email']);

        return Command::SUCCESS;
    }
}
