<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/22/2017
 * Time: 12:45 AM
 */

namespace console;

require APPPATH . 'models/Entities/GameType.php';

use Doctrine\ORM\EntityManager;
use models\Entities\GameType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedGameTypesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('seed:GameTypes')
            ->setDescription('This will create the seed data for the GameType table')
            ->setHelp(<<<EOT
Run this command to  seed the GameType table.
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getHelper('em')->getEntityManager();


        $output->writeln('<info>Getting Singleplayer type...</info>');
        $singleplayer = $em->find('models\Entities\GameType', 1);

        if ($singleplayer == null) {
            $output->writeln('<comment>Does not exist. Creating new entry...</comment>');
            $singleplayer = new GameType();
            $singleplayer
                ->SetName("Singleplayer")
                ->SetLabel("Singleplayer Game")
                ->SetStartLabel("Start")
                ->SetStartUrl("/game");
            $em->persist($singleplayer);
        }

        $output->writeln(sprintf('%s<info>Name:</info>............%s', "\t", $singleplayer->GetName()));
        $output->writeln(sprintf('%s<info>Label:</info>...........%s', "\t", $singleplayer->GetLabel()));
        $output->writeln(sprintf('%s<info>Start Label:</info>.....%s', "\t", $singleplayer->GetStartLabel()));
        $output->writeln(sprintf('%s<info>Start Url:</info>.......%s', "\t", $singleplayer->GetStartUrl()));
        $output->writeln("");


        $output->writeln('<info>Getting Multiplayer type...</info>');
        $multiplayer = $em->find('models\Entities\GameType', 2);

        if ($multiplayer == null) {
            $output->writeln('<comment>Does not exist. Creating new entry...</comment>');
            $multiplayer = new GameType();
            $multiplayer
                ->SetName('Multiplayer')
                ->SetLabel('Multiplayer Game')
                ->SetStartLabel('Join Lobby')
                ->SetStartUrl("/lobby");
            $em->persist($multiplayer);
        }

        $output->writeln(sprintf('%s<info>Name:</info>............%s', "\t", $multiplayer->GetName()));
        $output->writeln(sprintf('%s<info>Label:</info>...........%s', "\t", $multiplayer->GetLabel()));
        $output->writeln(sprintf('%s<info>Start Label:</info>.....%s', "\t", $multiplayer->GetStartLabel()));
        $output->writeln(sprintf('%s<info>Start Url:</info>.......%s', "\t", $singleplayer->GetStartUrl()));
        $output->writeln("");


        $output->writeln('<info>Getting Hotseat type...</info>');
        $hotSeat = $em->find('models\Entities\GameType', 3);

        if ($hotSeat == null)
        {
            $output->writeln('<comment>Does not exist. Creating new entry...</comment>');
            $hotSeat = new GameType();
            $hotSeat
                ->SetName("Hotseat")
                ->SetLabel("Hotseat Game")
                ->SetStartLabel('Start')
                ->SetStartUrl("/game");
            $em->persist($hotSeat);
        }

        $output->writeln(sprintf('%s<info>Name:</info>............%s', "\t", $hotSeat->GetName()));
        $output->writeln(sprintf('%s<info>Label:</info>...........%s', "\t", $hotSeat->GetLabel()));
        $output->writeln(sprintf('%s<info>Start Label:</info>.....%s', "\t", $hotSeat->GetStartLabel()));
        $output->writeln(sprintf('%s<info>Start Url:</info>.......%s', "\t", $hotSeat->GetStartUrl()));
        $output->writeln("");

        $em->flush();
        $output->writeln('Done');
    }

}