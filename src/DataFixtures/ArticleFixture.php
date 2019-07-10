<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * @property \Faker\Generator faker
 */
class ArticleFixture extends Fixture
{
    private $categories = ['errors', 'exceptions', 'debugging', 'logging', 'profiling', 'tracing'];

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 7; $i++) {
            $cat = array_rand($this->categories);
            $catNum = array_rand(range(1, count($this->categories)));
            $article = new Article();
            $title = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
            $article->setTitle($title);
            $article->setSlug(str_replace(' ', '-', $title));
            $article->setContent($this->faker->text($maxNbChars = 200));
            $article->setCategory($this->categories[$catNum]);
            $article->setAuthor($this->categories[$catNum]);
            $article->setPublishedAt(new \DateTime());
            $manager->persist($article);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
