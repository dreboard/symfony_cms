<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    private $categories = ['errors', 'exceptions', 'debugging', 'logging', 'profiling', 'tracing'];

    public function __construct()
    {
        $this->faker = Factory::create();
    }
    
    public function load(ObjectManager $manager)
    {
        $count = count($this->categories);

        for ($i = 0; $i < $count; $i++) {
            $cat = array_rand($this->categories);
            $catNum = array_rand(range(1, count($this->categories)));
            $category = new Category();
            $title = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
            $category->setTitle($this->categories[$i]);
            $category->setDescription($this->faker->text($maxNbChars = 200));
            $manager->persist($category);
        }
        $manager->flush();
    }
}
