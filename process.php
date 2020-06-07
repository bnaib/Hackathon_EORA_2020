<?php
header('Content-Type: text/html; charset=utf-8');
set_time_limit(300);
require_once ("vh.class.php");

if (isset($_FILES['image']))
{
    if ($_GET['model'] != VisionHub::MODEL_ANIME_SELFIE
        && $_GET['model'] != VisionHub::MODEL_ANIME_GAN
        && $_GET['model'] != VisionHub::MODEL_POLYGON
        && $_GET['model'] != VisionHub::MODEL_PIXEL_ART)
        $_GET['model'] = VisionHub::MODEL_FACE_BLURRING;
    $vh = new VisionHub();
    if ($vh->get_error() === VisionHub::ERROR_NO)
    {
        $task_id = $vh->add_process($_GET['model'], 'image');
        if ($vh->get_error() === VisionHub::ERROR_NO)
        {
            $result_url = $vh->get_result_url($task_id);
            if ($vh->get_error() === VisionHub::ERROR_NO)
                $result_file = $vh->get_result_file($result_url);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" Content="text/html; Charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ШАБЛОН</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
	<link rel="stylesheet" href="css/main_merch.css">
</head>
<body>

	<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a href="#" class="navbar-brad" ><img src="img/shapka_verkhnyaya3.png"></a>
        </div>
    </nav>
	<div class="merch">
		<div class="container">
            <h1 class="text-center">А каким ты будешь сегодня?</h1>
            <div class="container" ml-auto;>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <a class="btn btn-primary btn-lg btn-block" href="index.html" role="button" >Назад</a>
                  </div>
                </div>
            </div>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
            <form action="" enctype="multipart/form-data" method="post">
                <p>Custom file upload:</p>
                <div class="custom-file">
                    <input type="file" class="custom-file-input"
                            id="fileUpload" name="image">
                    <label class="custom-file-label" for="fileUpload">
                        Choose file from computer
                    </label>
                </div>
                <div class="col-auto my-1">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

<! - Скрипт для отображения имени файла в поле выбора ->
<script>
    $(".custom-file-input").on("change", function() {
        var file_name = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label")
                .addClass("selected").html(file_name);
    });
</script>
<?if(!isset($_FILES['image'])):?>

<?elseif($vh->get_error() === VisionHub::ERROR_NO):?>
            <img src="data:image/jpeg;base64,<?=base64_encode($result_file);?>" style="width: 40%; height: 40%;"/>
            <a href='./img.php?token=<?=$vh->get_token();?>&task_id=<?=$task_id;?>' target='_blank'>Ссылка на результат</a>
<?elseif($vh->get_error() === VisionHub::ERROR_FILE):?>
            <p>Не подходящий файл, требудется *.png или *.jpg</p>
<?elseif($vh->get_error() === VisionHub::ERROR_RESPONSE):?>
            <p>Сервер вернул неудовлетворительный результат - попробуйте позже или с другим изображением - мы работаем над улучшением сервиса</p>
<?endif;?>
<br><br><br><br><br><br><br><br><br>
    <div class="fixed-bottom ">
    <footer class="container-fluid">
      <div class="container-fluid">
         <div class="row padding text-center">
            <div class="col-12">
              <h2>Наши контакты</h2>                    
            </div>
             <div class="col-12 social padding">
                <a target="_blank" href="https://twitter.com"><i class="fab fa-twitter"></i></a>
                <a target="_blank" href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
                <a target="_blank" href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                <a target="_blank" href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
          </div>
        </div>
      </div>
    </footer>
  </div>
	</div>
</body>
</html>