<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Cases;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateSwabsCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:calculate-swabs';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Calculate swabs')
            ->setHelp('Calculate swabs based on cases, recovered and positive to negative cases')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cases = $this->em->getRepository('App:Cases')->findAll();
        /** @var Cases $case */
        foreach ($cases as $key => $case) {
            $previousCaseTotalSwabs = 0;
            if (isset($cases[$key-1])) {
                $previousCaseTotalSwabs = ($cases[$key-1])->getTotalSwabs();
            }
            $dailySwabs = (4 * ($case->getTotalPoToNe() - $case->getTotalRecovered())) + $case->getNewDailyCases();
            $totalSwabs = $previousCaseTotalSwabs + $dailySwabs;
            $case->setNewDailySwabs($dailySwabs);
            $case->setTotalSwabs($totalSwabs);
            $this->em->persist($case);
            $this->em->flush();
        }
    }
}
