# jQuery-cn-zipcode

建立中華人民共和國省份、縣市、鄉鎮市區以及郵遞區號的表單元素。

## 使用方式 Usage

HTML
```html
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="jquery-cn-zipcode.min.js"></script>

<!-- Normal -->
<div id="cnzipcode"></div>
  
<!-- If the elements contain data-role, generating form elements in there. -->  
<div id="cnzipcode">
  <div data-role="province"></div>
  <div data-role="county"></div>
  <div data-role="district"></div>
  <div data-role="zipcode"></div>
</div>
```

Javascript
```javascript
$('#cnzipcode').cnzipcode();
```

## 選項 Options

<table>
<tr>
    <td>Option</td>
    <td>Data type</td>
    <td>Description</td>
    <td>Default value</td>
</tr>
<tr>
    <td>provinceTitle</td>
    <td>string</td>
    <td>省份下拉式選單的第一個選項。</td>
    <td>省份</td>
</tr>
<tr>
    <td>provinceName</td>
    <td>string</td>
    <td>省份下拉式選單的表單名稱。</td>
    <td>province</td>
</tr>
<tr>
    <td>provinceDefault</td>
    <td>string</td>
    <td>省份下拉式選單的預設值。</td>
    <td>null</td>
</tr>
<tr>
    <td>provinceClass</td>
    <td>string</td>
    <td>省份下拉式選單的 class 。</td>
    <td>null</td>
</tr>
<tr>
    <td>countyTitle</td>
    <td>string</td>
    <td>縣市下拉式選單的第一個選項。</td>
    <td>縣市</td>
</tr>
<tr>
    <td>countyName</td>
    <td>string</td>
    <td>縣市下拉式選單的表單名稱。</td>
    <td>county</td>
</tr>
<tr>
    <td>countyDefault</td>
    <td>string</td>
    <td>縣市下拉式選單的預設值。</td>
    <td>null</td>
</tr>
<tr>
    <td>countyClass</td>
    <td>string</td>
    <td>縣市下拉式選單的 class 。</td>
    <td>null</td>
</tr>
<tr>
    <td>districtTitle</td>
    <td>string</td>
    <td>鄉鎮市區下拉式選單的第一個選項。</td>
    <td>鄉鎮市區</td>
</tr>
<tr>
    <td>districtName</td>
    <td>string</td>
    <td>鄉鎮市區下拉式選單的表單名稱。</td>
    <td>district</td>
</tr>
<tr>
    <td>districtDefault</td>
    <td>string</td>
    <td>鄉鎮市區下拉式選單的預設值。</td>
    <td>null</td>
</tr>
<tr>
    <td>districtClass</td>
    <td>string</td>
    <td>鄉鎮市區下拉式選單的 class 。</td>
    <td>null</td>
</tr>
<tr>
    <td>zipcodeName</td>
    <td>string</td>
    <td>郵遞區號文字輸入框的表單名稱。</td>
    <td>zipcode</td>
</tr>
<tr>
    <td>zipcodeDefault</td>
    <td>string</td>
    <td>郵遞區號文字輸入框的預設值。</td>
    <td>null</td>
</tr>
<tr>
    <td>zipcodeClass</td>
    <td>string</td>
    <td>郵遞區號文字輸入框的 class 。</td>
    <td>null</td>
</tr>
<tr>
    <td>onProvinceSelect</td>
    <td>function</td>
    <td>綁定省份下拉式選單 Change 事件。</td>
    <td>null</td>
</tr>
<tr>
    <td>onCountySelect</td>
    <td>function</td>
    <td>綁定鄉鎮市區下拉式選單 Change 事件。</td>
    <td>null</td>
</tr>
<tr>
    <td>onDistrictSelect</td>
    <td>function</td>
    <td>綁定鄉鎮市區下拉式選單 Change 事件。</td>
    <td>null</td>
</tr>
<tr>
    <td>onZipcodeKeyUp</td>
    <td>function</td>
    <td>郵遞區號文字輸入框 keyUp 事件 (readonly 須為 false)。</td>
    <td>null</td>
</tr>
<tr>
    <td>readonly</td>
    <td>boolean</td>
    <td>郵遞區號文字輸入框是否為唯讀。</td>
    <td>false</td>
</tr>
</table>

### 備註

預設值的優先順序：郵遞區號 > 鄉鎮市區 > 縣市 > 省份。

## 參考資料 References

[essoduke/jQuery-TWzipcode](https://github.com/essoduke/jQuery-TWzipcode)

## 授權 License

[MIT License](http://opensource.org/licenses/MIT)
