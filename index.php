<?php
require_once "config/db.php";
$create_type = true;
if (isset($_GET['url'])) {
    $create_type = false;
    $new_link = 'https://localhost/link-shortener?url=' . $_GET['url'];
    $checkExiest = $con->query("SELECT * FROM `links` WHERE `new_link` = '$new_link'");
    $result = $checkExiest->fetch_assoc();
    $original_link = $result["original_link"];

    if ($result['type'] == 1) {
        header('Location: ' . $original_link);
    }
}

if (isset($_POST['submit'])) {
    $original_link = $_POST['original_link'];
    $new_link = $_POST['new_link'];
    $type = $_POST['type'];
    $checkDuplicateLink = $con->query("SELECT * FROM `links` WHERE `original_link` = '$original_link' or `new_link` = '$new_link'");
    if ($checkDuplicateLink->num_rows == 0){
        $insert = $con->query("INSERT INTO links ( original_link , new_link , type ) VALUES('$original_link','$new_link', '$type')");
        if ($insert) {
            echo $new_link;
        }else{
            echo "<script>alert('error');</script>";
        }
    }else{
        echo "<script>alert('لینک قبلا ساخته شده');</script>";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لینک کوتاه کننده</title>
    <style>
        *{
            font-family: "Calibri Light", serif;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }

        .text-right{
            text-align: right!important;
        }

        #shorten-form {
            max-width: 400px;
            margin: auto;
        }

        #original_link {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        #new_link {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        #shorten-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }

        #shorten-result {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>لینک کوتاه کننده</h2>

    <?php
    if ($create_type) {
    ?>

        <form id="shorten-form" method="POST">
            <input class="text-right" name="original_link" id="original_link" type="url" placeholder="لینک خود را وارد کنید" required>
            <input name="new_link" id="new_link" type="url" placeholder="لینک کوتاه شده خود را وارد کنید" value="https://localhost/link-shortener?url=" required>
            <select name="type">
                <option value="1">مستقیم</option>
                <option value="0">غیرمستقیم</option>
            </select>
            <button type="submit" name="submit" id="shorten-button">کوتاه کن</button>
        </form>

    <?php
    }else{
    ?>

        <div id="shorten-result" style="display: inline">
            <div style="height: 50px; width: 50px; background: crimson">
                تبلیغات
            </div>
            <div style="height: 50px; width: 50px; background: crimson">
                تبلیغات
            </div>
        </div>
        <a href="<?php echo $original_link ?>">
            کلیک کنید
        </a>

    <?php
    }
    ?>

</body>
</html>