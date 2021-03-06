<?php

/*
 * This file is part of the VinceCms bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vince\Bundle\CmsBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Vince\Bundle\CmsBundle\Entity\Area;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\ConstraintViolationList;
use Vince\Bundle\CmsBundle\Entity\Template;

/**
 * Test Area validation.
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
class AreaTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    /**
     * Test validation
     *
     * @author Vincent Chalamon <vincentchalamon@gmail.com>
     */
    public function testValidation()
    {
        /**
         * @var RecursiveValidator      $validator
         * @var ConstraintViolationList $errors
         */
        $object    = new Area();
        $validator = static::$kernel->getContainer()->get('validator');

        // Test invalid object
        $errors = $validator->validate($object);
        $this->assertCount(4, $errors);

        $object->setTitle('Example');
        $object->setName('Example');
        $object->setType('text');
        $object->setTemplate(new Template());

        $errors = $validator->validate($object);
        $this->assertCount(0, $errors);
    }
}
