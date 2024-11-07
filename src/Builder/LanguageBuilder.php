<?php 
namespace App\Builder;

use App\Entity\Language;
use App\Contracts\DesignPattern\{BuilderInterface,BuilderInstanceInterface};
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;

class LanguageBuilder extends AbstractBuilder {

    public function __construct(array $languageDTO, EntityManagerInterface $em, string $locale) {
        $languageRepository = $em->getRepository(Language::class);
        $language = $languageRepository->findOneBy(['code' => $languageDTO['code'],'locale' => $locale]);
        $em = $languageRepository->getEntityManager();
        if(null===$language) {
            $language = new Language();
            $em->persist($language);
        }  
        $language->populateFromArray(array_merge($languageDTO,['locale' => $locale]));
        $this->setInstance($language);
    }
}