<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\ContentType;
use PHPOrchestra\ModelBundle\Document\FieldType;
use PHPOrchestra\ModelBundle\Document\FieldOption;
use PHPOrchestra\ModelBundle\Document\TranslatedValue;

/**
 * Class LoadContentTypeData
 */
class LoadContentTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $new = $this->generateContentTypeNews();
        $manager->persist($new);

        $car = $this->generateContentTypeCar();
        $manager->persist($car);

        $carV2 = $this->generateContentTypeCarV2();
        $manager->persist($carV2);

        $customer = $this->generateContentTypeCustomer();
        $manager->persist($customer);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 60;
    }

    /**
     * @return ContentType
     */
    protected function generateContentTypeNews()
    {
        $maxLengthOption = new FieldOption();
        $maxLengthOption->setKey('max_length');
        $maxLengthOption->setValue(25);

        $required = new FieldOption();
        $required->setKey('required');
        $required->setValue('1');

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $enLabel->setValue('Title');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $frLabel->setValue('Titre');

        $newsTitle = new FieldType();
        $newsTitle->setFieldId('title');
        $newsTitle->addLabel($enLabel);
        $newsTitle->addLabel($frLabel);
        $newsTitle->setDefaultValue('');
        $newsTitle->setSearchable(true);
        $newsTitle->setType('text');
        $newsTitle->addOption($maxLengthOption);
        $newsTitle->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Introduction');
        $frLabel->setValue('Introduction');

        $newsIntro = new FieldType();
        $newsIntro->setFieldId('intro');
        $newsIntro->addLabel($enLabel);
        $newsIntro->addLabel($frLabel);
        $newsIntro->setDefaultValue('');
        $newsIntro->setSearchable(true);
        $newsIntro->setType('text');
        $newsIntro->addOption($maxLengthOption);
        $newsIntro->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Text');
        $frLabel->setValue('Texte');

        $newsText = new FieldType();
        $newsText->setFieldId('text');
        $newsText->addLabel($enLabel);
        $newsText->addLabel($frLabel);
        $newsText->setDefaultValue('');
        $newsText->setSearchable(true);
        $newsText->setType('text');
        $newsText->addOption($maxLengthOption);
        $newsText->addOption($required);

        $en = new TranslatedValue();
        $en->setLanguage('en');
        $en->setValue('News');

        $fr = new TranslatedValue();
        $fr->setLanguage('fr');
        $fr->setValue('Actualité');

        $news = new ContentType();
        $news->setContentTypeId('news');
        $news->addName($en);
        $news->addName($fr);
        $news->setDeleted(false);
        $news->setStatus($this->getReference('status-published'));
        $news->setVersion(1);

        $news->addFieldType($newsTitle);
        $news->addFieldType($newsIntro);
        $news->addFieldType($newsText);

        return $news;
    }

    /**
     * @return ContentType
     */
    protected function generateContentTypeCar()
    {
        $maxLengthOption = new FieldOption();
        $maxLengthOption->setKey('max_length');
        $maxLengthOption->setValue(25);

        $required = new FieldOption();
        $required->setKey('required');
        $required->setValue('1');

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $enLabel->setValue('Name');

        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $frLabel->setValue('Nom');

        $carName = new FieldType();
        $carName->setFieldId('name');
        $carName->addLabel($enLabel);
        $carName->addLabel($frLabel);
        $carName->setDefaultValue('');
        $carName->setSearchable(true);
        $carName->setType('text');
        $carName->addOption($maxLengthOption);
        $carName->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Description');
        $frLabel->setValue('Description');

        $carDescription = new FieldType();
        $carDescription->setFieldId('description');
        $carDescription->addLabel($enLabel);
        $carDescription->addLabel($frLabel);
        $carDescription->setDefaultValue('');
        $carDescription->setSearchable(true);
        $carDescription->setType('text');
        $carDescription->addOption($maxLengthOption);
        $carDescription->addOption($required);

        $en = new TranslatedValue();
        $en->setLanguage('en');
        $en->setValue('Car');

        $fr = new TranslatedValue();
        $fr->setLanguage('fr');
        $fr->setValue('Voiture');

        $car = new ContentType();
        $car->setContentTypeId('car');
        $car->addName($en);
        $car->addName($fr);
        $car->setDeleted(false);
        $car->setStatus($this->getReference('status-published'));
        $car->setVersion(2);

        $car->addFieldType($carName);
        $car->addFieldType($carDescription);

        return $car;
    }

    /**
     * @return ContentType
     */
    protected function generateContentTypeCarV2()
    {
        $maxLengthOption = new FieldOption();
        $maxLengthOption->setKey('max_length');
        $maxLengthOption->setValue(25);

        $required = new FieldOption();
        $required->setKey('required');
        $required->setValue('1');

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Name');
        $frLabel->setValue('Nom');

        $carName = new FieldType();
        $carName->setFieldId('name');
        $carName->addLabel($enLabel);
        $carName->addLabel($frLabel);
        $carName->setDefaultValue('Entrez le nom de la voiture ici');
        $carName->setSearchable(true);
        $carName->setType('text');
        $carName->addOption($maxLengthOption);
        $carName->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Description');
        $frLabel->setValue('Description');

        $carDescription = new FieldType();
        $carDescription->setFieldId('description');
        $carDescription->addLabel($enLabel);
        $carDescription->addLabel($frLabel);
        $carDescription->setDefaultValue('Et ici une courte description');
        $carDescription->setSearchable(true);
        $carDescription->setType('text');
        $carDescription->addOption($maxLengthOption);
        $carDescription->addOption($required);

        $en = new TranslatedValue();
        $en->setLanguage('en');
        $en->setValue('Car');

        $fr = new TranslatedValue();
        $fr->setLanguage('fr');
        $fr->setValue('Voiture');

        $car = new ContentType();
        $car->setContentTypeId('car');
        $car->addName($en);
        $car->addName($fr);
        $car->setDeleted(false);
        $car->setStatus($this->getReference('status-draft'));
        $car->setVersion(3);

        $car->addFieldType($carName);
        $car->addFieldType($carDescription);

        return $car;
    }

    /**
     * @return ContentType
     */
    protected function generateContentTypeCustomer()
    {
        $maxLengthOption = new FieldOption();
        $maxLengthOption->setKey('max_length');
        $maxLengthOption->setValue(25);

        $required = new FieldOption();
        $required->setKey('required');
        $required->setValue('1');

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Firstname');
        $frLabel->setValue('Prénom');

        $customerFirstName = new FieldType();
        $customerFirstName->setFieldId('firstname');
        $customerFirstName->addLabel($enLabel);
        $customerFirstName->addLabel($frLabel);
        $customerFirstName->setDefaultValue('');
        $customerFirstName->setSearchable(true);
        $customerFirstName->setType('text');
        $customerFirstName->addOption($maxLengthOption);
        $customerFirstName->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Lastname');
        $frLabel->setValue('Nom de famille');

        $customerLastName = new FieldType();
        $customerLastName->setFieldId('lastname');
        $customerLastName->addLabel($enLabel);
        $customerLastName->addLabel($frLabel);
        $customerLastName->setDefaultValue('');
        $customerLastName->setSearchable(true);
        $customerLastName->setType('text');
        $customerLastName->addOption($maxLengthOption);
        $customerLastName->addOption($required);

        $enLabel = new TranslatedValue();
        $enLabel->setLanguage('en');
        $frLabel = new TranslatedValue();
        $frLabel->setLanguage('fr');
        $enLabel->setValue('Identifier');
        $frLabel->setValue('Identifiant');

        $customerIdentifier = new FieldType();
        $customerIdentifier->setFieldId('identifier');
        $customerIdentifier->addLabel($enLabel);
        $customerIdentifier->addLabel($frLabel);
        $customerIdentifier->setDefaultValue(0);
        $customerIdentifier->setSearchable(false);
        $customerIdentifier->setType('integer');
        $customerIdentifier->addOption($maxLengthOption);
        $customerIdentifier->addOption($required);

        $en = new TranslatedValue();
        $en->setLanguage('en');
        $en->setValue('Customer');

        $fr = new TranslatedValue();
        $fr->setLanguage('fr');
        $fr->setValue('Client');

        $customer = new ContentType();
        $customer->setContentTypeId('customer');
        $customer->addName($en);
        $customer->addName($fr);
        $customer->setDeleted(false);
        $customer->setStatus($this->getReference('status-published'));
        $customer->setVersion(1);

        $customer->addFieldType($customerFirstName);
        $customer->addFieldType($customerLastName);
        $customer->addFieldType($customerIdentifier);

        return $customer;
    }
}
