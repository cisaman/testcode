<html lang="en"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Campaign Monitor Newsletter</title>
	<style>
	a:hover {
		text-decoration: underline !important;
	}
	td.promocell p { 
		color:#e1d8c1;
		font-size:16px;
		line-height:26px;
		font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
		margin-top:0;
		margin-bottom:0;
		padding-top:0;
		padding-bottom:14px;
		font-weight:normal;
	}
	td.contentblock h4 {
		color:#444444 !important;
		font-size:16px;
		line-height:24px;
		font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
		margin-top:0;
		margin-bottom:10px;
		padding-top:0;
		padding-bottom:0;
		font-weight:normal;
	}
	td.contentblock h4 a {
		color:#444444;
		text-decoration:none;
	}
	td.contentblock p { 
	  	color:#888888;
		font-size:13px;
		line-height:19px;
		font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;
		margin-top:0;
		margin-bottom:12px;
		padding-top:0;
		padding-bottom:0;
		font-weight:normal;
	}
	td.contentblock p a { 
	  	color:#3ca7dd;
		text-decoration:none;
	}
	@media only screen and (max-device-width: 480px) {
	     div[class="header"] {
	          font-size: 16px !important;
	     }
	     table[class="table"], td[class="cell"] {
	          width: 300px !important;
	     }
		table[class="promotable"], td[class="promocell"] {
	          width: 325px !important;
	     }
		td[class="footershow"] {
	          width: 300px !important;
	     }
		table[class="hide"], img[class="hide"], td[class="hide"] {
	          display: none !important;
	     }
	     img[class="divider"] {
		      height: 1px !important;
		 }
		 td[class="logocell"] {
			padding-top: 15px !important; 
			padding-left: 15px !important;
			width: 300px !important;
		 }
	     img[id="screenshot"] {
	          width: 325px !important;
	          height: 127px !important;
	     }
		img[class="galleryimage"] {
			  width: 53px !important;
	          height: 53px !important;
		}
		p[class="reminder"] {
			font-size: 11px !important;
		}
		h4[class="secondary"] {
			line-height: 22px !important;
			margin-bottom: 15px !important;
			font-size: 18px !important;
		}
	}
	</style>
</head>
<body bgcolor="#e4e4e4" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" style="-webkit-font-smoothing: antialiased;width:100% !important;background:#e4e4e4;-webkit-text-size-adjust:none;">
	
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#e4e4e4">
<tbody><tr>
	<td bgcolor="#e4e4e4" width="100%">

	<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
	<tbody><tr>
		<td width="600" class="cell">
		
	   	<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
		<tbody><tr>
			<td width="250" bgcolor="#e4e4e4" class="logocell"><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="20" class="hide"><br class="hide"><img src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/widget-logo4.png" width="178" height="76" alt="Campaign Monitor" style="-ms-interpolation-mode:bicubic;"><br><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="10" class="hide"><br class="hide"></td>
			<td align="right" width="350" class="hide" style="color:#a6a6a6;font-size:12px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;" valign="top" bgcolor="#e4e4e4"><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="63"><br><span>Login&nbsp;</span><strong><span style="text-transform:uppercase;"> <currentmonthname> <currentyear></currentyear></currentmonthname></span></strong> <span>Details&nbsp;</span></td>
		</tr>
		</tbody></table>
	
		<br>
	
		<repeater>
			<layout label="Gallery highlights">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tbody><tr>
				<td bgcolor="#832701" nowrap=""><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="5" height="1"></td>
				<td width="100%" bgcolor="#ffffff">

					<table width="100%" cellpadding="20" cellspacing="0" border="0">
					<tbody><tr>
						<td bgcolor="#ffffff" class="contentblock">

							<h4 class="secondary"><strong><singleline label="Gallery title">Login Credentails</singleline></strong></h4>
							<multiline label="Gallery description"><p>Description login credentials</p></multiline>
							<p>Hello, <strong><?php echo $name; ?></strong></p>
							<br>
							<p>Below are the login credentails for PayWayhelp account :</p>
							<br>
							<p><strong>Username/Email : </strong> <?php echo $email; ?> </p>
							<br>
							<p><strong>Password : </strong> <?php echo $password; ?> </p>.
							<br>
							<p>Please login with above credentails <a href="http://www.paywayhelp.com/support_system/auth/"> Here </a> and reset your password.</p>
							<br>
							<p>Thanks & Regards</p>	
							
						</td>
					</tr>
					</tbody></table>

				</td>
			</tr>
			</tbody></table>

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tbody><tr>
				<td bgcolor="#832701" nowrap=""><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="5" height="1"></td>
				<td bgcolor="#ffffff" nowrap=""><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="5" height="1"></td> 
				
			</tr>
			</tbody></table>  
			<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="15" class="divider"><br>
			</layout>
			
		</repeater>           
		
		</td>
	</tr>
	</tbody></table>

	<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="25" class="divider"><br>

	<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
	<tbody><tr>
		<td>
		
			<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="30"><br>
		
			<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
			<tbody><tr>
				<td width="600" nowrap="" bgcolor="#f2f2f2" class="cell">
				
					<table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
					<tbody><tr>
						<td width="380" valign="top" class="footershow">
						
							<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="8"><br>  
						
							<p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;" class="reminder">You?re receiving this because this email was regisered with Paywayhelp.com subscribed via <a href="http://www.paywayhelp.com/" style="color:#a6a6a6;text-decoration:underline;">our site</a>.</p>
							<p style="color:#c9c9c9;font-size:12px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;"><preferences style="color:#3ca7dd;text-decoration:none;"><strong>Edit your subscription</strong></preferences>&nbsp;&nbsp;|&nbsp;&nbsp;<unsubscribe style="color:#3ca7dd;text-decoration:none;"><strong>Unsubscribe instantly</strong></unsubscribe></p>
						
						</td>
						<td align="right" width="220" style="color:#a6a6a6;font-size:12px;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;" valign="top" class="hide">
						
							<table cellpadding="0" cellspacing="0" border="0">
							<tbody><tr>
								<td><a href="http://www.flickr.com/photos/freshview"><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/flickr.gif" width="42" height="32" alt="See our photos on Flickr"></a></td>
								<td><a href="http://twitter.com/campaignmonitor"><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/twitter.gif" width="42" height="32" alt="Follow us on Twitter"></a></td>
								<td><a href="http://www.facebook.com/campaignmonitor"><img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/facebook.gif" width="32" height="32" alt="Visit us on Facebook"></a></td>
							</tr>
							</tbody></table>
						
							<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="10"><br><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:bold;">ABC Widgets</p><p style="color:#b3b3b3;font-size:11px;line-height:15px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;font-weight:normal;">87 Street Avenue, California, USA</p></td>
					</tr>
					</tbody></table>
				
				</td>
			</tr>	
	   		</tbody></table>

			<img border="0" src="<?php echo Yii::app()->request->baseUrl."img/mail/"; ?>images/spacer.gif" width="1" height="25"><br>
		
	   </td>
	</tr>
	</tbody></table>
	
	</td>
</tr>
</tbody></table>  	   			     	 



</body></html>