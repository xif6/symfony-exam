<?php

namespace AppBundle\Command;

use AppBundle\Entity\Food;
use AppBundle\Entity\FoodGroup;
use AppBundle\Entity\Nutrient;
use AppBundle\Entity\NutrientFood;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppImportDataCommand extends ContainerAwareCommand
{
    protected $doctrine;
    protected $em;

    protected function configure()
    {
        $this
            ->setName('app:import-data')
            ->setDescription('import table ciqual');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '2048M');
        $this->doctrine = $this->getContainer()->get('doctrine');
        $this->em = $this->doctrine->getManager();

        $converter = $this->getContainer()->get('import.csvtoarray');
        $ciqual = $converter('https://pro.anses.fr/tableciqual/Documents/Table_Ciqual_2016.csv', ';');
//        var_dump(array_unique(array_column($ciqual, 'ORIGGPFR')));


        $this->importFoodGroup($ciqual, $output);
        $this->importNutrient($ciqual, $output);
        $this->importFood($ciqual, $output);


        $output->writeln('Command result.');
    }

    protected function importNutrient($ciqual, $output)
    {
        $output->writeln('Start of Import Nutrient');
        $nutrients = array_keys(array_slice($ciqual, 4)[0]);
        $progress = new ProgressBar($output, count($nutrients));
        $progress->start();

        foreach ($nutrients as $ciqualNutrient) {
            $nutrient = $this->doctrine->getRepository('AppBundle:Nutrient')->findOneByName(utf8_encode(trim($ciqualNutrient)));
            if (!$nutrient) {
                $nutrient = new Nutrient();
                $nutrient->setName(utf8_encode(trim($ciqualNutrient)));
                $this->em->persist($nutrient);
            }
            $progress->advance();
        }
        $this->em->flush();
        $this->em->clear();
        $progress->finish();
        $output->writeln('End of Import Nutrient');
    }

    protected function importFood($ciqual, $output)
    {
        $output->writeln('Start of Import Food');
        $progress = new ProgressBar($output, count($ciqual));
        $progress->start();

        foreach ($ciqual as $ciqualFood) {
            $foodGroup = $this->doctrine->getRepository('AppBundle:FoodGroup')->findOneByName(utf8_encode(trim($ciqualFood['ORIGGPFR'])));
            $food = $this->doctrine->getRepository('AppBundle:Food')->findOneByName(utf8_encode(trim($ciqualFood['ORIGFDNM'])));
            if (!$food) {
                $food = new Food();
                $food->setName(utf8_encode(trim($ciqualFood['ORIGFDNM'])));
            }

            $ciqualNutrients = array_slice($ciqualFood, 4);
            foreach ($ciqualNutrients as $ciqualNutrient => $ciqualNutrientFood) {
                $nutrient = $this->doctrine->getRepository('AppBundle:Nutrient')->findOneByName(utf8_encode(trim($ciqualNutrient)));
                $nutrientFood = $this->doctrine->getRepository('AppBundle:NutrientFood')->findOneBy(['nutrient' => $nutrient, 'food' => $food]);
                if (!$nutrientFood) {
                    $nutrientFood = new NutrientFood();
                    $nutrientFood->setFood($food);
                    $nutrientFood->setNutrient($nutrient);
                }
                $nutrientFood->setValue(trim($ciqualNutrientFood));
                $food->addNutrientFood($nutrientFood);
                $this->em->persist($nutrientFood);
            }
            $food->setFoodGroup($foodGroup);
            $this->em->persist($food);
            $progress->advance();
            $this->em->flush();
            $this->em->clear();
        }
        $progress->finish();
        $output->writeln('End of Import Food');
    }


    protected function importFoodGroup($ciqual, $output)
    {
        $output->writeln('Start of Import FoodGroup');
        $groups = array_unique(array_column($ciqual, 'ORIGGPFR'));
        $progress = new ProgressBar($output, count($groups));
        $progress->start();

        foreach ($groups as $group) {
            $foodGroup = $this->doctrine->getRepository('AppBundle:FoodGroup')->findOneByName(utf8_encode(trim($group)));
            if (!$foodGroup) {
                $foodGroup = new FoodGroup();
                $foodGroup->setName(utf8_encode(trim($group)));
                $this->em->persist($foodGroup);
            }
            $progress->advance();
        }
        $this->em->flush();
        $this->em->clear();
        $progress->finish();
        $output->writeln('End of Import FoodGroup');
    }
}
