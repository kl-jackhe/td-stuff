<!-- 訂單訊息通知 -->
<table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" style="padding: 50px;">
	<tbody>
		<tr>
			<td>
				親愛的 <strong> <?= $cname ?> </strong> 您好，
				<br>
				<br>
				<table width="100%" border="0" cellspacing="1" cellpadding="10" style="border: 1px solid #e4e4e4;">
					<tbody>
						<tr>
							<td colspan="2" align="center" nowrap="nowrap" bgcolor="#efefef"><strong>管理者訂單留言通知</strong></td>
						</tr>
						<tr style="line-height: 25px;">
							<td colspan="2">
								<p>留言時間：<?= $created_at; ?></p>
								<span><?= $content; ?></span>
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<br>
				<?= $webname; ?>
				<br>
				網站 : <a href="<?= base_url(); ?>" target="_blank"><?= base_url(); ?></a>
				<br>
				E-mail : <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
			</td>
		</tr>
	</tbody>
</table>