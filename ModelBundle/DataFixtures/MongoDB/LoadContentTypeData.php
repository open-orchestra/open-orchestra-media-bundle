<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\ContentType;
use PHPOrchestra\ModelBundle\Document\FieldType;

/**
 * Class LoadContentTypeData
 */
class LoadContentTypeData implements FixtureInterface
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
     * @return ContentType
     */
    protected function generateContentTypeNews()
    {
        $newsTitle = new FieldType();
        $newsTitle->setFieldId('title');
        $newsTitle->setLabel('Title');
        $newsTitle->setDefaultValue('');
        $newsTitle->setSearchable(true);
        $newsTitle->setType('orchestra_text');
        $newsTitle->setSymfonyType('text');
        $newsTitle->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $newsIntro = new FieldType();
        $newsIntro->setFieldId('intro');
        $newsIntro->setLabel('Introduction');
        $newsIntro->setDefaultValue('');
        $newsIntro->setSearchable(true);
        $newsIntro->setType('orchestra_text');
        $newsIntro->setSymfonyType('text');
        $newsIntro->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $newsText = new FieldType();
        $newsText->setFieldId('text');
        $newsText->setLabel('Text');
        $newsText->setDefaultValue('');
        $newsText->setSearchable(true);
        $newsText->setType('orchestra_text');
        $newsText->setSymfonyType('text');
        $newsText->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $news = new ContentType();
        $news->setContentTypeId('news');
        $news->setName('News');
        $news->setDeleted(false);
        $news->setStatus('published');
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
        $carName = new FieldType();
        $carName->setFieldId('name');
        $carName->setLabel('Name');
        $carName->setDefaultValue('');
        $carName->setSearchable(true);
        $carName->setType('orchestra_text');
        $carName->setSymfonyType('text');
        $carName->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $carDescription = new FieldType();
        $carDescription->setFieldId('description');
        $carDescription->setLabel('Description');
        $carDescription->setDefaultValue('');
        $carDescription->setSearchable(true);
        $carDescription->setType('orchestra_text');
        $carDescription->setSymfonyType('text');
        $carDescription->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $car = new ContentType();
        $car->setContentTypeId('car');
        $car->setName('Car');
        $car->setDeleted(false);
        $car->setStatus('published');
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
        $carName = new FieldType();
        $carName->setFieldId('name');
        $carName->setLabel('Name');
        $carName->setDefaultValue('Entrez le nom de la voiture ici');
        $carName->setSearchable(true);
        $carName->setType('orchestra_text');
        $carName->setSymfonyType('text');
        $carName->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $carDescription = new FieldType();
        $carDescription->setFieldId('description');
        $carDescription->setLabel('Description');
        $carDescription->setDefaultValue('Et ici une courte description');
        $carDescription->setSearchable(true);
        $carDescription->setType('orchestra_text');
        $carDescription->setSymfonyType('text');
        $carDescription->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $car = new ContentType();
        $car->setContentTypeId('car');
        $car->setName('Car');
        $car->setDeleted(false);
        $car->setStatus('draft');
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
        $customerFirstName = new FieldType();
        $customerFirstName->setFieldId('firstname');
        $customerFirstName->setLabel('Firstname');
        $customerFirstName->setDefaultValue('');
        $customerFirstName->setSearchable(true);
        $customerFirstName->setType('orchestra_text');
        $customerFirstName->setSymfonyType('text');
        $customerFirstName->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $customerLastName = new FieldType();
        $customerLastName->setFieldId('lastname');
        $customerLastName->setLabel('Lastname');
        $customerLastName->setDefaultValue('');
        $customerLastName->setSearchable(true);
        $customerLastName->setType('orchestra_text');
        $customerLastName->setSymfonyType('text');
        $customerLastName->setOptions(array(
            'max_length' => 25,
            'required' => true
        ));

        $customerIdentifier = new FieldType();
        $customerIdentifier->setFieldId('identifier');
        $customerIdentifier->setLabel('Identifier');
        $customerIdentifier->setDefaultValue(0);
        $customerIdentifier->setSearchable(false);
        $customerIdentifier->setType('orchestra_integer');
        $customerIdentifier->setSymfonyType('integer');
        $customerIdentifier->setOptions(array(
            'rounding_mode' => 1,
            'grouping' => 2,
            'required' => false
        ));

        $customer = new ContentType();
        $customer->setContentTypeId('customer');
        $customer->setName('Customer');
        $customer->setDeleted(false);
        $customer->setStatus('published');
        $customer->setVersion(1);

        $customer->addFieldType($customerFirstName);
        $customer->addFieldType($customerLastName);
        $customer->addFieldType($customerIdentifier);

        return $customer;
    }
}
