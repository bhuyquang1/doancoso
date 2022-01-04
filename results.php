<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kết quả</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .wrapper {
                margin: 20px auto;
                width: 800px;
                height: 600px;
                padding: 10px;
                border: 2px solid #ddd;
            }
            .content {
                height: 100%;
                overflow: auto;
                text-align: justify;
            }
            .logout {
                margin: 0 auto;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
            $data = file('Source code/questions.txt') or die('Cannot read file');
            $point = 0;
            array_shift($data);

            foreach ($data as $key => $value) {
                $tmpArr = explode('|', $value);
                $id       = $tmpArr[0];
                $point += $_POST[$id];
            }
            $data = file('Source code/results.txt') or die('Cannot read file');
            array_shift($data);
            foreach ($data as $key => $value) {
                $tmpArr = explode('|', $value);
                $min    = $tmpArr[0];
                $max   = $tmpArr[1];
                $content           = $tmpArr[2];
                if($point >= $min && $point <= $max) {
                    $result = $content;
                    break;
                }
            }
        ?>
        <div class="wrapper">
            <div class="content">
                <h1>Kết quả derby Manchester</h1>
                <p>
                    <b>Tổng số điểm của <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> là: </b><?php echo $point;?>
                </p>
                <p style='margin-top: 10px; text-align: justify;'>
                    <b>Kết quả trắc nghiệm của <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>: </b><?php echo $result;?>
                </p>
                <div class="logout"><a href="logout.php" class="btn btn-danger ml-3">Đăng xuất và kết thúc bài thi</a></div>
            </div>
        </div>
    </body>
</html>
