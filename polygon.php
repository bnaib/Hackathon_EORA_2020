<?php
header('Content-Type: text/html; charset=utf-8');
require_once ("vh.class.php");

if (isset($_FILES['image']))
{
    $vh = new VisionHub();
    if ($vh->get_error() === VisionHub::ERROR_NO)
    {
        $task_id = $vh->add_process(VisionHub::MODEL_POLYGON, 'image');
        if ($vh->get_error() === VisionHub::ERROR_NO)
        {
            $result_url = $vh->get_result_url($task_id);
            if ($vh->get_error() === VisionHub::ERROR_NO)
                $result_file = $vh->get_result_file($result_url);
        }
    }
}
?>
<?if(!isset($_FILES['image'])):?>
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
      <a href="#" class="navbar-brad" ></a>
  </div>
  </nav>
	<div class="merch">
		<div class="container">
			<h1 class="text-center">А каким ты будешь сегодня?</h1>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
          <form enctype="multipart/form-data" action="" method="post">
            <input type="file" name="image"/>
            <input type="submit" />
            </form>
            <br>
            <br>
            <br>
            <div class="container" ml-auto;>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <a class="btn btn-primary btn-lg btn-block" href="index.html" role="button" >Назад</a>
                  </div>
                </div>
            </div>
    <div class="fixed-bottom ">
    <footer class="container-fluid">
      <div class="container-fluid">
         <div class="row padding text-center">
            <div class="col-12">
              <h2>Наши контакты</h2>                    
             </div>
             <div class="col-12 social padding">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
          </div>
        </div>
      </div>      
    </footer>
  </div>
	</div>
</body>
</html>
<?elseif($vh->get_error() === VisionHub::ERROR_NO):?>
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
      <a href="#" class="navbar-brad" ></a>
  </div>
  </nav>
	<div class="merch">
		<div class="container">
			<h1 class="text-center">А каким ты будешь сегодня?</h1>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
          <form enctype="multipart/form-data" action="" method="post">
            <input type="file" name="image"/>
            <input type="submit" />
            </form>
            <img src="data:image/jpeg;base64,<?=base64_encode($result_file);?>" />
            <a href='./img.php?token=<?=$vh->get_token();?>&task_id=<?=$task_id;?>'>Ссылка на результат</a>
            <br>
            <br>
            <br>
            <div class="container" ml-auto;>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <a class="btn btn-primary btn-lg btn-block" href="index.html" role="button" >Назад</a>
                  </div>
                </div>
            </div>
    <div class="fixed-bottom ">
    <footer class="container-fluid">
      <div class="container-fluid">
         <div class="row padding text-center">
            <div class="col-12">
              <h2>Наши контакты</h2>                    
             </div>
             <div class="col-12 social padding">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
          </div>
        </div>
      </div>      
    </footer>
  </div>
	</div>
</body>
</html>
<?elseif($vh->get_error() === VisionHub::ERROR_FILE):?>
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
      <a href="#" class="navbar-brad" ></a>
  </div>
  </nav>
	<div class="merch">
		<div class="container">
			<h1 class="text-center">А каким ты будешь сегодня?</h1>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
          <form enctype="multipart/form-data" action="" method="post">
            <input type="file" name="image"/>
            <input type="submit" />
            </form>
            <p>Не подходящий файл, требудется *.png или *.jpg</p>
            <br>
            <br>
            <br>
            <div class="container" ml-auto;>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <a class="btn btn-primary btn-lg btn-block" href="index.html" role="button" >Назад</a>
                  </div>
                </div>
            </div>
    <div class="fixed-bottom ">
    <footer class="container-fluid">
      <div class="container-fluid">
         <div class="row padding text-center">
            <div class="col-12">
              <h2>Наши контакты</h2>                    
             </div>
             <div class="col-12 social padding">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
          </div>
        </div>
      </div>      
    </footer>
  </div>
	</div>
</body>
</html>
<?elseif($vh->get_error() === VisionHub::ERROR_RESPONSE):?>
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
      <a href="#" class="navbar-brad" ></a>
  </div>
  </nav>
	<div class="merch">
		<div class="container">
			<h1 class="text-center">А каким ты будешь сегодня?</h1>
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
          <form enctype="multipart/form-data" action="" method="post">
            <input type="file" name="image"/>
            <input type="submit" />
            </form>
            <p>Сервер вернул неудовлетворительный результат - попробуйте позже или с другим изображением - мы работаем над улучшением сервиса</p>
            <br>
            <br>
            <br>
            <div class="container" ml-auto;>
                <div class="row justify-content-center">
                  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <a class="btn btn-primary btn-lg btn-block" href="index.html" role="button" >Назад</a>
                  </div>
                </div>
            </div>
    <div class="fixed-bottom ">
    <footer class="container-fluid">
      <div class="container-fluid">
         <div class="row padding text-center">
            <div class="col-12">
              <h2>Наши контакты</h2>                    
             </div>
             <div class="col-12 social padding">
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
          </div>
        </div>
      </div>      
    </footer>
  </div>
	</div>
</body>
</html>
<?endif;?>