<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>GWA Calculator</title>
    <style>
        /* Add your custom styles here */
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1 {
            color: #CC0000;
            font-size: 36px;
            text-align: center;
        }

        form {
            width: 600px;
            margin: 0 auto;
            padding: 40px;
            background-color: #FFF;
            border-radius: 50px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        label {
            display: ;
            line-height: 200%;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="number"] {
            width: 90px;
            margin-right: 50px;
        }

        input[type="submit"] {
            display: block;
            margin: 20px auto 0;
            background-color: #CC0000;
            color: #FFF;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #FF3333;
        }

        p {
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>GWA Calculator</h1>
    <form method="post">
        <?php
        if (!isset($_SESSION['num_subjects'])) {
            echo '<label for="num_subjects">Number of subjects:</label>';
            echo '<input type="number" id="num_subjects" name="num_subjects" required>';
            echo '<br>';
            echo '<input type="submit" name="submit_subjects" value="Next">';
        } else {
            $num_subjects = $_SESSION['num_subjects'];
            for ($i=1; $i<=$num_subjects; $i++) {
                echo '<label for="units'.$i.'">Units for subject '.$i.':</label>';
                echo '<input type="number" id="units'.$i.'" name="units'.$i.'" required>';
                echo '<label for="grade'.$i.'">Grade for subject '.$i.':</label>';
                echo '<input type="number" step="0.01" id="grade'.$i.'" name="grade'.$i.'" required>';
                echo '<br>';
            }
            echo '<input type="submit" name="submit_grades" value="Calculate GWA">';
        }
        ?>
    </form>

    <?php
    if (isset($_POST['submit_subjects'])) {
        $_SESSION['num_subjects'] = $_POST['num_subjects'];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } elseif (isset($_POST['submit_grades']) && isset($_SESSION['num_subjects'])) {
        $num_subjects = $_SESSION['num_subjects'];
        $total_units = 0;
        $total_weighted_score = 0;

        for ($i=1; $i<=$num_subjects; $i++) {
            $units = isset($_POST['units'.$i]) ? $_POST['units'.$i] : 0;
            $grade = isset($_POST['grade'.$i]) ? $_POST['grade'.$i] : 0;
            $weighted_score = $units * $grade;
            $total_units += $units;
            $total_weighted_score += $weighted_score;
        }

        $gwa = $total_weighted_score / $total_units;
        echo '<p>Your GWA is: '.number_format($gwa, 2).'</p>';

        unset($_SESSION['num_subjects']);
        echo '<form method="post"><input type="submit" name="reset" value="Reset"></form>';
    }
    ?>

</body>
</html>