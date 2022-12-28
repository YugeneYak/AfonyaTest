<?php
namespace Afonya\Netdata;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\PhoneNumber\Tools\BoolField;

Loc::loadMessages(__FILE__);

/**
 * Class Table
 *
 * Fields:
 * <ul>
 * <li> id int mandatory
 * <li> inetnip text mandatory
 * <li> netname text mandatory
 * <li> orderid text mandatory
 * <li> userid text mandatory
 * <li> ripedata text mandatory
 * <li> checkedin bool mandatory
 * </ul>
 *
 * @package Bitrix\
 **/

class netdataTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'netdata';
    }

    /**
     * Returns entity map definition.
     * @return array
     * @throws
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'id',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('_ENTITY_ID_FIELD')
                ]
            ),
            new TextField(
                'inetnip',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_INETNIP_FIELD')
                ]
            ),
            new TextField(
                'netname',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_NETNAME_FIELD')
                ]
            ),
            new TextField(
                'orderid',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_ORDERID_FIELD')
                ]
            ),
            new TextField(
                'userid',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_USERID_FIELD')
                ]
            ),
            new TextField(
                'ripedata',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_RIPEDATA_FIELD')
                ]
            ),
            new BooleanField(
                'checkedin',
                [
                    'required' => true,
                    'title' => Loc::getMessage('_ENTITY_CHECKEDIN_FIELD'),
                    'values' => array('0', '1')
                ]
            ),
        ];
    }
}