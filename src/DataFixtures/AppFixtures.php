<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // créer trois catégories
        for($i=0; $i<3; $i++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());
            $manager->persist($category);

            // créer entre 4 et 6 articles par catégory

            $content = '<p>' . join($faker->paragraphs(5), '</p><p>') .'</p>';

            for($j = 1; $i <= mt_rand(4,6); $j++)
        {
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

            $manager->persist($article);

            // On done des commentaires à l'article

            for($k = 1; $k <= mt_rand(4, 10); $k++){

                $comment = new Comment();
                $content = '<p>' . join($faker->paragraphs(2), '</p><p>') .'</p>';

                $now = new \DateTime();
                $interval = $now->diff($article->getCreatedAt());
                $days = $interval->days;
                $minimum = '-' . $days . ' days';

                $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setArticle($article);

                $manager->persist($comment);
            }

        }
        // $product = new Product();
        // $manager->persist($product);
        
        }
        $manager->flush();
    }
}
