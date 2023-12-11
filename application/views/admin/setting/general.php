<style>
	#logo_preview{
		background: #efefef;
		border: 1px solid #000;
	}
	select.district {
	  margin-right: : 5px;
	}
	.zipcode{
	  display: none!important;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<?php echo form_open('admin/setting/update_general',array('class'=>'form-horizontal')); ?>
		<div class="tabbable">
		  	<!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		  		<!-- <li role="presentation" >
		      		<a href="#all_coupon" aria-controls="all_coupon" role="tab" data-toggle="tab">全站優惠設定</a>
		      	</li> -->
		      	<!-- <li role="presentation">
		      		<a href="#coupon" aria-controls="coupon" role="tab" data-toggle="tab">推薦碼優惠券設定</a>
		      	</li> -->
		    	<li role="presentation" class="active">
		      		<a href="#company" aria-controls="company" role="tab" data-toggle="tab">全站設定</a>
		      	</li>
		  	</ul>

			<!-- Tab panes -->
			<div class="tab-content">
			    <div role="tabpanel" class="tab-pane active" id="company">
			      	<div class="form-group">
						<label class="col-md-2" for="name">網站名稱</label>
						<div class="col-md-4">
							<input type="text" name="name" id="name" class="form-control" value="<?php echo get_setting_general('name') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="short_name">簡稱</label>
						<div class="col-md-4">
							<input type="text" name="short_name" id="short_name" class="form-control" value="<?php echo get_setting_general('short_name') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="contact_person">聯絡人</label>
						<div class="col-md-4">
							<input type="text" name="contact_person" id="contact_person" class="form-control" value="<?php echo get_setting_general('contact_person') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="phone1">市話</label>
						<div class="col-md-4">
							<input type="text" name="phone1" id="phone1" class="form-control" value="<?php echo get_setting_general('phone1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="cellphone1">手機</label>
						<div class="col-md-4">
							<input type="text" name="cellphone1" id="cellphone1" class="form-control" value="<?php echo get_setting_general('cellphone1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="fax">傳真</label>
						<div class="col-md-4">
							<input type="text" name="fax" id="fax" class="form-control" value="<?php echo get_setting_general('fax') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="address">聯絡地址</label>
						<div class="col-md-4">
							<input type="text" name="address" id="address" class="form-control" value="<?php echo get_setting_general('address') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="email">電子郵件</label>
						<div class="col-md-4">
							<input type="text" name="email" id="email" class="form-control" value="<?php echo get_setting_general('email') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="smtp_host">電子郵件伺服器</label>
						<div class="col-md-4">
							<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php echo get_setting_general('smtp_host') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="smtp_user">電子郵件帳號</label>
						<div class="col-md-4">
							<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?php echo get_setting_general('smtp_user') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="smtp_pass">電子郵件密碼</label>
						<div class="col-md-4">
							<input type="text" name="smtp_pass" id="smtp_pass" class="form-control" value="<?php echo get_setting_general('smtp_pass') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="smtp_port">電子郵件埠號</label>
						<div class="col-md-4">
							<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="<?php echo get_setting_general('smtp_port') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="smtp_crypto">電子郵件加密類型</label>
						<div class="col-md-4">
							<input type="text" name="smtp_crypto" id="smtp_crypto" class="form-control" value="<?php echo get_setting_general('smtp_crypto') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="mail_header_text">寄件主旨</label>
						<div class="col-md-4">
							<textarea name="mail_header_text" id="mail_header_text" class="form-control" rows="5"><?php echo get_setting_general('mail_header_text') ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="mail_boddy_text">寄件主要內容文字描述</label>
						<div class="col-md-4">
							<textarea name="mail_boddy_text" id="mail_boddy_text" class="form-control" rows="5"><?php echo get_setting_general('mail_boddy_text') ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="mail_other_text">寄件次要內容文字描述</label>
						<div class="col-md-4">
							<textarea name="mail_other_text" id="mail_other_text" class="form-control" rows="5"><?php echo get_setting_general('mail_other_text') ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="mail_footer_text">寄件尾部文字描述</label>
						<div class="col-md-4">
							<textarea name="mail_footer_text" id="mail_footer_text" class="form-control" rows="5"><?php echo get_setting_general('mail_footer_text') ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="atm_bank_code">銀行代碼</label>
						<div class="col-md-4">
							<input type="text" name="atm_bank_code" id="atm_bank_code" class="form-control" value="<?php echo get_setting_general('atm_bank_code') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="atm_bank_account">銀行帳號</label>
						<div class="col-md-4">
							<input type="text" name="atm_bank_account" id="atm_bank_account" class="form-control" value="<?php echo get_setting_general('atm_bank_account') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="official_facebook_1">FaceBook</label>
						<div class="col-md-4">
							<input type="text" name="official_facebook_1" id="official_facebook_1" class="form-control" value="<?php echo get_setting_general('official_facebook_1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="official_line_1">Line</label>
						<div class="col-md-4">
							<input type="text" name="official_line_1" id="official_line_1" class="form-control" value="<?php echo get_setting_general('official_line_1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="file_upload">Line QR Code</label>
						<div class="col-md-4">
							<img src="<?php if (!empty(get_setting_general('official_line_1_qrcode'))) { echo base_url().'assets/uploads/'.get_setting_general('official_line_1_qrcode'); } ?>" id="official_line_1_qrcode_preview" class="img-responsive" <?php if (empty(get_setting_general('official_line_1_qrcode'))) { echo "style='display:none;'"; } ?>>
							<input type="hidden" id="official_line_1_qrcode" name="official_line_1_qrcode" value="<?php echo get_setting_general('official_line_1_qrcode') ?>"/>
				            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=official_line_1_qrcode&relative_url=1" class="btn btn-primary fancybox" type="button">選擇圖片</a>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="official_instagram_1">Instagram</label>
						<div class="col-md-4">
							<input type="text" name="official_instagram_1" id="official_instagram_1" class="form-control" value="<?php echo get_setting_general('official_instagram_1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="official_tiktok_1">TikTok</label>
						<div class="col-md-4">
							<input type="text" name="official_tiktok_1" id="official_tiktok_1" class="form-control" value="<?php echo get_setting_general('official_tiktok_1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="official_xiaohongshu_1">小紅書</label>
						<div class="col-md-4">
							<input type="text" name="official_xiaohongshu_1" id="official_xiaohongshu_1" class="form-control" value="<?php echo get_setting_general('official_xiaohongshu_1') ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="meta_keywords">網站meta關鍵字</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" name="meta_keywords" id="meta_keywords"><?php echo get_setting_general('meta_keywords') ?></textarea>
							<!-- <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="<?php echo get_setting_general('meta_keywords') ?>"/> -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="meta_description">網站meta描述</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" name="meta_description" id="meta_description"><?php echo get_setting_general('meta_description') ?></textarea>
							<!-- <input type="text" name="meta_description" id="meta_description" class="form-control" value="<?php echo get_setting_general('meta_description') ?>"/> -->
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="shopping_notes">購物須知</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" name="shopping_notes" id="shopping_notes"><?php echo get_setting_general('shopping_notes') ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="join_member_info">加入會員文字描述</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" name="join_member_info" id="join_member_info"><?php echo get_setting_general('join_member_info') ?></textarea>
						</div>
					</div>
					<?if ($this->is_td_stuff) {?>
					<div class="form-group">
						<label class="col-md-2" for="single_sales_error_info">銷售頁面不開放文字描述</label>
						<div class="col-md-4">
							<textarea class="form-control" rows="5" name="single_sales_error_info" id="single_sales_error_info"><?php echo get_setting_general('single_sales_error_info') ?></textarea>
						</div>
					</div>
					<?}?>
					<div class="form-group hide">
						<label class="col-md-2" for="per_page">毎頁顯示筆數</label>
						<div class="col-md-4">
							<?php $options = array(
								'10' => '10',
								'15' => '15',
								'20' => '20',
								'25' => '25',
								'30' => '30',
								'35' => '35',
								'40' => '40',
							);
							$att = 'id="per_page" class="form-control bfh-selectbox"';
							echo form_dropdown('per_page', $options, get_setting_general('per_page'), $att); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="logo_max_width">LOGO最大寬度<p style="font-size: 12px;margin: 0;color: red;">無設定則預設為130px</p></label>
						<div class="col-md-4">
							<div class="input-group">
								<input type="text" name="logo_max_width" id="logo_max_width" class="form-control" value="<?=get_setting_general('logo_max_width') ?>"/>
								<span class="input-group-addon">px</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2" for="file_upload">LOGO</label>
						<div class="col-md-4">
							<img src="<?php if (!empty(get_setting_general('logo'))) { echo base_url().'assets/uploads/'.get_setting_general('logo'); } ?>" id="logo_preview" class="img-responsive" <?php if (empty(get_setting_general('logo'))) { echo "style='display:none;'"; } ?>>
							<input type="hidden" id="logo" name="logo" value="<?php echo get_setting_general('logo') ?>"/>
				            <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=logo&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇LOGO</a>
						</div>
					</div>
			    </div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<input type="submit" name="submit" value="儲存設定" class="btn btn-primary"/>
			</div>
		</div>
		<?php echo form_close() ?>
	</div>
</div>