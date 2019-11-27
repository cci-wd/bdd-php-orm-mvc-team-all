<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Offers;
use App\Entity\Sections;
use App\Entity\Students;
use App\Entity\Businesses;
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

        for ($i = 0; $i < 10; $i++) {
            $offers = new Offers();
            $offers->setTitle('John Doe');
            $offers->setLocation('Nouméa');
            $offers->setDescription(mt_rand(18, 40));
            $offers->setStatut(1);
            $offers->setMinDescription('Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...');
            $offers->setSite('www.cfa.cci.nc');
            $offers->setPublishDate(new \DateTime('06/04/2014'));
            // $offers->setBusinesses(mt_rand(1, 10));
            // $offers->setSections(mt_rand(1, 3));
            $manager->persist($offers);
        }

        for ($i = 0; $i < 10; $i++) {
            $users = new Users();
            $users->setName('user'.+$i);
            $users->setUsername('user'.+$i);
            $users->setLocation('Nouméa');
            $users->setEmail('user@cci-formation.nc');
            $users->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RExSYWh1eTVSdnhjSFFqMw$zhyWsvYpLmNBi6L4CYFNsAs5zqsn8AUob5CHko1g1nE');
            $users->setRoles(["ROLE_APPRENANT"]);
            $manager->persist($users);
        }

        for ($i = 0; $i < 10; $i++) {
            $businesses = new Businesses();
            $businesses->setName('businesses'.+$i);
            $businesses->setSlogan('slogan numéro '.+$i);
            $businesses->setMinDescription('mini description');
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
            // $businesses->setUsers($i);             
            $manager->persist($businesses);
        }  
        
        for ($i = 0; $i < 3; $i++) {
            $sections = new Sections();
            $sections->setName('sections'.$i);
            $manager->persist($sections);
        }   

        // empty objects inserted in Databasde
        $manager->flush();
    }
}
