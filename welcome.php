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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Làm bài thi</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body{ font: 14px sans-serif; text-align: center; }
            .buttons { float: right;}
            .welcome { float: right;}
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

            .content h1 {
                color: red;
                text-align: center;
                padding: 10px 0px;
            }

            .question {
                font-size: 18px;
                line-height: 24px;
            }

            .question p {
                font-size: 20px;
                line-height: 30px;
            }

            .question p span {
                font-weight: bold;
            }

            .question ul li {
                list-style-type: none;
                padding-left: 40px;
            }

            .content input[type="submit"] {
                margin: 0 auto;
                display: block;
                height: 40px;
                width: 100px;
                border-radius: 5px;
                font-weight: bold;
                font-size: 18px;
            }
            #dongho {
                font-size: 18px;
                font-family: sans-serif;
                margin: 25px;
            }
        </style>
    </head>
    <body>
        <div style="overflow: hidden;">
            <div class="buttons my-1 ml-5">
                <a href="change_password.php" class="btn btn-warning">Đặt lại mật khẩu</a>
                <a href="logout.php" class="btn btn-danger ml-3">Đăng xuất</a>
            </div>
            <div class="welcome"><h1 class="my-1 mr-5">Chào mừng bạn <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1></div>
        </div>
        <div id="dongho">
                Thời gian còn lại: <span id="m"></span>:<span id="s"></span>
            </div>
        <script language="javascript">
                totalSecs = 2700;
                m = parseInt(Math.floor(totalSecs / 60));
                s = parseInt(totalSecs % 60);
                
                var timeout = null; // Timeout
                
                function start()
                {
                
                    /*BƯỚC 1: CHUYỂN ĐỔI DỮ LIỆU*/
                    // Nếu số giây = -1 tức là đã chạy ngược hết số giây, lúc này:
                    //  - giảm số phút xuống 1 đơn vị
                    //  - thiết lập số giây lại 59
                    if (s === -1){
                        m -= 1;
                        s = 59;
                    }
                
                    // Nếu số phút = -1 tức là đã chạy ngược hết số phút, lúc này:
                    //  - giảm số giờ xuống 1 đơn vị
                    //  - thiết lập số phút lại 59
                    if (m === -1){
                        clearTimeout(timeout);
                        document.getElementById("mainForm").submit(); 
                        return false;
                    }
                
                    /*BƯỚC 1: HIỂN THỊ ĐỒNG HỒ*/
                    document.getElementById('m').innerText = m;
                    document.getElementById('s').innerText = s;
                
                    /*BƯỚC 1: GIẢM PHÚT XUỐNG 1 GIÂY VÀ GỌI LẠI SAU 1 GIÂY */
                    timeout = setTimeout(function(){
                        s--;
                        start();
                    }, 1000);
                }
                
                start();
            </script>
        <div class="wrapper">
            <?php
                require_once "function_question.php";
                require_once "function_answer.php";
                
                $newArr = array();
                foreach ($arrQuestions as $key => $value) {
                    $newArr[$key]['question'] = $value['question'];
                    $newArr[$key]['sentences'] = $arrOptions[$key];
                }
            ?>
            <div class="content">
                <h1>Derby Manchester</h1>
                <form action="results.php" method="POST" name="mainForm" id="mainForm">
                <?php
                    $i = 1;
                    foreach ($newArr as $key => $value) {
                        echo '<div class="question">';
                        echo '<p><span>Câu hỏi '.$i.': </span>'.$value['question'].'</p>';
                        echo '<ul>';
                        foreach ($value['sentences'] as $keyC => $valueC) {
                                    echo '<li><label><input type="radio" name="'.$key.'" value="'.$valueC["point"].'"> '.$valueC["option"].'</label></li>';
                        }
                        echo '</ul>';
                        $i++;
                        echo '</div>';
                    }
                ?>
                <input type="submit" value="Kết thúc bài thi" name="submitButton" role="button" class="btn btn-primary" style="width: 200px;">
                </form>
            </div>
        </div>
    </body>
</html>