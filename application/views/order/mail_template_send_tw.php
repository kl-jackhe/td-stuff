<!-- 出貨通知 -->
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="line-height: 25px;">
			親愛的 <strong>{{cname}} </strong> 您好，<br><br>

			<span style="color: #cc0000">商品出貨通知！</span>若已收到商品可忽略本系統通知。<br><br>

			非常感謝您在 {{sec_pantuo_cpname}} 購物<br>
			訂單編號 <span style="color: #cc0000">{{odno}}</span> 此商品已於 <span style="color: #cc0000">{{send_date}}</span> 出貨<br>
			預計約1~3個工作天可送達，請您稍候！<br>
			請保持手機暢通並注意代收<br>
			感謝您對 {{sec_pantuo_cpname}} 的支持，期待您滿意這次的訂購體驗！<br><br>

			<hr>
			<p style="line-height: 25px;">【訂單明細】</p>
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
                        <tr bgcolor="#efefef">
                          <th height="30" align="center" nowrap style=" border-right:1px solid #e4e4e4;">#</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品編號</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品名稱 </th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品規格</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">金額</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">數量</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">小計</th>
                        </tr>
						{{message_od}}
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">金額小計</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal}}</strong></td>
                        </tr>
                         <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">運送與處理</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{cost}}</strong></td>
                        </tr>
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>金額總計</strong></td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal_cost}}</strong></td>
                        </tr>
			</table>
			<br>
			<p style="line-height: 25px;">【訂單資訊】</p>
		
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
			  <tbody>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">出貨日</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; color: #cc0000; padding-left: 20px;">{{send_date}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">宅配方式</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_type}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">配送編號</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_no}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">訂購人</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">收件人</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">收件人電話</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{tel2}} {{mobile2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">收件人地址</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{addr2_txt}}</td>
				</tr>
			  </tbody>
			</table>		

			<br>
			<br>
			{{sec_pantuo_cpname}}
			<br>
			網址：<a href="{{sec_pantuo_webname}}" target="_blank">{{sec_pantuo_webname}}</a>
			<br>
			E-mail：<a href="mailto:{{sec_pantuo_email}}">{{sec_pantuo_email}}</a>
			<br>
			<br>
			※此郵件是系統自動傳送，請勿直接回覆！謝謝！  	    	     
   	  </td>
    </tr>
  </tbody>
</table>