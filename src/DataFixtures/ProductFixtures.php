<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixture
{

    /** @var array */
    public static $categories = [
        'Праздничные торты',
        'Торты на каждый день',
        'Весовые торты и рулеты',
        'Продукция длительного хранения',
        'Элитные пирожные',
        'Пирожные',
        'Наборы пирожных',
        'День рождения',
        'Свадьба',
        'Детский праздник',
        'Любимому мужчине',
        'День рождения фирмы',
    ];


    /** @param ObjectManager $manager */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Product::class, 40, function (Product $product, $count){

            $product->setProductName($this->faker->text(20))
                    ->setProductDesc($this->faker->realText($maxNbChars = 1000, $indexSize = 2))
                    ->setProductWieght($this->faker->numberBetween(1, 4))
                    ->setProductImage('sweetshop.jpg')
                    ->setIsNew(false)
                    ->setCategory($this->getReference($this->faker->randomElement(self::$categories)));
        });

        $manager->flush();
    }
}