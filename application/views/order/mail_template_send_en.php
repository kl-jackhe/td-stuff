<!-- 出貨通知 -->
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="line-height: 25px;">
			Hello, Dear <strong>{{cname}} </strong>,<br><br>

			<span style="color: #cc0000">Merchandise shipping notice! </span>If you have received the goods can ignore the system notice.<br><br>

			Thank you very much for shopping at  {{sec_pantuo_cpname}} <br>
			Order number <span style="color: #cc0000">{{odno}}</span>. This item was kindulated on {{send_date}}.<br>
			Is expected to be about 1 to 3 working days can be served, please wait!<br>
			Please keep your phone open and pay attention.<br>
			Thank you for your support of  {{sec_pantuo_cpname}}, look forward to your satisfaction with this order experience!<br><br>

			<hr>
			<p style="line-height: 25px;">【Order Details】</p>
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
                        <tr bgcolor="#efefef">
                          <th height="30" align="center" nowrap style=" border-right:1px solid #e4e4e4;">#</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Product number</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Product name</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Product specifications</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Amount</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Quantity</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">Subtotal</th>
                        </tr>
						{{message_od}}
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">Amount subtotal</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal}}</strong></td>
                        </tr>
                         <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">Delivery and handling</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{cost}}</strong></td>
                        </tr>
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>Amount total</strong></td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal_cost}}</strong></td>
                        </tr>
			</table>

			<p style="line-height: 25px;">Order information</p>
						
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
			  <tbody>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Shipping day</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; color: #cc0000; padding-left: 20px;">{{send_date}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Delivery mode</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_type}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Delivery No.</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_no}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Subscriber</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Recipient</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Phone</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{tel2}} {{mobile2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">Recipient add.</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{addr2_txt}}</td>
				</tr>
			  </tbody>
			</table>		

			<br>
			<br>
			{{sec_pantuo_cpname}}
			<br>
			Website：<a href="{{sec_pantuo_webname}}" target="_blank">{{sec_pantuo_webname}}</a>
			<br>
			E-mail：<a href="mailto:{{sec_pantuo_email}}">{{sec_pantuo_email}}</a>
			<br>
			<br>
			※ This message is automatically sent by the system, please do not reply directly! Thank you!	     
   	  </td>
    </tr>
  </tbody>
</table>