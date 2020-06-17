<?php
    setlocale(LC_TIME, 'french.UTF-8, fr-FR.UTF-8', 'fr.UTF-8', 'fra.UTF-8', 'fr_FR.UTF-8');
    date_default_timezone_set('Europe/Paris');

    function fraStrDate($U) {
        return strftime('%A %d %B %Y', $U -> format('U'));
    }
    function drawCalendar ($nbDaysInMonths,$wdayFirstDay){
        for ($i=1; $i < $nbDaysInMonths+$wdayFirstDay; $i++) { 
            if ($i == 1) {
                echo '<tr>';
            }
            if ($i < $wdayFirstDay){
                echo '<td></td>';
            } else {
                $a = $i - $wdayFirstDay + 1;
                echo '<td>' . $a . '</td>';
            }
            if ($i % 7 == 0 && $i == $nbDaysInMonths+$wdayFirstDay) {
                echo '</tr>';
            }
            if ($i % 7 == 0 && $i != $nbDaysInMonths+$wdayFirstDay) {
                echo '</tr><tr>';
            }
        }
    } 

    if (isset($_POST['inputDate']) && $_POST['inputDate'] != null ) {
        $month = date_parse($_POST['inputDate'])['month'];
        $year = date_parse($_POST['inputDate'])['year'];
        $selectDate = new DateTime($_POST['inputDate']);
    } else {
        $selectDate = new DateTime();
        $month = $selectDate -> format('m');
        $year = $selectDate -> format('Y');
        var_dump($month, $year);
    }
    $nbDaysInMonths = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDay = new DateTime($year . '-' . $month . '-' . 01);
    $wdayFirstDay = $firstDay->format('N');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <title>PHP TP 1 - Calendrier</title>
</head>

<body class="container">
    <section class="row">
        <h1>Calendrier ( TP-PHP-1 ):</h1>
        <div class="col">
            <form action="index.php" method="post">
                <input type="text" class="datepicker" name="inputDate" id="inputDate">
                <input type="submit" value="Aller à">
            </form>
            <p><?= fraStrDate($selectDate)?></p>

            <table class="centered">
                <thead>
                    <tr>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                        <th>Samedi</th>
                        <th>Dimanche</th>
                    </tr>
                </thead>
                <tbody id="tbcalendar">
                    <?php drawCalendar($nbDaysInMonths,$wdayFirstDay) ?>

                </tbody>

            </table>


        </div>


    </section>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('.datepicker');
            var options = {format: 'mmm dd, yyyy'}
            var instances = M.Datepicker.init(elems, options);
        });
    </script>
</body>

</html>