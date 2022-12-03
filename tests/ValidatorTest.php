<?php

use App\Modules\PasswordRules\Validation;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    protected $Validation;

    public function setUp()
    {

        $this->validation = new Validation();
    }

    /**
     * Validates the minimum number of characters in the word
     * The result of function validateMinSize should true
     */
    public function testIfItWillReturnTrueAnMinSize()
    {
        $password = "abc";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinSize', [$password, $minimum]);
        $this->assertTrue($result);
    }

    /**
     * Validates the minimum number of characters in the word
     * The result of function validateMinSize should false
     */
    public function testIfItWillGiveAnFalseOnMinSize()
    {
        $password = "ab";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinSize', [$password, $minimum]);
        $this->assertFalse($result);
    }
    
    /**
     * Validates the minimum number of characters upper case in the word
     * The result of function validateMinUpperCase should true
     */
    public function testIfItWillReturnTrueAnMinUpperCase()
    {
        $password = "ABC";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinUpperCase', [$password, $minimum]);
        $this->assertTrue($result);
    }

    /**
     * Validates the minimum number of characters upper case in the word
     * The result of function validateMinUpperCase should false
     */
    public function testIfItWillGiveAnFalseOnMinUpperCase()
    {
        $password = "Abc";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinUpperCase', [$password, $minimum]);
        $this->assertFalse($result);
    }

    /**
     * Validates the minimum number of characters lower case in the word
     * The result of function validateMinLowerCase should true
     */
    public function testIfItWillReturnTrueAnMinLowerCase()
    {
        $password = "abc";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinLowerCase', [$password, $minimum]);
        $this->assertTrue($result);
    }

    /**
     * Validates the minimum number of characters lower case in the word
     * The result of function validateMinLowerCase should false
     */
    public function testIfItWillGiveAnFalseOnMinLowerCase()
    {
        $password = "Abc";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinLowerCase', [$password, $minimum]);
        $this->assertFalse($result);
    }

    /**
     * Validates the minimum number of digits in the word
     * The result of function validateMinDigit should true
     */
    public function testIfItWillReturnTrueAnMinDigit()
    {
        $password = "123";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinDigit', [$password, $minimum]);
        $this->assertTrue($result);
    }

    /**
     * Validates the minimum number of digits in the word
     * The result of function validateMinDigit should false
     */
    public function testIfItWillGiveAnFalseOnMinDigit()
    {
        $password = "12";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinDigit', [$password, $minimum]);
        $this->assertFalse($result);
    }

    /**
     * Validates the minimum number of special characters in the word
     * The result of function validateMinSpecialChars should true
     */
    public function testIfItWillReturnTrueAnMinSpecialChars()
    {
        $password = "!@#";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinSpecialChars', [$password, $minimum]);
        $this->assertTrue($result);
    }

    /**
     * Validates the minimum number of special characters in the word
     * The result of function validateMinSpecialChars should false
     */
    public function testIfItWillGiveAnFalseOnMinSpecialChars()
    {
        $password = "!@";
        $minimum = 3;
        $result = $this->invokeMethod($this->validation, 'validateMinSpecialChars', [$password, $minimum]);
        $this->assertFalse($result);
    }

     /**
     * Validates equal letters in sequence in the word
     * The result of function validateNoRepeted should true
     */
    public function testIfItWillReturnTrueAnNoRepeted()
    {
        $password = "abc";
        $result = $this->invokeMethod($this->validation, 'validateNoRepeted', [$password]);
        $this->assertTrue($result);
    }

    /**
     * Validates equal letters in sequence in the word
     * The result of function validateNoRepeted should false
     */
    public function testIfItWillGiveAnFalseOnNoRepeted()
    {
        $password = "aab";
        $result = $this->invokeMethod($this->validation, 'validateNoRepeted', [$password]);
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
