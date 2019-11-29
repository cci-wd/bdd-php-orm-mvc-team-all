<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Users;
use App\Entity\Offer;
use App\Entity\Section;
use App\Entity\Student;
use App\Entity\Business;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // TOWNS
        $towns = ['Bélep','Boulouparis','Bourail','Canala','Dumbéa','Farino','Hienghène','Houailou','Ile des Pins','Kaala-Gomen','Koné','Koumac','La Foa','Lifou','Maré','Moindou','Mont-Dore','Nouméa','Ouégoa','Ouvéa','Paita','Poindimié','Ponerihouen','Pouébo','Pouembout','Poum','Poya','Sarraméa','Thio','Touho','Voh','Yaté'];
        
        foreach($towns as $town) {
            $city = new City();
            $city->setName($town);
            $manager->persist($city);
        }

        for ($i = 0; $i < 10; $i++) {

            $users = new Users();
            $users->setName('user'.+$i);
            $users->setUsername('user'.+$i);
            $users->setLocation('Nouméa');
            $users->setEmail('user@cci-formation.nc');
            $users->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RExSYWh1eTVSdnhjSFFqMw$zhyWsvYpLmNBi6L4CYFNsAs5zqsn8AUob5CHko1g1nE');
            $users->setRoles(["ROLE_APPRENANT"]);
            // BUSINESSES
            $businesses = new Business();
            $businesses->setName('businesses'.+$i);
            $businesses->setSlogan('slogan numéro '.+$i);
            $businesses->setImage('/assets/img/logo-alt.png');
            $businesses->setLocation('Nouméa');
            $businesses->setNbEmployees('10');
            $businesses->setWebsite('www.cfa.cci.nc');
            $businesses->setDateFoundation(new \DateTime('06/04/2014'));
            $businesses->setPhoneNumber('243145');
            $businesses->setEmail('entreprise@mail.nc');
            $businesses->setFacebook('facebook');
            $businesses->setTwitter('twitter');  
            $businesses->setLinkedin('linkedin');  
            $businesses->setYoutube('Youtube');
            $businesses->setUsers($users);
            // SECTIONS
            $sections = new Section();
            $sections->setName('sections'.$i);
            // STUDENTS
            $students = new Student();
            $students->setFirstName('John');
            $students->setLastName('Doe');
            $students->setAge(mt_rand(18, 40));
            $students->setLocation('c koi sa');
            $students->setPhoneNumber('123456');
            $students->setEmail('test@test.test');
            $students->setUsers($users);
            $students->setSection($sections);
            // OFFERS
            $offers = new Offer();
            $offers->setTitle("Offre d'emploi");
            $offers->setLocation('Nouméa');
            $offers->setDescription(mt_rand(18, 40));
            $offers->setStatut(1);
            $offers->setSite('www.cfa.cci.nc');
            $offers->setPublishDate(new \DateTime('06/04/2014'));
            $offers->setBusiness($businesses);
            $offers->setSection($sections);
            // PERSIST DATA             
            $manager->persist($users);           
            $manager->persist($businesses);
            $manager->persist($sections);
            $manager->persist($offers);
            $manager->persist($students);
        }   
        // empty objects inserted in Databasde
        $manager->flush();
    }
}
