CREATE TABLE IF NOT EXISTS `#__tinypayment_paymentinfo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`pay_title` varchar(100) NOT NULL,
	`pay_description` text NOT NULL,
	`payer_name` varchar(250) NOT NULL,
	`payer_mobile` varchar(12) NOT NULL,
	`payer_email` varchar(255) NOT NULL,
	`payer_ip` varchar(255) NOT NULL,
	`admin_description` text NOT NULL,
	`order_status` tinyint(2) DEFAULT '0',
	`create_time` int(11) NOT NULL,
	`edit_time` int(11) NOT NULL,
	`cryptuid` varchar(255) NOT NULL,
	`salt` varchar(255) NOT NULL,
	`uniq` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__tinypayment_transactions` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`port_id` tinyint(2) UNSIGNED NOT NULL,
	`price` decimal(15,2) NOT NULL,
	`ref_id` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
	`tracking_code` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
	`cardNumber` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`payment_date` int(11) NULL DEFAULT NULL,
	`last_change_date` int(11) NOT NULL,
	`payment_id` int(11) NOT NULL,
	`uniq` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`payment_id`),
	CONSTRAINT `fk_payment_id` FOREIGN KEY (`payment_id`) REFERENCES `#__tinypayment_paymentinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE IF NOT EXISTS `#__tinypayment_status_log` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`transaction_id` int(11) NOT NULL,
	`result_code` varchar(250) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
	`result_message` varchar(255) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
	`log_date` int(11) NOT NULL,
	`uniq` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`transaction_id`),
	CONSTRAINT `fk_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `#__tinypayment_paymentinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `#__tinypayment_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` int(10) NOT NULL,
  `end_date` int(10) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__tinypayment_form_logs` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `user_id` int(15) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `input_string` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__tinypayment_msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `port_id` tinyint(2) NOT NULL,
  `msg_id` varchar(250) NOT NULL,
  `msg` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `#__tinypayment_msgs` (`id`, `port_id`, `msg_id`, `msg`) VALUES
(1, 3, '11', 'شماره کارت نامعتبر است'),
(2, 3, '12', 'موجودي کافي نيست'),
(3, 3, '13', 'رمز نادرست است'),
(4, 3, '14', 'تعداد دفعات وارد کردن رمز بيش از حد مجاز است'),
(5, 3, '15', 'کارت نامعتبر است'),
(6, 3, '17', 'کاربر از انجام تراکنش منصرف شده است'),
(7, 3, '18', 'تاريخ انقضاي کارت گذشته است'),
(8, 3, '21', 'پذيرنده نامعتبر است'),
(9, 3, '22', 'ترمينال مجوز ارايه سرويس درخواستي را ندارد'),
(10, 3, '23', 'خطاي امنيتي رخ داده است'),
(11, 3, '24', 'اطلاعات کاربري پذيرنده نامعتبر است'),
(12, 3, '25', 'مبلغ نامعتبر است'),
(13, 3, '31', 'پاسخ نامعتبر است'),
(14, 3, '32', 'فرمت اطلاعات وارد شده صحيح نمي باشد'),
(15, 3, '33', 'حساب نامعتبر است'),
(16, 3, '34', 'خطاي سيستمي'),
(17, 3, '35', 'تاريخ نامعتبر است'),
(18, 3, '41', 'شماره درخواست تکراري است'),
(19, 3, '42', 'تراکنش Sale يافت نشد'),
(20, 3, '43', 'قبلا درخواست Verify داده شده است'),
(21, 3, '44', 'درخواست Verify يافت نشد'),
(22, 3, '45', 'تراکنش Settle شده است'),
(23, 3, '46', 'تراکنش Settle نشده است'),
(24, 3, '47', 'تراکنش Settle يافت نشد'),
(25, 3, '48', 'تراکنش Reverse شده است'),
(26, 3, '49', 'تراکنش Refund يافت نشد'),
(27, 3, '51', 'تراکنش تکراري است'),
(28, 3, '52', 'سرويس درخواستي موجود نمي باشد'),
(29, 3, '54', 'تراکنش مرجع موجود نيست'),
(30, 3, '55', 'تراکنش نامعتبر است'),
(31, 3, '61', 'خطا در واريز'),
(32, 3, '100', 'تراکنش با موفقيت انجام شد.'),
(33, 3, '111', 'صادر کننده کارت نامعتبر است'),
(34, 3, '112', 'خطاي سوئيچ صادر کننده کارت'),
(35, 3, '113', 'پاسخي از صادر کننده کارت دريافت نشد'),
(36, 3, '114', 'دارنده کارت مجاز به انجام اين تراکنش نيست'),
(37, 3, '412', 'شناسه قبض نادرست است'),
(38, 3, '413', 'شناسه پرداخت نادرست است'),
(39, 3, '414', 'سازمان صادر کننده قبض نامعتبر است'),
(40, 3, '415', 'زمان جلسه کاري به پايان رسيده است'),
(41, 3, '416', 'خطا در ثبت اطلاعات'),
(42, 3, '417', 'شناسه پرداخت کننده نامعتبر است'),
(43, 3, '418', 'اشکال در تعريف اطلاعات مشتري'),
(44, 3, '419', 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است'),
(45, 3, '421', 'IP نامعتبر است'),
(46, 3, '500', 'کاربر به صفحه زرین پال رفته ولي هنوز بر نگشته است'),
(47, 0, 'hck', 'شماره درخواست شما تکراری می باشد . لطف مجددا امتحان کنید'),
(48, 0, 'empty', 'در حال حاضر این درگاه غیر فعال می باشد'),
(49, 0, 'hck2', 'لطفا از کاراکترهای مجاز استفاده کنید'),
(50, 0, 'hck3', 'این کاربر یک بات است'),
(51, 0, '1000', 'مبلغ وارد شده کمتر از ۱۰۰۰ ریال است'),
(52, 0, 'token', 'جلسه کاربری شما منقضی شده است');
