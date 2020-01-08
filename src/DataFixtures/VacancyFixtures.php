<?php


namespace App\DataFixtures;


use App\Entity\Vacancy;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class VacancyFixtures
 *
 * @package App\DataFixtures
 */
class VacancyFixtures extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Vacancy::class, 4, function(Vacancy $vacancy, $count){

            $vacancy->setVacancyName($this->faker->text(10))
                    ->setVacancyDescr($this->faker->realText($maxNbChars = 2000, $indexSize = 2));
        });

        $manager->flush();
    }
}