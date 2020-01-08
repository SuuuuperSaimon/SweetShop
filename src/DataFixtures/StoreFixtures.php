<?php


namespace App\DataFixtures;


use App\Entity\District;
use App\Entity\Shop;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class StoreFixtures
 *
 * @package App\DataFixtures
 */
class StoreFixtures extends BaseFixture
{
    /**
     * @var array
     */
    private static $districts = [
        'Киевский',
        'Московский',
        'Немышлянский',
        'Новобаварский',
        'Индустриальный',
        'Основянский',
        'Слободской',
        'Холодногорский',
        'Шевченковский',
    ];

    /**
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Shop::class, 18, function (Shop $shop, $count) {

            $shop->setShopAddress($this->faker->streetAddress)
                 ->setIsBrand($this->faker->boolean(20))
                 ->setDistrict($this->getReference($this->faker->randomElement(self::$districts)));
        });

        $manager->flush();
    }
}