<?php
/**
 * @package     Joomla - > Site and Administrator payment info
 * @subpackage  com_tinypayment
 * @copyright   trangell team => https://trangell.com
 * @copyright   Copyright (C) 20016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modelform');
jimport('joomla.event.dispatcher');

require_once JPATH_SITE .'/components/com_tinypayment/helpers/jdf.php';

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once JPATH_SITE . DS .'components'.DS.'com_tinypayment'.DS.'helpers'.DS.'tinypayment.php'; 
require_once JPATH_SITE . DS .'components'.DS.'com_tinypayment'.DS.'helpers'.DS.'zarinpal.php'; 
require_once JPATH_SITE . DS .'components'.DS.'com_tinypayment'.DS.'helpers'.DS.'otherport.php'; 
jimport('joomla.user.helper');


class TinyPaymentModelForm extends JModelForm
{
	/**
	 * @var object item
	 */
	protected $item;

	public function getForm($data = array(), $loadData = true)
	{
        $app = JFactory::getApplication('site');
		$form = $this->loadForm('com_tinypayment.form', 'form', array('control' => 'jform', 'load_data' => true));
		if (empty($form)) {
			return false;
		}
		return $form;
 
	}
	

	public function getScript() 
	{
		return '/components/com_tinypayment/models/forms/form.js';
	}

	function &getItem()
	{
 
		if (!isset($this->_item))
		{
			$cache = JFactory::getCache('com_tinypayment', '');
			$id = $this->getState('tinypayment.id');
			$this->_item =  $cache->get($id); 
			if ($this->_item === false) {
 
			}
		}
		return $this->_item;
 
	}
 	
	public function portName ($id) {
		switch(intval($id)) {
			case 3:$out = "زرین پال";break;
			default:$out = "درگاه انتخاب نشده است";break;
		}
		return $out;	
	}

	public function storePayment ($payTitle,$payDescription,$payerName,$payerMobile,$payerEmail,$payerIp,$createTime,$uniqId,$cryptUID,$salt) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('pay_title','pay_description','payer_name','payer_mobile','payer_email','payer_ip','create_time','uniq','cryptuid','salt');
		$values =  array($db->q($payTitle),$db->q($payDescription),$db->q($payerName),$db->q($payerMobile),
						$db->q($payerEmail) ,$db->q($payerIp),$db->q($createTime),$db->q($uniqId),$db->q($cryptUID),$db->q($salt));		
		$query->insert($db->qn('#__tinypayment_paymentinfo'));
		$query->columns($db->qn($columns));
		$query->values(implode(',',$values)); 
		$db->setQuery((string)$query); 
		$db->execute(); 
	}
	
	public function storeTransactions ($price,$port,$paymentId,$uniqId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('port_id','price','payment_id','uniq');
		$values =  array($db->q($port),$db->q($price),$db->q($paymentId),$db->q($uniqId));		
		$query->insert($db->qn('#__tinypayment_transactions'));
		$query->columns($db->qn($columns));
		$query->values(implode(',',$values)); 
		$db->setQuery((string)$query); 
		$db->execute(); 
	}
	
	public function storeLogs ($transaction_id,$uniqId) {
		$date = JFactory::getDate();
		$logDate = TinyPaymentHelper::convert_date_to_unix($date);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('transaction_id','uniq','log_date');
		$values =  array($db->q($transaction_id),$db->q($uniqId),$db->q($logDate));		
		$query->insert($db->qn('#__tinypayment_status_log'));
		$query->columns($db->qn($columns));
		$query->values(implode(',',$values)); 
		$db->setQuery((string)$query); 
		$db->execute(); 
	}
	
	public function getPaymentId ($payerMobile,$payerEmail,$uniqId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')
			->from($db->qn('#__tinypayment_paymentinfo'));
		$query->where(
			$db->qn('payer_mobile') . ' = ' . $db->q($payerMobile) 
							. ' AND ' . 
			$db->qn('payer_email') . ' = ' . $db->q($payerEmail)
							. ' AND ' . 
			$db->qn('uniq') . ' = ' . $db->q($uniqId)
		);
		$db->setQuery((string)$query); 
		$result = $db->loadResult();
		return $result;
	}
	
	public function getTranscationId ($port,$uniqId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id')
			->from($db->qn('#__tinypayment_transactions'));
		$query->where(
			$db->qn('port_id') . ' = ' . $db->q($port) 
							. ' AND ' . 
			$db->qn('uniq') . ' = ' . $db->q($uniqId)
		);
		$db->setQuery((string)$query); 
		$result = $db->loadResult();
		return $result;
	}
	
	public function sendpay ($payTitle,$payDescription,$payerName,$payerMobile,$payerEmail,$payerIp,$createTime,$price,$port) {
		$app	= JFactory::getApplication();
		$session = JFactory::getSession();
		if ($price >= 1000) {
			$remoteip  = other::getRealIpAddr();
			$uniqId = ip2long($remoteip).rand(ip2long($remoteip),date('now')); 
			$salt = JUserHelper::genRandomPassword(32);
			$cryptUID = JUserHelper::getCryptedPassword($uniqId, $salt);
			$session->set('uniqId', $cryptUID);
			//-------------------------------
			$this->storePayment($payTitle,$payDescription,$payerName,$payerMobile,$payerEmail,$payerIp,$createTime,$uniqId,$cryptUID,$salt); // store information of payer
			$paymentId = $this->getPaymentId ($payerMobile,$payerEmail,$uniqId); 
			$this->storeTransactions($price,$port,$paymentId,$uniqId); 
			$transaction_id = $this->getTranscationId ($port,$uniqId); 
			$this->storeLogs ($transaction_id,$uniqId);
			//-------------------------------
			switch($port) {
				case 3: 
					zarinpal::send($uniqId,$price,$port,$payDescription,$payerEmail,$payerMobile);
				break;
				default:
					other::test($uniqId);
				break;
			}
		}
		else {
			if ($session->isActive('uniqId')) { $session->clear('uniqId'); }
			$msg = $this->getTinyMsg(0,1000); 
			$link = JRoute::_('index.php?option=com_tinypayment&view=form',false);
			$app->redirect($link, '<h2>'.$msg.'</h2>', $msgType='Error'); 
		}
	}
	
	public function callback2 () {
		$app	= JFactory::getApplication();
		$session = JFactory::getSession();
		$cryptUID = $session->get('uniqId');
		
		$getData = $this::getPaymentInfo($cryptUID)[0];
		$salt = $getData->salt;
		$uniqId = $getData->uniq;
		$price = $getData->price;
		$uId = $cryptUID.':'.$salt;
		
		if (JUserHelper::verifyPassword($uniqId , $uId)) {
			$portId = $getData->port_id;
			
			switch($portId) {
				case 3: 
					zarinpal::verify($uniqId,$portId,$price);
				break;
				default:
					other::test($uniqId);
				break;
			}	
		}
		else {
			other::hack($uniqId);
		}
	}
	
	public function updateLogs ($uniqId,$r_code,$r_message) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array($db->qn('result_code') . ' = ' . $db->q($r_code),$db->qn('result_message') . ' = ' . $db->q($r_message));
		$conditions = array($db->qn('uniq') . ' = ' . $db->q($uniqId));
		$query->update($db->qn('#__tinypayment_status_log'));
		$query->set($fields);
		$query->where($conditions);
		
		$db->setQuery($query);
		$result = $db->execute();
	}
	
	public function updateTransactions($uniqId,$refId,$trackingCode,$CardNumber) {
		$date = JFactory::getDate();
		$logDate = TinyPaymentHelper::convert_date_to_unix($date);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if (isset($CardNumber)) {
			$fields = array(
				$db->qn('ref_id') . ' = ' . $db->q($refId),
				$db->qn('tracking_code') . ' = ' . $db->q($trackingCode),
				$db->qn('cardNumber') . ' = ' . $db->q($CardNumber),
				$db->qn('last_change_date') . ' = ' . $db->q($logDate)
			);
		}
		else {
			$fields = array(
				$db->qn('ref_id') . ' = ' . $db->q($refId),
				$db->qn('tracking_code') . ' = ' . $db->q($trackingCode),
				$db->qn('last_change_date') . ' = ' . $db->q($logDate)
			);
		}
		$conditions = array($db->qn('uniq') . ' = ' . $db->q($uniqId));
		$query->update($db->qn('#__tinypayment_transactions'));
		$query->set($fields);
		$query->where($conditions);
		
		$db->setQuery($query);
		$result = $db->execute();
		
		
	}
	
	public function getTinyMsg ($portId,$msgId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('msg')
			->from($db->qn('#__tinypayment_msgs'));
		$query->where(
			$db->qn('port_id') . ' = ' . $db->q($portId) 
							. ' AND ' . 
			$db->qn('msg_id') . ' = ' . $db->q($msgId)
		);
		$db->setQuery((string)$query); 
		$result = $db->loadResult();
		return $result;
	}
	
	public function getPaymentInfo($uniqId) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('tp.pay_title,tp.pay_description,tp.payer_name,tp.payer_mobile,tp.payer_email,tp.salt,tp.uniq,tp.cryptuid,
						tt.port_id,tt.price,tt.tracking_code,
						tsl.result_message,tsl.log_date')
			->from($db->qn('#__tinypayment_paymentinfo') . ' as tp')
			->leftJoin($db->qn('#__tinypayment_transactions') . ' as tt ON tt.payment_id = tp.id')
			->leftJoin($db->qn('#__tinypayment_status_log') . ' as tsl ON tsl.transaction_id = tt.id');
		$query->where($db->qn('tp.cryptuid') . ' = ' . $db->q($uniqId));
		$db->setQuery((string)$query); 
		$result = $db->loadObjectlist();
		return $result;
	}

	public function preData ($id) {
			$paymentInfo = $this->getPaymentInfo($id)[0];
			$newPaymentInfo[] = preg_replace('/\s+/', '_', $paymentInfo->payer_name);
			$newPaymentInfo[] = $paymentInfo->payer_mobile;
			$newPaymentInfo[] = $paymentInfo->payer_email;
			$newPaymentInfo[] = preg_replace('/\s+/', '_',$paymentInfo->pay_title);
			$newPaymentInfo[] = preg_replace('/\s+/', '_',$paymentInfo->pay_description);
			$newPaymentInfo[] = jdate("o/m/j",TinyPaymentHelper::convert_date_to_unix($paymentInfo->log_date));
			$newPaymentInfo[] = $this->portName($paymentInfo->port_id);
			$newPaymentInfo[] = round($paymentInfo->price,2);
			$newPaymentInfo[] = $paymentInfo->tracking_code;
			$newPaymentInfo[] = preg_replace('/\s+/', '_',$paymentInfo->result_message);
			
		return array($newPaymentInfo);
	}
	
	public function CallPdf($data) {
		$info = $this->preData($data);
		$this->pdf($info);
		$filePath = JPATH_ROOT . '/media/com_tinypayment/images/pdf/invoice-'.$info[0][8].'.pdf';
		$this->processDownload($filePath,'invoice-'. $info[0][8].'.pdf',true);
	}

	public static function pdf ($data) {
		$mainframe = JFactory::getApplication();
		$sitename = $mainframe->getCfg("sitename");
		require_once JPATH_COMPONENT_SITE . "/tcpdf/tcpdf.php";

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($sitename);
		$pdf->SetTitle('فاکتور');
		$pdf->SetSubject('فاکتور');
		$pdf->SetKeywords('فاکتور');

		// set default header data
		$pdf->SetHeaderData('tinypayment_invoice_logo.png', 30, JURI::root() , ' ', array(0,64,255), array(0,64,128));
		//$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
		}

		// set font
		$pdf->SetFont('freeserif', '', 12, '', true);
		// add a page
		$pdf->AddPage();
		$pdf->Write(0, 'فاکتور پرداخت', '', 0, 'L', true, 0, false, false, 0);
		$pdf->Ln();
		$out = '<table style="border-color: #000000;" border="1"> 
		<tbody> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][0], ENT_COMPAT, 'UTF-8')).'</td> <td>نام پرداخت کننده</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][1], ENT_COMPAT, 'UTF-8')).'</td> <td>شماره همراه پرداخت کننده</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][2], ENT_COMPAT, 'UTF-8')).'</td> <td>ایمیل پرداخت کننده</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][3], ENT_COMPAT, 'UTF-8')).'</td> <td>عنوان پرداخت کننده</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][4], ENT_COMPAT, 'UTF-8')).'</td> <td>توضیحات</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][5], ENT_COMPAT, 'UTF-8')).'</td> <td>تاریخ پرداخت</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][6], ENT_COMPAT, 'UTF-8')).'</td> <td>درگاه</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][7], ENT_COMPAT, 'UTF-8')).'</td> <td>مبلغ</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][8], ENT_COMPAT, 'UTF-8')).'</td> <td>کدپیگیری</td></tr> 
				<tr> <td>'.str_replace("_"," ",htmlspecialchars($data[0][9], ENT_COMPAT, 'UTF-8')).'</td> <td>وضعیت پرداخت</td></tr> 
				
				
		</tbody> </table>';
		$out .= '<p style="text-align: right;"> </p>
			<p dir="rtl" style="text-align: right;">کامپوننت آسان پرداخت <a href="https://trangell.com/fa/">ترانگل</a></p>';
		$pdf->writeHTML($out, true, false, false, false, '');
	
		$filePath = JPATH_ROOT . '/media/com_tinypayment/images/pdf/invoice-'.$data[0][8].'.pdf';
		$pdf->Output($filePath, 'F');
		
	}
	
	public static function processDownload($filePath, $filename, $download = false)
	{
		jimport('joomla.filesystem.file') ;						
		$fsize = @filesize($filePath);
		$mod_date = date('r', filemtime($filePath) );		
		if ($download) {
		    $cont_dis ='attachment';   
		} else {
		    $cont_dis ='inline';
		}		
		$ext = JFile::getExt($filename) ;
		$mime = 'application/pdf';

		if(ini_get('zlib.output_compression'))  {
			ini_set('zlib.output_compression', 'Off');
		}
	    header("Pragma: public");
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Expires: 0");		
	    header("Content-Transfer-Encoding: binary");
		header('Content-Disposition:' . $cont_dis .';'
			. ' filename="' . JFile::getName($filename) . '";' 
			. ' modification-date="' . $mod_date . '";'
			. ' size=' . $fsize .';'
			); 
	    header("Content-Type: "    . $mime );			
	    header("Content-Length: "  . $fsize);
	
	    if( ! ini_get('safe_mode') ) { 
		    @set_time_limit(0);
	    }
	    self::readfile_chunked($filePath);
	}
	
	public static function readfile_chunked($filename, $retbytes = true)
	{
		$chunksize = 1 * (1024 * 1024); 
		$buffer = '';
		$cnt = 0;
		$handle = fopen($filename, 'rb');
		if ($handle === false)
		{
			return false;
		}
		while (!feof($handle))
		{
			$buffer = fread($handle, $chunksize);
			echo $buffer;
			@ob_flush();
			flush();
			if ($retbytes)
			{
				$cnt += strlen($buffer);
			}
		}
		$status = fclose($handle);
		if ($retbytes && $status)
		{
			return $cnt; 
		}
		return $status;
	}
}
