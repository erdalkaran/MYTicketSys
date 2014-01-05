<?php require_once 'config.php'; ?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="description" content=""/>
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<link rel="stylesheet" type="text/css" href="resources/css/style.css" media="screen" />
	<title>My Ticket System/Yeni Ticket Oluştur</title>
</head>
<body>
<div id="site-wrapper">
	<div id="header">
		<?php include_once "inc/ust.php"; ?>
	</div>
<div class="main" id="main-two-columns">
    <div class="left" id="main-content">
        <div class="post-title">
            <h3 class="section-title">ESKİ TİCKET UYGULAMALARI</h3>
        </div>	  
       <div class="form">
        <section id="respond">
            <table border="1" style="width: 650px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>AD-SOYAD</th>
                        <th>EMAİL</th>
                        <th>KATEGORİ</th>
                        <th>BAŞLIK</th>
                    </tr>
                </thead>
<?php
$sql="SELECT ud.id_kullanici, ud.ad, ud.soyad, ud.email, k.kategori_ad, s.baslik "
        . "FROM uye_detay ud "
        . "INNER JOIN soru s "
        . "ON s.id_kullanici = ud.id_kullanici "
        . "INNER JOIN kategori k "
        . "ON k.id_kategori = ud.id_kullanici";

$sonuclar=$DB->get_results($sql);
//$a=0;
if(count($sonuclar) == 0){
        echo '<tr><td colspan="7"><font color=red><center>Hiç Mesaj Yok</center></font></td></tr>';
}else{
    foreach ($sonuclar as $kayitlar){
        echo '<tr>
         <td>'.$kayitlar->id_kullanici.'</td>
         <td>'.$kayitlar->ad.' '.$kayitlar->soyad.'</td>
         <td>'.$kayitlar->email.'</td>    
         <td>'.$kayitlar->kategori_ad.'</td>
         <td>'.$kayitlar->baslik.'</td>
        
         </tr>';
    }
}
?>
            </table>
        </section>
     </div>
   </div>
        <div class="right sidebar" id="sidebar">
                  <?php include_once "kategoriler.php"; ?>
        </div>
        <div class="clearer">&nbsp;</div>
</div>
        <?php include_once ('inc/footer.php'); ?>
</div>
</body>
</html>