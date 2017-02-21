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

        $singleplayer = $em->find('models\Entities\GameType', 1);

        if ($singleplayer == null) {
            $singleplayer = new GameType();
            $singleplayer->SetName("Singleplayer");
            $singleplayer->SetLabel("New Singleplayer Game");
            $em->persist($singleplayer);
        }

        $multiplayer = $em->find('models\Entities\GameType', 2);

        if ($multiplayer == null) {
            $multiplayer = new GameType();
            $multiplayer->SetName("Multiplayer");
            $multiplayer->SetLabel("New Multiplayer Game");
            $em->persist($multiplayer);
        }

        $hotSeat = $em->find('models\Entities\GameType', 3);

        if ($hotSeat == null)
        {
            $hotSeat = new GameType();
            $hotSeat->SetName("Hot Seat");
            $hotSeat->SetLabel("New 2-Player Game");
            $em->persist($hotSeat);
        }

        $em->flush();

        $output->write('Done');
    }

}