<?php

namespace Laravolt\Crud;

class CrudManager
{
    private static ApiFormat $apiFormat = ApiFormat::Laravolt;

    private static PrimaryKeyFormat $primaryKeyFormat = PrimaryKeyFormat::NUMERIC;

    public static function setApiFormat(ApiFormat $format): void
    {
        self::$apiFormat = $format;
        ApiCrudController::setFormat($format);
    }

    public static function getApiFormat(): ApiFormat
    {
        return self::$apiFormat;
    }

    /**
     * @return \Laravolt\Crud\PrimaryKeyFormat
     */
    public static function getPrimaryKeyFormat(): PrimaryKeyFormat
    {
        return self::$primaryKeyFormat;
    }

    /**
     * @param \Laravolt\Crud\PrimaryKeyFormat $primaryKeyFormat
     */
    public static function setPrimaryKeyFormat(PrimaryKeyFormat $primaryKeyFormat): void
    {
        self::$primaryKeyFormat = $primaryKeyFormat;
    }
}
