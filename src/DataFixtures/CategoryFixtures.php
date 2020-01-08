<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CategoryFixtures
 *
 * @package App\DataFixtures
 */
class CategoryFixtures extends BaseFixture
{
    /** @var array */
    public static $parent = [
        'Праздничные торты',
        'Торты на каждый день',
        'Весовые торты и рулеты',
        'Продукция длительного хранения',
        'Элитные пирожные',
        'Пирожные',
        'Наборы пирожных',
        'Торты на заказ',
    ];

    /** @var array*/
    public static $children = [
        'День рождения',
        'Свадьба',
        'Детский праздник',
        'Любимому мужчине',
        'День рождения фирмы',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
//        $this->createMany( Category::class, 8, function (Category $category, $count) use ($manager) {
//
//            $category->setCategoryName($this->faker->randomElement(self::$parent))
//                     ->setIsElite(true)
//                     ->
//
//        });
        foreach (self::$parent as $value) {
            $category = new Category();

            $category->setCategoryName($value);

            if($value == 'Торты на заказ') {
                $category->setIsElite(true);
                $this->addReference('parent', $category);
            }else {
                $category->setIsElite(false);
                $this->addReference($value, $category);
            }

            $manager->persist($category);
        }

        foreach (self::$children as $value) {
            $category = new Category();

            $category->setCategoryName($value)
                     ->setIsElite(true)
                     ->setParent($this->getReference('parent'));

            $manager->persist($category);
            $this->addReference($value, $category);
        }

        $manager->flush();
    }
}