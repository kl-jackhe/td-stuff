<?php
header("Content-type:image/png");
//header("Content-Disposition:filename=image_code.png");
//定義 header 的文件格式為 png，第二個定義其實沒什麼用
 
// 開啟 session
if (!isset($_SESSION)) { session_start(); }
 
// 設定亂數種子
mt_srand((double)microtime()*1000000);
 
// 驗證碼變數
$verification__session2 = '';
 
// 定義顯示在圖片上的文字，可以再加上大寫字母
//$str = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
$str = '123456789ABCDEFGHJKLMNPQRSTUVWXY';
 
$l = strlen($str); //取得字串長度
 
//隨機取出 4 個字
for($i=0; $i<4; $i++){
   $num=rand(0,$l-1);
   $verification__session2.= $str[$num];
}
 
// 將驗證碼記錄在 session 中
$_SESSION["verification__session2"] = $verification__session2;
 
 
// 圖片的寬度與高度
//$imageWidth = 160; $imageHeight = 50;
$imageWidth = 100; $imageHeight = 34;

// 建立圖片物件
$im = @imagecreatetruecolor($imageWidth, $imageHeight)
or die("無法建立圖片！");
 
 
//主要色彩設定
// 圖片底色 - 深紫
$bgColor = imagecolorallocate($im, 189,41,163);

// 文字顏色 - 白
$Color = imagecolorallocate($im, 255,255,255);

// 干擾線條顏色 - 深藍
$gray1 = imagecolorallocate($im, 21,41,164);

// 干擾像素顏色 - 淺紫
$gray2 = imagecolorallocate($im, 232,64,185);
 
//設定圖片底色
imagefill($im,0,0,$bgColor);
 
//底色干擾線條
for($i=0; $i<10; $i++){
   imageline($im,rand(0,$imageWidth),rand(0,$imageHeight),
   rand($imageHeight,$imageWidth),rand(0,$imageHeight),$gray1);
}
 
//利用true type字型來產生圖片
//array imagettftext (int im圖形, int size, int angle角度, int x坐標, int y坐標, int col顏色, string fontfile字形路徑, string text寫入的文字字串)
//坐標 x,y將會定義成第一個字元的基準點
//imagettftext($im, 20, 0, 25, 35, $Color,"Lato-SemiboldItalic.ttf",$verification__session2);
imagettftext($im, 22, 0, 19, 26, $Color,"../../../Admin_System/bootstrap/fonts/GHOSTWRITER.TTF",$verification__session2);
/*
imagettftext (int im, int size, int angle,
int x, int y, int col,
string fontfile, string text)
im 圖片物件
size 文字大小
angle 0度將會由左到右讀取文字，而更高的值表示逆時鐘旋轉
x y 文字起始座標
col 顏色物件
fontfile 字形路徑，為主機實體目錄的絕對路徑，
可自行設定想要的字型
text 寫入的文字字串
*/
 
// 干擾像素
for($i=0;$i<90;$i++){
   imagesetpixel($im, rand()%$imageWidth ,
   rand()%$imageHeight , $gray2);
}
 
imagepng($im);
imagedestroy($im);

?>