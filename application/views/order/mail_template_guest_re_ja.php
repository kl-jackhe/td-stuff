<!-- 訂單留言回覆 -->
<table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" style="padding: 50px;">
  <tbody>
    <tr>
      <td>

		親愛なる <strong>{{cname}}</strong> こんにちは，
		<br>
		<br>
		
		  <table width="100%" border="0" cellspacing="1" cellpadding="10" style="border: 1px solid #e4e4e4;">
			  <tbody>
				<tr>
				  <td colspan="2" align="center" nowrap="nowrap" bgcolor="#efefef"><strong>注文メッセージの内容</strong></td>
			    </tr>
				<tr style="line-height: 25px;">
				  <td colspan="2">
				  <p>メッセージ時間：{{guest_datetime}}</p>
				  {{guest_content}}
				  </td>
			    </tr>
			  </tbody>
		  </table>

		  <br>
		  <table width="100%" border="0" cellspacing="1" cellpadding="10" style="border: 1px solid #e4e4e4;">
			  <tbody>
				<tr>
				  <td colspan="2" align="center" nowrap="nowrap" bgcolor="#efefef"><strong>注文メッセージの返信</strong></td>
			    </tr>
				<tr style="line-height: 25px;">
				  <td colspan="2">
				  <p>メッセージ時間：{{date_now}}</p>
				  {{reply}}
				  </td>
			    </tr>
			  </tbody>
		  </table>

		<br>
		<br>
		{{sec_pantuo_cpname}}
		<br>
		ウェブサイト : <a href="{{sec_pantuo_webname}}" target="_blank">{{sec_pantuo_webname}}</a>
		<br>
		E-mail : <a href="mailto:{{sec_pantuo_email}}">{{sec_pantuo_email}}</a>

   	  </td>
    </tr>
  </tbody>
</table>