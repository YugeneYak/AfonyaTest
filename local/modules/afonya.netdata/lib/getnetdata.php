<?php
namespace Afonya\Netdata;
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
use Afonya\Netdata\netdataTable;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Entity;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Engine\CurrentUser;
use CModule;
use Bitrix\Main\Mail\Event;
use Bitrix\Sale;
CModule::IncludeModule('sale');

class getnetdata extends \CBitrixComponent
{

    /**
     *  @throws
     */

	const MODULE_ID = 'afonya.netdata';
	public function GetIP($arFields)
	{
        global $USER;
	   $ip=$_SERVER['REMOTE_ADDR']; //ip покупателя
        $UserId=$USER->GetID();

        $resAdd = netdataTable::add(array(
            'inetnip' => ''.$ip.'',
            'userid' => ''.$UserId.'',
            'orderid' => ''.$arFields.'',
            'inetnum' => '-',
            'netname' => '-',
            'descr' => '-',
            'country' => '-',
            'status' => '-',
            'ripedata' => '-',
            'checkedin' => '0',
        ))->getData();
        if (self::isAdminPage()) {
            return;
        }
	}

    public function GetNetData()
    {
        $checkNet='BEELINE'; //часть названия сети
        $ArrIRs = netdataTable::getList([
            'filter' => [
                '!=checkedin' => 10,
            ],
        ])->fetchAll();

foreach ($ArrIRs as $ipK=>$ipV) {
    $url = "https://rest.db.ripe.net/search.json?query-string=".$ipV['inetnip'];
    $ripedata='';
    $netname='';
    $ripedata=json_encode(json_decode(file_get_contents("$url"),true)['objects']['object']);
    $netname = json_decode(file_get_contents("$url"),true)['objects']['object'][0]['attributes']['attribute'][1]['value'];
    if (mb_strpos($netname,$checkNet)!==false) {

        $order=Sale\Order::load($ipV['orderid']);
        $order->save();

        $send= \Bitrix\Main\Mail\Event::sendImmediate(array( //нужен соответствующий почтовый шаблон
            "EVENT_NAME"=>'IM_NEW_MESSAGE',
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL" => "mail_to@domain.ru", // получатель уведомдения
                "ORDER_ID" => $ipV['orderid'],
                "IP"=>$ipV['inetnip'],
                "NET"=>$netname
            ),
        ));
    }
    $update = netdataTable:: update($ipV['id'], array (
        'netname'=>$netname,
        'ripedata'=>$ripedata,
        'checkedin'=>1
    ));
    unset($ripedata,$netname);
}
        if (self::isAdminPage()) {
            return;
        }
    }

	static private function isAdminPage()
	{
		return defined('ADMIN_SECTION');
	}
}