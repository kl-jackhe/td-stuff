<!-- 出貨通知 -->
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="line-height: 25px;">
			亲爱的 <strong>{{cname}} </strong> 您好，<br><br>

			<span style="color: #cc0000">商品出货通知！</span>若已收到商品可忽略本系统通知。<br><br>

			非常感谢您在 {{sec_pantuo_cpname}} 购物<br>
			订单编号 <span style="color: #cc0000">{{odno}}</span> 此商品已于 {{send_date}} 出货<br>
			预计约1~3个工作天可送达，请您稍候！<br>
			请保持手机畅通并注意代收<br>
			感谢您对 {{sec_pantuo_cpname}} 的支持，期待您满意这次的订购体验！<br><br>

			<hr>
			<p style="line-height: 25px;">【订单明细】</p>
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
                        <tr bgcolor="#efefef">
                          <th height="30" align="center" nowrap style=" border-right:1px solid #e4e4e4;">#</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品编号</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品名称</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">商品规格</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">金额</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">数量</th>
                          <th align="center" nowrap style=" border-right:1px solid #e4e4e4;">小计</th>
                        </tr>
						{{message_od}}
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">金额小计</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal}}</strong></td>
                        </tr>
                         <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;">运送与处理</td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{cost}}</strong></td>
                        </tr>
                        <tr bgcolor="#ffffff">
                          <td colspan="6" align="right" style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>金额总计</strong></td>
                          <td align="right" nowrap style=" border-bottom:1px solid #e4e4e4; padding-right:8px;"><strong>＄{{sumtotal_cost}}</strong></td>
                        </tr>
			</table>
			<br>
			<p style="line-height: 25px;">【订单资讯】</p>
			
			<table width="100%" border="0" cellspacing="1" cellpadding="5" style="border:1px solid #e4e4e4; background-color: #e4e4e4;">
			  <tbody>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">出货日</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; color: #cc0000; padding-left: 20px;">{{send_date}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">宅配方式</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_type}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">配送编号</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{send_no}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">订购人</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">收件人</td>
				  <td style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #fff; padding-left: 20px;">{{username2}}</td>
				</tr>
                <tr>
				  <td width="150" align="center" nowrap style=" border-right:1px solid #e4e4e4; border-bottom:1px solid #e4e4e4; background-color: #efefef;">收件人电话</td>
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
			网站：<a href="{{sec_pantuo_webname}}" target="_blank">{{sec_pantuo_webname}}</a>
			<br>
			E-mail：<a href="mailto:{{sec_pantuo_email}}">{{sec_pantuo_email}}</a>
			<br>
			<br>
			※此邮件是系统自动传送，请勿直接回覆！谢谢！ 	    	     
   	  </td>
    </tr>
  </tbody>
</table>