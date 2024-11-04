<?php

namespace App\Command\Group;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'ShowGroupCommand',
    description: 'Show one group',
)]
class ShowGroupCommand extends Command
{
    protected static $defaultName = 'app:group-show';
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->addArgument('id', InputArgument::REQUIRED, 'Group ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $response = $this->client->request('GET', "http://api_server/api/group/{$id}");
        $group = $response->toArray();

        $output->writeln('Group ID - '.$group['id'].', Group name - '.$group['name']);

        return Command::SUCCESS;
    }
}
