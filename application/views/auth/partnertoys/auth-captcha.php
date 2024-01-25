<?php
// 生成一個包含數字和英文字母的隨機四位數字驗證碼
$randomCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4);

// 將驗證碼存入 Session 中
$this->session->set_flashdata('captcha', $randomCode);

// 創建一個圖片
$imageWidth = 150;
$imageHeight = 70;
$image = imagecreate($imageWidth, $imageHeight);

// 主要色彩設定
// 圖片底色 - 深紫
$bgColor = imagecolorallocate($image, 189, 41, 163);

// 文字顏色 - 白
$textColor = imagecolorallocate($image, 255, 255, 255);

// 干擾線條顏色 - 深藍
$gray1 = imagecolorallocate($image, 21, 41, 164);

// 干擾像素顏色 - 淺紫
$gray2 = imagecolorallocate($image, 232, 64, 185);

// 設定圖片底色
imagefill($image, 0, 0, $bgColor);

//底色干擾線條
for ($i = 0; $i < 10; $i++) {
    imageline(
        $image,
        rand(0, $imageWidth),
        rand(0, $imageHeight),
        rand($imageHeight, $imageWidth),
        rand(0, $imageHeight),
        $gray1
    );
}

// 干擾像素
for ($i = 0; $i < 90; $i++) {
    imagesetpixel(
        $image,
        rand() % $imageWidth,
        rand() % $imageHeight,
        $gray2
    );
}

// 設定字型和文字大小
$font = './assets/font_ttf/GHOSTWRITER.TTF';  // 替換成你的字型文件的路徑
$fontSize = 32;

// 設定文字位置，使文字剛好在圖片中間
$textBox = imagettfbbox($fontSize, 0, $font, $randomCode);
$textWidth = $textBox[2] - $textBox[0];
$textHeight = $textBox[3] - $textBox[5];
$textX = ($imageWidth - $textWidth) / 2;
$textY = ($imageHeight - $textHeight) / 2 + $textHeight; // 增加文字的高度，使文字垂直居中

// 在圖片上寫入文字
imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $font, $randomCode);

// 將圖片轉換為 base64 編碼的數據 URI
ob_start();
imagepng($image);
$imageData = ob_get_contents();
ob_end_clean();
$imageBase64 = 'data:image/png;base64,' . base64_encode($imageData);
