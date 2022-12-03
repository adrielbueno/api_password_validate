<?php

use App\Modules\PasswordRules\Validation;
use PHPUnit\Framework\TestCase;

class AverageTest extends TestCase
{
    protected $Average;

    public function setUp()
    {

        $this->validation = new Validation();
    }



    public function testIfItWillReturnTrueAnMinUpperCase()
    {
        $password = "anc";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinLowerCase', [$password, $minimum]);
        $this->assertTrue($result);
    }

    public function testIfItWillGiveAnFalseOnMinUpperCase()
    {
        $password = "AB";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinLowerCase', [$password, $minimum]);
        $this->assertFalse($result);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
