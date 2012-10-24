<?php

namespace MFB\RedirectBundle\Entity\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Smurfy\DoctrineEnumBundle\DBAL\Types\DoctrineEnumTypeAbstract;

/**
 * Enum order status type
 */
class RedirectStatusType extends DoctrineEnumTypeAbstract
{
    /**
     * @var string
     */
    protected $type = 'RedirectStatusType';

    const ENABLED  = 'Enabled';
    const DISABLED = 'Disabled';

    /**
     * @var array
     */
    public static $choices = array(
        self::ENABLED  => 'Enabled',
        self::DISABLED => 'Disabled',
    );

    /**
     * Get values for the Enum field
     *
     * @return array
     */
    public static function getChoices()
    {
        return self::$choices;
    }

    /**
     * Get values
     *
     * @static
     * @return array
     */
    public static function getValues()
    {
        return array_keys(self::$choices);
    }

    /**
     * Get readable block type
     *
     * @param string $key Key of array
     *
     * @static
     * @return mixed
     */
    public static function getReadableValue($key)
    {
        return isset(self::$choices[$key])
            ? self::$choices[$key]
            : false;
    }
}
