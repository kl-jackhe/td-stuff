<!-- 出貨通知 -->
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="line-height: 25px;">
			親愛なる <strong>{{cname}} </strong> ハロー，<br><br>

			<span style="color: #cc0000">商品出荷通知！</span>あなたが商品を受け取った場合、システム通知を無視することができます<br><br>

			 {{sec_pantuo_cpname}} で買い物をしていただきありがとうございます<br>
			注文番号<span style="color: #cc0000"> {{odno}} </span>このアイテムは {{send_date}} に調理されました<br>
			約1〜3営業日が掛かると予想されますので、お待ちください！<br>
			あなたの電話を開いたままにして注意を払ってください<br>
			{{sec_pantuo_cpname}} のご支援ありがとうございます、この注文の経験に満足していただけることを楽しみにしています！<br><br>

			<hr>
			<p style="line-height: 25px;">【注文の詳細】</p>
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
                        <tr bgcolor="#efefef">
                          <th height="30" align="center" nowrap style=" border-right:1px solid #e4e4e4;">#</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">製品番号</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">製品名</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">製品仕様</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">金額</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">数量</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">小計</th>
                        </tr>
						{{message_od}}
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">金額の小計</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal}}</strong></td>
                        </tr>
                         <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">配達と取り扱い</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{cost}}</strong></td>
                        </tr>
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>総額</strong></td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal_cost}}</strong></td>
                        </tr>
			</table>

			<p style="line-height: 25px;">【情報を送信する】</p>
						
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
			  <tbody>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">出荷日</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; color: #cc0000; padding-left: 20px;">{{send_date}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">宅配モード</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_type}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">配達番号</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_no}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">加入者名前</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">受信者名</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">受取人電話</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{tel2}} {{mobile2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">受取人住所</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{addr2_txt}}</td>
				</tr>
			  </tbody>
			</table>		

			<br>
			<br>
			{{sec_pantuo_cpname}}
			<br>
			ウェブサイト：<a href="{{sec_pantuo_webname}}" target="_blank">{{sec_pantuo_webname}}</a>
			<br>
			E-mail：<a href="mailto:{{sec_pantuo_email}}">{{sec_pantuo_email}}</a>
			<br>
			<br>
			※このメッセージは自動的にシステムから送信されますので、直接返信しないでください！ ありがとうございました！ 	    	     
   	  </td>
    </tr>
  </tbody>
</table>