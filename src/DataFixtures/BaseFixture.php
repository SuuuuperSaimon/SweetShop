<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    /** @var Generator */
    protected $faker;

    /**
     * @param ObjectManager $em
     *
     * @return mixed
     */
    abstract protected function loadData(ObjectManager $em);

    /** @param ObjectManager $manager */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker   = Factory::create();

        $this->loadData($manager);
    }

    /**
     * @param string $className
     * @param int $count
     * @param callable $factory
     */
    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);

            $this->manager->persist($entity);
            $this->addReference($className . '_' . $i, $entity);
        }
    }

}