<?php


namespace App\Model\User\Entity\User;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    public const NAME = 'user_user_email';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Email $value */
        return $value instanceof Email ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Email($value) : null;
    }

    public function getName()
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

}