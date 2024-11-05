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
    private $authors = [];
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
        $user->setUniqid(uniqid('user_', true));
        $user->setEmail('Admin@gmail.com');
        $user->setActive(true);
        $this->authors[] = $user;
        $manager->persist($user);

        for($i =1; $i <= 5; $i++){
            $user = new User();
            $user->setUsername('redac'.$i);
            $user->setRoles(['ROLE_REDAC']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'redac'.$i);
            $user->setPassword($pwdHash);
            $user->setFullname('The Redac'.$i);
            $user->setUniqid(uniqid('user_', true));
            $user->setEmail('redac'.$i.'@gmail.com');
            $user->setActive(true);
            $this->authors[] = $user;
            $manager->persist($user);
        }

        for($i =1; $i <= 24; $i++){
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setRoles(['ROLE_USER']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'redac'.$i);
            $user->setPassword($pwdHash);
            $user->setFullname('A simple user'.$i);
            $user->setUniqid(uniqid('user_', true));
            $user->setEmail('user'.$i.'@gmail.com');
            $user->setActive(true);
            $manager->persist($user);
        }
        $faker = Factory::create();
        $articles = [];

        
        for ($i = 0; $i <= 160; $i++){
            $article = new Article();
            $randUser = array_rand($this->authors);
            $article->setUser($this->authors[$randUser]);
            $title = $faker->title(mt_rand(1,7));
            $article->setTitle($title);
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            $article->setTitleSlug($slug);
            $text = $faker->text();
            $article->setText($text);
            $creationDate = $faker->dateTimeBetween('-6 months', 'now');
            $article->setArticleDateCreate($creationDate); 
            $article->setArticleDatePosted($creationDate);
            $article->setPublished(mt_rand(0,3));     
            /*
            $itsAllOrNothing = rand(0, 3);
            // It's a reference from Honkai: Star Rail, precisely Aventurine, an enemy boss.
            $publishedAt = $itsAllOrNothing ? $faker->dateTimeBetween($creationDate, 'now') : null;
            */
            $manager->persist($article);
        
        }

                $manager->flush();
    }
}