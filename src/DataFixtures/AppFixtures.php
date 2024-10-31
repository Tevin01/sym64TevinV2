<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Entity\Article;
use Faker\Factory;
use Cocur\Slugify;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $pwdHash = $this->passwordHasher->hashPassword($user, 'admin');
        $user->setPassword($pwdHash);
        $user->setFullname('The One and Only Admin');
        $user->setUniqid('ItsUniqID');
        $user->setEmail('Admin@gmail.com');
        $user->setActive(true);
        $manager->persist($user);

        for($i =1; $i <= 5; $i++){
            $user = new User();
            $user->setUsername('redac'.$i);
            $user->setRoles(['ROLE_REDAC']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'redac'.$i);
            $user->setPassword($pwdHash);
            $user->setFullname('The Redac'.$i);
            $user->setUniqid('TheirUniqID');
            $user->setEmail('redac'.$i.'@gmail.com');
            $user->setActive(true);
            $manager->persist($user);
        }

        for($i =1; $i <= 24; $i++){
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setRoles(['ROLE_USER']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'redac'.$i);
            $user->setPassword($pwdHash);
            $user->setFullname('A simple user'.$i);
            $user->setUniqid('EachUniqID');
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setActive(true);
            $manager->persist($user);
        }
        
        /*$faker = Factory::create();
        $articles = [];

        
        for ($i = 0; $i <= 160; $i++){
            $articles = new Article();

            $title = $faker->title(mt_rand(1,7));
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            $text = $faker->text();
            $creationDate = $faker->dateTimeBetween('-6 months', 'now');
            $itsAllOrNothing = (rand(1, 4) <= 3);
            // It's a reference from Honkai: Star Rail, precisely Aventurine, an enemy boss.
            $publishedAt = $itsAllOrNothing ? $faker->dateTimeBetween($creationDate, 'now') : null;
            $author = $faker->randomElement(['ROLE_ADMIN', 'ROLE_REDAC']);
        }*/

        $faker = Factory::create();
        $articles = [];

        for ($i = 0; $i < 160; $i++) {
            $title = $faker->sentence(rand(3, 6)); // Générer un titre
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))); // Slugify le titre
            $createdAt = $faker->dateTimeBetween('-6 months', 'now'); // Date de création
            $isPublished = $faker->boolean(75); // 75% de chances d'être publié

            $publishedAt = $isPublished ? $faker->dateTimeBetween($createdAt) : null; // Date de publication

            $authorRoles = ['ROLE_ADMIN', 'ROLE_REDAC'];
            $author = $authorRoles[array_rand($authorRoles)]; // Auteur aléatoire

            $articles[] = [
                'title' => $title,
                'titleSlug' => $slug,
                'content' => $faker->paragraphs(rand(3, 5), true), // Contenu de l'article
                'createdAt' => $createdAt,
                'publishedAt' => $publishedAt,
                'author' => $author,
            ];
        }

        for ($i =0; $i <= 6; $i++){
            $articleTitle = $faker->sentence(6);
            $slugifiedTitle = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $articleTitle)));
            $moreText = $faker->text();
        }
                $manager->flush();
    }
}