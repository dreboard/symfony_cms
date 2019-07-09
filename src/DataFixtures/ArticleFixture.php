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

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 7; $i++) {
            $article = new Article();
            $title = $this->faker->sentence($nbWords = 6, $variableNbWords = true);
            $article->setTitle($title);
            $article->setSlug(str_replace(' ', '-', $title));
            $article->setContent($this->faker->text($maxNbChars = 200));
            $article->setPublishedAt(new \DateTime());
            $manager->persist($article);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
