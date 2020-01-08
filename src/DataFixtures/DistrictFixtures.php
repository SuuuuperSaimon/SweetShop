<?php


namespace App\DataFixtures;


use App\Entity\District;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DistrictFixtures
 *
 * @package App\DataFixtures
 */
class DistrictFixtures extends BaseFixture
{
    public static $districts = [
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

    /** @param ObjectManager $manager */
    public function loadData(ObjectManager $manager)
    {
        foreach (self::$districts as $value) {
            $district = new District();
            $district->setDistrictName($value);

            $manager->persist($district);
            $this->addReference($value, $district);
        }
        $manager->flush();
    }
}