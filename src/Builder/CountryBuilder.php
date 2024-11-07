<?php 
namespace App\Builder;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;

class CountryBuilder extends AbstractBuilder {
    public function __construct(array $countryDTO, EntityManagerInterface $em) {
        $cr = $em->getRepository(Country::class);
        $country = $cr->findOneBy(['code' => $countryDTO['code']]);
        if(null === $country) {
            $country = new Country();
            $em->persist($country);
        }
        $country->populateFromArray($countryDTO);
        $this->setInstance($country);
    }
}