<?php
/**
 * @package     Joomla - > Site and Administrator payment info
 * @subpackage  com_tinypayment
 * @copyright   trangell team => https://trangell.com
 * @copyright   Copyright (C) 20016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
JHtml::stylesheet(JURI::root().'components/com_tinypayment/ui/dist/css/customadmin.css');
JHtml::stylesheet(JURI::root().'components/com_tinypayment/ui/dist/css/custom.css');
JHtml::stylesheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12">
      <div class="span12">
        <h3 class="box-title"><i class="fa fa-file-text-o"></i> راهنمای مدیریتی افزونه آسان پرداخت جامع جوملا ترانگل</h3>
        <div class="margin"></div>
        <div class="clearfix"></div>
        <span>
                            <hr />
                  <p><span style="font-family: tahoma, arial, helvetica, sans-serif; font-size: 12pt;">با درود خدمت شما مدیریت محترم . قبل از ارائه آموزش های مربوط به افزونه و مدیریت آن از شما عزیزان بخاطر انتخاب گروه <a title="گروه برنامه نویسی ترانگل" href="https://trangell.com/fa/" rel="alternate">ترانگل</a> برای توسعه وب سایت خودتان تشکر می کنیم و امید وارم با کمترین مشکل از این افزونه راضی بوده باشید. </span></p>
                  <p><span style="font-family: tahoma, arial, helvetica, sans-serif;"> </span></p>
                  <blockquote>
                  <p><span style="font-size: 9pt; font-family: tahoma, arial, helvetica, sans-serif;">لازم به ذکر هست اگر نیاز به کامپوننت ماژول و پلاگین اختصاصی دارید می توانید روی ( <a title="خدمات افزونه نویسی جوملا" href="https://trangell.com/fa/blog/6-خدمات-افزونه-نویسی" rel="alternate">خدمات افزونه نویسی جوملا</a> ) کلیک کنید. گروه <span style="color: #ff0000;">ترانگل</span> با نمونه کار های زیادی در زمینه افزونه های اختصاصی <span style="color: #ff0000;">جوملا</span> می توانید خدمات کاربردی و مناسبی را به شما ارائه بدهد .</span></p>
                  <p><span style="font-size: 9pt; font-family: tahoma, arial, helvetica, sans-serif;">۱. مشاهده <a title="افزونه های اختصاصی جوملا" href="https://trangell.com/blog/برجسب/13-افزونه-اختصاصی" rel="alternate">افزونه های اختصاصی جوملا</a></span></p>
                  <p><span style="font-size: 9pt; font-family: tahoma, arial, helvetica, sans-serif;">۲. مشاهده <a title="نمونه کار طراحی سایت" href="https://trangell.com/fa/home/portfolio" rel="alternate">نمونه کار طراحی سایت</a></span></p>
                  </blockquote>
        </span>
        <div class="clearfix"></div>
        <div class="margin"></div>
        <div class="margin"></div>

        <h3 class="box-title"><i class="fa fa-file-text-o"></i> راهنمای نصب افزونه</h3>
        <hr />
        <span>
          <p><span style="font-size: 10pt; line-height: 25px;"><a href="https://trangell.com" rel="alternate">کامپوننت آسان پرداخت جامع جوملا</a> با پشتیبانی از اکثر درگاه های ایرانی در دو نسخه ( مخصوص درگاه واسط زرین پال - نسخه پشتیبانی کامل همه درگاه ها ) منتشر شده است . این دو نسخه هیچ تفاوتی با هم ندارند فقط موردی که مخصوص <strong>زرین پال</strong> ارائه گشته دیگر درگاه ها را پشتیبانی نمی کند و کاملا کد باز می باشد ولی در نسخه دوم تمام درگاه ها پشتیبانی می شود ولی برخی از فایل های کتابخانه ای <strong>کد</strong> شده است . این مورد هیچ مشکل امنیتی برای شما مدیران/عزیزان ایجاد نمی کند و به راحتی می توانید در هر هاست اشتراکی و اختصاصی آن را نصب کنید.</span></p>
<p><span style="font-size: 10pt; line-height: 25px;">لازم به ذکر هست در اکثر هاستینگ ها و سرور ها کتابخانه سورس گاردین نصب می باشد در صورت نصب نبودن فقط کافیست به مدیر هاست پیغام ارسال کنید یا در سایت اصلی سازنده به صورت رایگان روی سرور خود نصب کنید. برای اطلاعات بیشتر می توانید به لینک زیر مراجعه کنید .<br /></span></p>
<pre class="language-markup"><code>http://www.sourceguardian.com</code></pre>
<p>توجه : مدیران محترم افزونه مذکور برای نسخه  php 5.6 نوشته شده است و آخرین نسخه جوملا یعنی 3.6.4 به بالا مورد پشتیبانی قرار می گیرد. لذا نسخه هایی که قدیمی تر هستند امکان تداخل و مشکل وجود دارد و مورد پشتیبانی تیم سازنده نمی باشد . شما به راحتی می توانید به هاستینگ خود پیغام بدهید و از آن ها درخواست کنید نسخه مناسبی از php 5.6 را روی سرویس شما فعال کنند البته اکثر هاستینگ ها همین الان هم چنین موردی را پیاده سازی کردند. و همینطور نسخه های قدیمی جوملا دارای باگ امنیتی نیز می باشد که شما را مجاب به به روز رسانی می کند .</p>
<hr />
<h3>اما دلیل ما برای این کار چیست ؟</h3>
<p>شاید شما در فکر خود گفتید چرا باید از نسخه بالای جوملا استفاده شود شاید هنوز مدیران سایت هایی باشند که به روز رسانی نکرده اند  ؟ باید در جواب این پرسش خدمت شما دوستان عزیز این مورد را متذکر بشوم که جوملا یک سیستم مدیریت محتوای کد باز و رایگان می باشد. این سیستم همیشه در حال به روز رسانی هست مخصوصا برای برنامه نویس ها نسخه 3.6 یک جهش بسیار بزرگ بوده به همین ترتیب برای امنیت بهتر و همینطور دسترسی بهتر به کتابخانه ها ما نیاز به کد های جدید داریم و از طرفی این سیستم تمام امکانات خود را برای به روز رسانی شما عزیزان بهینه کرده است تا هم از نظر امنیتی دچار مشکل نشوید و هم امکانات جدید روز را دریافت کنید آن هم به صورت رایگان  . </p>
<p>به روز رسانی جوملا بسیار راحت می باشد و در انجمن های پشتیبانی جوملا به این سوال شما پاسخ داده اند . ( با یک کلیک به روز می شود ) .</p>
<p>اما نسخه بالای  php نیز دقیقا هم چنین داستانی دارد . در نسخه php 5.6 هم خیلی از مشکلات برنامه نویسی حل شده است و هم یکی از بهترین نسخه های پی اچ پی از نظر برنامه نویسی و هم امنیت می باشد . اگر دست ما بود و واقعا مدیران به روز رسانی می کردند و هاستینگ ها نیز همراهی حتما این افزونه را با پترن php 7 می نوشتیم که سرعت دو برابر سریع تری را در خود پوشش داده است . </p>
<p>و در اخر باید خدمت دوستان این مورد را اشاره کنم اگر روی جوملای ۳.۶ به بالا هستید هیچ نگران نباشید کافیست به هاستینگ بگویید پی اچ پی شما را روی ۵.۶ نسخه مناسبش ست کند بدون هیچ تداخل در هیج جای وب سایت شما به کار خودتان ادامه بدهید .  ( اگر شما آشنایی با مدیریت سایت یا برنامه نویسی ندارید می خواهید سایت خود را با هزینه به یک گروه بسپارید روی ( <a title="پشتیبانی فنی و سئو سایت ترانگل" href="https://trangell.com/fa/blog/7-پشتیبانی-فنی-و-سئو-سایت" rel="alternate">پشتیبانی فنی و سئو سایت ترانگل</a> ) کلیک کنید در غیر این صورت انجمن های پشتیبانی جوملا می توانند به شما کمک بکنند . </p>
<p>لازم به ذکر هست ما بخشی را به عنوان پرسش و پاسخ برای شما فراهم نمودیم که می توانید در لینک به آن دست بیابید</p>
<pre class="language-markup"><code>https://trangell.com/fa/discussion</code></pre>
<hr />
<h2>نصب و استفاده از افزونه  :</h2>
<p>مثل افزونه های دیگر جوملا کافیست فقط به مدیریت افزونه مراجعه کنید بعد روی افزونه ها بزنید بعد فایل زیپ دانلودی را نصب کنید. بعد از نصب به کامپوننت ها بروید و افزونه مذکور را انتخاب کنید و بعد از آن در صفحه اصلی افزونه ( بالا سمت چپ روی انتخاب ها بزنید ) قبل از شروع حتما این تنظیمات را انجام بدهید بعد به مدیریت منو ها بروید و در آنجا منوی مورد نظر را بسازید حال زمان این هست از آن لذت ببرید . </p>
<p> </p>
<p>اما برای راحتی شما دوستان چند مطلب آموزشی در وب سایت ترانگل منتشر کردیم که به شرح زیر می باشد  :</p>
<p> </p>
<p>۱. <a href="https://trangell.com" rel="alternate">توضیحات و دانلود آخرین نسخه افزونه </a></p>
<p>۲. <a href="https://trangell.com" rel="alternate">راهنمای نصب و ویدیو آموزشی</a></p>
<p>۳. اخبار مربوط به آخرین تغییرات و آخرین نسخه های انتشار یافته ( <a href="https://trangell.com" rel="alternate">کلیک</a> کنید )<br /><br />برای استفاده از افزونه از منو های زیر استفاده کنید  :</p>
<p> </p>
<div class="span12 upload">

      <?php TinyPaymentHelper::menuAdmin(); ?>
</div>      
        </span>

      </div>
    </div>
  </div>
</div>  
        <div class="clearfix"></div>
        <div class="margin"></div>        
<?php TinyPaymentHelper::cRight(); ?>