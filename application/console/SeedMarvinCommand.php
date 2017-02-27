<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/22/2017
 * Time: 12:45 AM
 */

namespace console;

use Doctrine\ORM\EntityManager;
use models\Entities\Player;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedMarvinCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('seed:marvin')
            ->setDescription("This will create the AI player for the singleplayer game type.\n He won't like it.")
            ->setHelp(<<<EOT
Run this command to create the AI player.
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getHelper('em')->getEntityManager();


        $output->writeln('<info>Checking if Marvin exists...</info>');
        /** @var Player $marvin */
        $marvin = $em->getRepository('models\Entities\Player')->findOneBy(['CharacterName' => 'Marvin']);

        if ($marvin == null) {
            $output->write('<comment>Marvin: </comment>');
            $output->writeln("<info>I think you ought to know I'm feeling very depressed.</info>");
            $marvin = new Player();
            $marvin->SetCharacterName('Marvin');
            $em->persist($marvin);
        }

        $output->write('<comment>Marvin: </comment>');
        $output->writeln("<info>Here I am, brain the size of a planet, and they ask me to play Tic Tac Toe.</info>");
    }

}