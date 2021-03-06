<?php
session_start();
include_once 'config.php';
include_once 'lib/Kullanici.php';
include_once 'kontroller.php';
$knt=new kontroller();

    $ad=$knt->kontrol($_POST['ad']);
    $soyad=$knt->kontrol($_POST['soyad']);
    $id_kategori=$knt->kontrol($_POST['id_kategori']);
    $baslik=$knt->kontrol($_POST['baslik']);
    $email=$knt->kontrol($_POST['email']); 
    $girilen_kod = trim(strip_tags($_POST['security']));
    $guvenlik_kodu = trim(strip_tags($_SESSION['koruma']));       
    
    //php nin ürettgi kod
    $soru=$knt->kontrol($_POST['soru']);
    $tarih=date('Y-m-d H:i:s');
    $ip=$_SERVER['REMOTE_ADDR']; //ip bilgisini öğrenmeye yarar
    
    
    $hata=false;
    $hatamesaj=array();
    
    if(empty($ad)){
        $hatamesaj[]='Ad Boş Bırakılamaz.';
    }
    if(empty($soyad)){
        $hata=true;
        $hatamesaj[]='Soyad Boş Bırakılamaz.';
    }
    if(strlen($ad)>25 && strlen($soyad)){
        $hata[]='Ad ve Soyad 25 karakterden büyük olamaz';
    }
    if(empty($email)){
        $hatamesaj[]='Email Boş Bırakılamaz.';
    }    
    if(!is_numeric($id_kategori)){
        $hatamesaj[]='Kategori Hata';
    }
    if(strlen($baslik)>255){
        $hatamesaj[]='Başlık 255 karakterden büyük olmaz';
    }
    if(strlen($email)>100){
        $hatamesaj[]='E-mail 100 karakterden büyük olmaz';
    }
    if(strlen($soru)>1000){
    $hatamesaj[]="Soru 1000 karakterden büyük olamaz";
    }
    if($girilen_kod != $guvenlik_kodu){
        $hatamesaj[] = 'Güvenlik Kodu Yanlış';
    }

?>
<!DOCTYPE html>
<html>
<head>
    <title>İletişim formu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
	<link rel="stylesheet" type="text/css" href="resources/css/style.css" media="screen" />    
</head>
<body>
<div id="site-wrapper">
	<div id="header">
		<?php include_once "inc/ust.php"; ?>
	</div>    
    <div class="main" id="main-two-columns">
        <div class="left" id="main-content">
          <div class="post-title">
	     <h3 class="section-title">TİCKET KONTROL</h3>
	  </div>
                <div class="form">
                <section id="respond">
                    <?php
                        $formatlar=array("image/.png", "image/jpeg", "image/gif");
                            if(in_array($_FILES['dosya']['type'], $formatlar)){
                                move_uploaded_file($_FILES['dosya']['tmp_name'], 'dosya/' . $_FILES['dosya']['name'] );
                                 $dosya=$_FILES['dosya']['name'];
                            }
                        if(count($hatamesaj)>0){
                            foreach($hatamesaj as $hata){
                                echo $hata.'<br/>';
                            }
                        }else{
                            $sifrele= sha1(rand(10, 1000));
                            $kullanici= new Kullanici();
                                $data= array(
                                    'ad'=>$ad,
                                    'soyad'=>$soyad,
                                    'id_kategori'=>$id_kategori,
                                    'baslik'=>$baslik,
                                    'email'=>$email,
                                    'sifrele'=>$sifrele,
                                    'soru'=>$soru,
                                    'tarih'=>$tarih,
                                    'dosya'=>$dosya,
                                    'ip'=>$ip,
                                );
                                $kayitSonucu= $kullanici->kayitYap($data);
                        if($kayitSonucu == true){
                            echo 'Mesajınız Gönderildi En Kısa Zamanda Bilgi Verilecektir';
                            header("Refresh: 3; url=index.php");
                        }else{
                            echo "hata var";
                            echo $DB->last_error;
                        }
                    }     
                    ?>
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