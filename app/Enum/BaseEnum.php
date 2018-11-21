<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/19
 * Time: 下午5:06
 */
namespace App\Enum;

/**
 * Base Enum class
 * Create an enum by implementing this class and adding class constants.
 */
abstract class BaseEnum
{
    /**
     * Enum value
     * @var mixed
     */
    protected $value;

    /**
     * Store existing constants in a static cache per object.
     * @var array
     */

    protected static $cache = [];

    /**
     * Creates a new value of some type
     * @param mixed $value
     * @throws \ReflectionException
     */
    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . get_called_class());
        }
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns the enum key (i.e. the constant name).
     * @return mixed
     * @throws \ReflectionException
     */
    public function getKey()
    {
        return static::search($this->value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * Compares one Enum with another.
     * This method is final, for more information read https://github.com/myclabs/php-enum/issues/4
     * @param $enum
     * @return bool True if Enums are equal, false if not equal
     */
    final public function equals($enum)
    {
        return $this->getValue() === $enum->getValue() && get_called_class() == get_class($enum);
    }

    /**
     * Returns the names (keys) of all constants in the Enum class
     * @return array
     * @throws \ReflectionException
     */
    public static function keys()
    {
        return array_keys(static::toArray());
    }

    /**
     * Returns instances of the Enum class of all Enum constants
     * @return static[] Constant name in key, Enum instance in value
     * @throws \ReflectionException
     */
    public static function values()
    {
        $values = [];
        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }
        return $values;
    }

    /**
     * Returns all possible values as an array
     * @return array Constant name in key, constant value in value
     * @throws \ReflectionException
     */
    public static function toArray()
    {
        $class = get_called_class();
        if (!array_key_exists($class, static::$cache)) {
            $reflection = new \ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }
        return static::$cache[$class];
    }

    /**
     * Check if is valid enum value
     * @param $value
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValid($value)
    {
        return in_array($value, static::toArray(), true);
    }

    /**
     * Check if is valid enum key
     * @param $key
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValidKey($key)
    {
        $array = static::toArray();
        return isset($array[$key]);
    }

    /**
     * Return key for value
     * @param $value
     * @return mixed
     * @throws \ReflectionException
     */
    public static function search($value)
    {
        return array_search($value, static::toArray(), true);
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant
     * @param string $name
     * @param array $arguments
     * @return static
     * @throws \ReflectionException
     */
    public static function __callStatic($name, $arguments)
    {
        $array = static::toArray();
        if (isset($array[$name])) {
            return new static($array[$name]);
        }
        throw new \BadMethodCallException("No static method or enum constant '$name' in class " . get_called_class());
    }
}