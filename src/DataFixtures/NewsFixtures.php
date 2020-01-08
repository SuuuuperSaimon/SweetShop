<?php


namespace App\DataFixtures;


use App\Entity\News;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class NewsFixtures
 *
 * @package App\DataFixtures
 */
class NewsFixtures extends  BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(News::class, 15, function (News $news, $count){

            $news->setNewsName($this->faker->text(10))
                 ->setNewsAnnotation($this->faker->text(40))
                 ->setNewsText($this->faker->realText($maxNbChars = 2000, $indexSize = 2))
                 ->setNewsDate($this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null ))
                 ->setNewsImage('sweetshop.jpg');
        });

        $manager->flush();
    }
}