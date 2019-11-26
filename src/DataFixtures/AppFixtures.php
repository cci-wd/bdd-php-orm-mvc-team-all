<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Students;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
          for ($i = 0; $i < 10; $i++) {
            $students = new Students();
            $students->setName('John Doe');
            $students->setAge(mt_rand(18, 40));
            $students->setLocation('c koi sa');
            $students->setPhoneNumber('123456');
            $students->setEmail('test@test.test');
            $manager->persist($students);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
