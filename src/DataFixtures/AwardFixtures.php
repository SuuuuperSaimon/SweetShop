<?php

namespace App\DataFixtures;

use App\Entity\Award;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AwardFixtures
 *
 * @package App\DataFixtures
 */
class AwardFixtures extends BaseFixture
{
    private static $awardTitle = [
        'Кондитер года 2018-2019',
        'Кондитер года 2019-2020',
        'Предприятие года 2017',
        'Качественный продукт 2019',
        'Выбор года 2017',
    ];

    /** @param ObjectManager $manager */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany( Award::class, 5, function (Award $award, $count){

            $award->setAwardName($this->faker->randomElement(self::$awardTitle))
                  ->setAwardDescription($this->faker->realText($maxNbChars= 2000, $indexSize = 2))
                  ->setAwardImage($this->faker->image($dir = 'public/img/awards/', $width = 300, $height = 450));
        });

        $manager->flush();
    }
}