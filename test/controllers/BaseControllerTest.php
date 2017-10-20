<?php

use PHPUnit\Framework\TestCase;

/**
 * @covers BaseController
 */
class BaseControllerTest extends TestCase
{
    /**
     * @covers BaseController::before
     */
    public function testBefore()
    {
        $mock = $this->getMockBuilder('BaseController')
            ->disableOriginalConstructor()
            ->setMethods(array('before'))
            ->getMockForAbstractClass();

        $mock->expects($this->once())->method('before');

        $reflectedClass = new ReflectionClass('BaseController');
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
    }
}
