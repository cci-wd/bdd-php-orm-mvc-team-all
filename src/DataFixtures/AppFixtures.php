<?php

namespace App\DataFixtures;

use App\Entity\Offers;
use App\Entity\Students;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
          for ($i = 0; $i < 10; $i++) {
            $students = new Students();
            $students->setFirstName('John');
            $students->setLastName('Doe');
            $students->setAge(mt_rand(18, 40));
            $students->setLocation('c koi sa');
            $students->setPhoneNumber('123456');
            $students->setEmail('test@test.test');
            $manager->persist($students);
        }
        // $product = new Product();
        // $manager->persist($product);

        // for ($i = 0; $i < 10; $i++) {
        //     $offers = new Offers();
        //     $offers->setTitle('John Doe');
        //     $offers->setLocation('Nouméa');
        //     $offers->setDescription(mt_rand(18, 40));
        //     $offers->setStatut(1);
        //     // $offers->setPublishDate(DateTime::createFromFormat("Y-m-d H:i:s", "2019-11-27 11:37:00"));
        //     // insert datas
        //     $manager->persist($offers);
        // }

        // empty objects inserted in Databasde
        $manager->flush();
    }
}
