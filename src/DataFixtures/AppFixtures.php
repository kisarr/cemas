<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i < 11 ; $i++)
        {
            $article = new Article();
            $article->setTitle("Titre de l'article # $i")
                    ->setContent("Contenu de l'article #$i")
                    ->setImage("http://placehold.it/350x150")
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }
        $manager->flush();
    }
}
