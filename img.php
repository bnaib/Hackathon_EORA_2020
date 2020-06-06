<?php
    require_once ("vh.class.php");
    $vh = new VisionHub($_GET['token']);
    $result_url = $vh->get_result_url($_GET['task_id']);
    if($vh->get_error() !== VisionHub::ERROR_NO)
    {
        header('Content-Type:text/plain');
        echo 'Что то пошло не так';
        die();
    }
    $result_file = $vh->get_result_file($result_url);

    if($vh->get_error() !== VisionHub::ERROR_NO)
    {
        header('Content-Type:text/plain');
        echo 'Что то пошло не так 2';
        die();
    }
    header("Content-type: image/jpeg");
    echo $result_file;
?>