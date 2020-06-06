<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" Content="text/html; Charset=utf-8">
		<title>eora 2020 test page</title>
	</head>
	<body>

<?php
    require_once ("vh.class.php");

    if (isset($_FILES['image']))
    {
        $vh = new VisionHub();
        if ($vh->get_error() === VisionHub::ERROR_NO)
        {
            $task_id = $vh->add_process(VisionHub::MODEL_ANIME_SELFIE, 'image');
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
        <form enctype="multipart/form-data" action="" method="post">
            <input type="file" name="image"/>
            <input type="submit" />
        </form>
<?elseif($vh->get_error() === VisionHub::ERROR_NO):?>
        <img src="data:image/jpeg;base64,<?=base64_encode($result_file);?>" />
<?elseif($vh->get_error() === VisionHub::ERROR_FILE):?>
        <p>Не подходящий файл, требудется *.png или *.jpg</p>
<?elseif($vh->get_error() === VisionHub::ERROR_RESPONSE):?>
        <p>Сервер вернул неудовлетворительный результат - попробуйте позже или с другим изображением - мы работаем над улучшением сервиса</p>
<?endif;?>

	</body>
</html>
