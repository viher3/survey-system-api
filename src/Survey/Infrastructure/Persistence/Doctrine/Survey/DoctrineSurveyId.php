<?php

declare(strict_types=1);

namespace SurveySystem\Survey\Infrastructure\Persistence\Doctrine\Survey;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

final class DoctrineSurveyId extends AbstractUidType
{
    private const MY_TYPE = 'SurveyId';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return parent::convertToDatabaseValue($value->value(), $platform);
    }

    public function getName(): string
    {
        return self::MY_TYPE;
    }

    protected function getUidClass(): string
    {
        return SurveyId::class;
    }
}

//final class SurveyIdType extends JsonType
//{
//    const NAME = 'survey_id';
//
//    /**
//     * @param mixed $value
//     *
//     * @return mixed|string|null
//     *
//     * @throws ConversionException
//     */
//    public function convertToDatabaseValue($value, AbstractPlatform $platform)
//    {
//        var_dump($value);die;
//        if (null === $value) {
//            return null;
//        }
//
//        return $value->toString();
//    }
//
//    /**
//     * @param $value
//     * @param AbstractPlatform $platform
//     * @return mixed|null
//     * @throws ConversionException
//     */
//    public function convertToPHPValue($value, AbstractPlatform $platform)
//    {
//        var_dump($value);die;
//        try {
//            return new SurveyId($value);
//        } catch (\Throwable $e) {
//            throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateTimeFormatString());
//        }
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function requiresSQLCommentHint(AbstractPlatform $platform)
//    {
//        return false;
//    }
//
//    /**
//     * @return string
//     */
//    public function getName()
//    {
//        return self::NAME;
//    }
//}
