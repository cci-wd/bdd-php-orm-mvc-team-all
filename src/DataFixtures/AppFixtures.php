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

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // TOWNS
        $towns = ['Bélep', 'Boulouparis', 'Bourail', 'Canala', 'Dumbéa', 'Farino', 'Hienghène', 'Houailou', 'Ile des Pins', 'Kaala-Gomen', 'Koné', 'Koumac', 'La Foa', 'Lifou', 'Maré', 'Moindou', 'Mont-Dore', 'Nouméa', 'Ouégoa', 'Ouvéa', 'Paita', 'Poindimié', 'Ponerihouen', 'Pouébo', 'Pouembout', 'Poum', 'Poya', 'Sarraméa', 'Thio', 'Touho', 'Voh', 'Yaté'];

        foreach ($towns as $town) {
            $city = new City();
            $city->setName($town);
            $manager->persist($city);
        }

        for ($i = 0; $i < 10; $i++) {

            $user = new User();
            $user->setName('user' . +$i);
            $user->setUsername('user' . +$i);
            $user->setLocation('Nouméa');
            $user->setEmail('user@cci-formation.nc');
            $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RExSYWh1eTVSdnhjSFFqMw$zhyWsvYpLmNBi6L4CYFNsAs5zqsn8AUob5CHko1g1nE');
            $user->setRoles(["ROLE_APPRENANT"]);

            // BUSINESS
            $business = new Business();
            $business->setName('businesses' . +$i);
            $business->setSlogan('slogan numéro ' . +$i);
            $business->setImage('/assets/img/logo-alt.png');
            $business->setLocation('Nouméa');
            $business->setNbEmployees('10');
            $business->setWebsite('www.cfa.cci.nc');
            $business->setDateFoundation(new \DateTime('06/04/2014'));
            $business->setPhoneNumber('243145');
            $business->setEmail('entreprise@mail.nc');
            $business->setFacebook('facebook');
            $business->setTwitter('twitter');
            $business->setLinkedin('linkedin');
            $business->setYoutube('Youtube');
            $business->setUser($user);

            // SECTION
            $section = new Section();
            $section->setName('sections' . $i);

            // STUDENT
            $student = new Student();
            $student->setFirstName('John');
            $student->setLastName('Doe');
            $student->setAge(mt_rand(18, 40));
            $student->setLocation('c koi sa');
            $student->setPhoneNumber('123456');
            $student->setEmail('test@test.test');
            $student->setUser($user);
            $student->setSection($section);

            // OFFER
            $offer = new Offer();
            $offer->setTitle("Offre d'emploi");
            $offer->setLocation('Nouméa');
            $offer->setDescription(mt_rand(18, 40));
            $offer->setStatut(1);
            $offer->setSite('www.cfa.cci.nc');
            $offer->setPublishDate(new \DateTime('06/04/2014'));
            $offer->setBusiness($business);
            $offer->setSection($section);

            // PERSIST DATA
            $manager->persist($user);
            $manager->persist($business);
            $manager->persist($section);
            $manager->persist($offer);
            $manager->persist($student);
        }
        // Empty objects inserted in Database
        $manager->flush();
    }
}
