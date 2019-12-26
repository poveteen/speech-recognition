<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>little raccoon is the best!!</title>

</head>
<body background="1.jpg" style="color:yellow;background-size:100% auto;">
  <?php
# 檢查檔案是否上傳成功
if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
  echo '檔案名稱: ' . $_FILES['my_file']['name'] . '<br/>';
  echo '檔案類型: ' . $_FILES['my_file']['type'] . '<br/>';
  echo '檔案大小: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
  echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'] . '<br/>';







  # 檢查檔案是否已經存在
  if (file_exists('upload/' . $_FILES['my_file']['name'])){
    echo '檔案已存在。<br/>';
    // $str = 'curl -v -T upload/eng.mp3 -H "Content-Type: audio/x-raw,+layout=(string)interleaved,+rate=(int)16000,+format=(string)S16LE,+channels=(int)1" --header "Transfer-Encoding: chunked" --limit-rate 32000 "https://bark.phon.ioc.ee:8443/english/duplex-speech-api/dynamic/recognize"';

    // exec('curl -v -T upload/'.$_FILES['my_file']['name'].' -H "Content-Type: audio/x-raw-int; rate=32000" --header "Transfer-Encoding: chunked" --limit-rate 32000 '.$_POST["language"],$out);
    // exec($str,$out);







    exec('curl -X POST -T upload/'.$_FILES['my_file']['name'].' '.$_POST["language"],$out);
    $sub = substr($out[0], 44, -50);
    echo $sub;
    echo "<br>";
    echo json_decode('"' . $sub . '"');


  } else {
    $file = $_FILES['my_file']['tmp_name'];
    $dest = 'upload/' . $_FILES['my_file']['name'];
    # 將檔案移至指定位置
    move_uploaded_file($file, $dest);

    exec('curl -X POST -T upload/'.$_FILES['my_file']['name'].' '.$_POST["language"],$out);
    $sub = substr($out[0], 44, -50);
    echo $sub;
    echo "<br>";
    echo json_decode('"' . $sub . '"');


  
  }
} else {
  echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
}

?>
</body>
</html>