<?php

namespace App\DataFixtures;

use App\Entity\Business;
use App\Entity\City;
use App\Entity\Offer;
use App\Entity\Section;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // TOWNS
        $towns = [
            'Bélep',
            'Boulouparis',
            'Bourail',
            'Canala',
            'Dumbéa',
            'Farino',
            'Hienghène',
            'Houailou',
            'Ile des Pins',
            'Kaala-Gomen',
            'Koné',
            'Koumac',
            'La Foa',
            'Lifou',
            'Maré',
            'Moindou',
            'Mont-Dore',
            'Nouméa',
            'Ouégoa',
            'Ouvéa',
            'Paita',
            'Poindimié',
            'Ponerihouen',
            'Pouébo',
            'Pouembout',
            'Poum',
            'Poya',
            'Sarraméa',
            'Thio',
            'Touho',
            'Voh',
            'Yaté',
        ];

        foreach ($towns as $town) {
            $city = new City();
            $city->setName($town);
            $manager->persist($city);
        }

        // USER 0
        $user0 = new User();
        $user0->setUsername('+687123456');
        $user0->setEmail('user@cci-formation.nc');
        $user0->setPassword($this->encoder->encodePassword($user0, "1234"));
        $user0->setRoles(["ROLE_ADMIN"]);

        // USER 1
        $user1 = new User();
        $user1->setUsername('+687123457');
        $user1->setEmail('user@cci-formation.nc');
        $user1->setPassword($this->encoder->encodePassword($user1, "1234"));
        $user1->setRoles(["ROLE_STUDENT"]);

        // USER 2
        $user2 = new User();
        $user2->setUsername('+687123458');
        $user2->setEmail('user@cci-formation.nc');
        $user2->setPassword($this->encoder->encodePassword($user2, "1234"));
        $user2->setRoles(["ROLE_BUSINESS"]);

        // USER 3
        $user3 = new User();
        $user3->setUsername('+687123459');
        $user3->setEmail('user@cci-formation.nc');
        $user3->setPassword($this->encoder->encodePassword($user3, "1234"));
        $user3->setRoles(["ROLE_STUDENT"]);

        // USER 4
        $user4 = new User();
        $user4->setUsername('+687123450');
        $user4->setEmail('user@cci-formation.nc');
        $user4->setPassword($this->encoder->encodePassword($user4, "1234"));
        $user4->setRoles(["ROLE_BUSINESS"]);

        // BUSINESS 0
        $business0 = new Business();
        $business0->setName('business0');
        $business0->setSlogan('slogan numéro');
        $business0->setImage('/assets/img/logo-alt.png');
        $business0->setLocation('Nouméa');
        $business0->setNbEmployees('43');
        $business0->setWebsite('www.cfa.cci.nc');
        $business0->setDateFoundation(new \DateTime('06/04/2014'));
        $business0->setPhoneNumber('243145');
        $business0->setEmail('entreprise@mail.nc');
        $business0->setFacebook('facebook');
        $business0->setTwitter('twitter');
        $business0->setUser($user2);

        // BUSINESS 1
        $business1 = new Business();
        $business1->setName('business1');
        $business1->setLocation('Nouméa');
        $business1->setDescription('Description du business1 :)');
        $business1->setNbEmployees('1072');
        $business1->setWebsite('www.cfa.cci.nc');
        $business1->setDateFoundation(new \DateTime('06/10/2017'));
        $business1->setPhoneNumber('243145');
        $business1->setEmail('entreprise@mail.nc');
        $business1->setLinkedin('linkedin');
        $business1->setYoutube('Youtube');
        $business1->setUser($user4);

        // SECTION 0
        $section0 = new Section();
        $section0->setName('sections0');

        // SECTION 1
        $section1 = new Section();
        $section1->setName('sections1');

        // SECTION 2
        $section2 = new Section();
        $section2->setName('sections2');

        // SECTION 3
        $section3 = new Section();
        $section3->setName('sections3');

        // SECTION 4
        $section4 = new Section();
        $section4->setName('sections4');

        // STUDENT 0
        $student0 = new Student();
        $student0->setFirstName('John');
        $student0->setLastName('Doe');
        $student0->setAge(mt_rand(18, 40));
        $student0->setLocation('Nouméa');
        $student0->setPhoneNumber('123456');
        $student0->setEmail('test@test.test');
        $student0->setUser($user1);
        $student0->setSection($section3);

        // STUDENT 1
        $student1 = new Student();
        $student1->setFirstName('John');
        $student1->setLastName('Doe');
        $student1->setAge(mt_rand(18, 40));
        $student1->setLocation('Nouméa');
        $student1->setPhoneNumber('123456');
        $student1->setEmail('test@test.test');
        $student1->setUser($user3);
        $student1->setSection($section2);

        // OFFER 0
        $offer0 = new Offer();
        $offer0->setTitle("Offre d'emploi 0");
        $offer0->setLocation('Nouméa');
        $offer0->setDescription(mt_rand(18, 40));
        $offer0->setStatut(1);
        $offer0->setSite('www.cfa.cci.nc');
        $offer0->setPublishDate(new \DateTime('10/10/2019'));
        $offer0->setBusiness($business0);
        $offer0->setSection($section3);

        // OFFER 1
        $offer1 = new Offer();
        $offer1->setTitle("Offre d'emploi 1");
        $offer1->setLocation('Boulouparis');
        $offer1->setDescription(mt_rand(18, 40));
        $offer1->setStatut(1);
        $offer1->setSite('www.cfa.cci.nc');
        $offer1->setPublishDate(new \DateTime('06/04/2019'));
        $offer1->setBusiness($business0);
        $offer1->setSection($section3);

        // OFFER 2
        $offer2 = new Offer();
        $offer2->setTitle("Offre d'emploi 2");
        $offer2->setLocation('Boulouparis');
        $offer2->setDescription(mt_rand(18, 40));
        $offer2->setStatut(1);
        $offer2->setSite('www.cfa.cci.nc');
        $offer2->setPublishDate(new \DateTime('06/04/2018'));
        $offer2->setBusiness($business0);
        $offer2->setSection($section2);

        // OFFER 3
        $offer3 = new Offer();
        $offer3->setTitle("Offre d'emploi 3");
        $offer3->setLocation('Nouméa');
        $offer3->setDescription(mt_rand(18, 40));
        $offer3->setStatut(1);
        $offer3->setSite('www.cfa.cci.nc');
        $offer3->setPublishDate(new \DateTime('06/04/2017'));
        $offer3->setBusiness($business1);
        $offer3->setSection($section2);

        // OFFER 4
        $offer4 = new Offer();
        $offer4->setTitle("Offre d'emploi 4");
        $offer4->setLocation('Bourail');
        $offer4->setDescription(mt_rand(18, 40));
        $offer4->setStatut(1);
        $offer4->setSite('www.cfa.cci.nc');
        $offer4->setPublishDate(new \DateTime('06/04/2016'));
        $offer4->setBusiness($business1);
        $offer4->setSection($section1);

        // PERSIST DATA
        $manager->persist($user0);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $manager->persist($business0);
        $manager->persist($business1);

        $manager->persist($section0);
        $manager->persist($section1);
        $manager->persist($section2);
        $manager->persist($section3);
        $manager->persist($section4);

        $manager->persist($student0);
        $manager->persist($student1);

        $manager->persist($offer0);
        $manager->persist($offer1);
        $manager->persist($offer2);
        $manager->persist($offer3);
        $manager->persist($offer4);

        // Empty objects inserted in Database
        $manager->flush();
    }
}