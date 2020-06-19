<?php
    setlocale(LC_TIME, 'french.UTF-8, fr-FR.UTF-8', 'fr.UTF-8', 'fra.UTF-8', 'fr_FR.UTF-8');
    date_default_timezone_set('Europe/Paris');

    function fraStrDate($U) {
        return strftime('%A %d %B %Y', $U -> format('U'));
    }
    function drawCalendar ($nbDaysInMonths,$wdayFirstDay,$selectDate){
        for ($i=1; $i < $nbDaysInMonths+$wdayFirstDay; $i++) { 
            if ($i == 1) {
                echo '<tr>';
            }
            if ($i < $wdayFirstDay){
                echo '<td></td>';
            } else {
                $numDay = $i - $wdayFirstDay + 1;
                if (($selectDate -> format('d')) == $numDay ) {
                    echo '<td class="calendarToday">' . $numDay . '</td>';
                } else {
                    echo '<td class="calendarDay">' . $numDay . '</td>';
                }
            }
            if ($i % 7 == 0 && $i == $nbDaysInMonths+$wdayFirstDay) {
                echo '</tr>';
            }
            if ($i % 7 == 0 && $i != $nbDaysInMonths+$wdayFirstDay) {
                echo '</tr><tr>';
            }
        }
    } 
    function validateDate($date, $format = 'Y-m-d H:i:s'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    
    if (isset($_POST['inputDate']) && $_POST['inputDate'] != NULL && (validateDate($_POST['inputDate'], 'M d, Y'))) {
        $selectDate = new DateTime(htmlspecialchars($_POST['inputDate']));
    } 
    if ((empty($_POST['inputDate']) || $_POST['inputDate'] == NULL) || (empty($selectDate) || $selectDate == NULL) || !(validateDate($selectDate->format('Y-m-d H:i:s')))) {
        $selectDate = new DateTime();
    }


    if (validateDate($selectDate->format('Y-m-d H:i:s'))) {
        $month = $selectDate -> format('m');
        $year = $selectDate -> format('Y');
        $nbDaysInMonths = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $firstDay = new DateTime($year . '-' . $month . '-' . 01);
        $wdayFirstDay = $firstDay->format('N');
    } else {
        echo 'erreur';
    }

    
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
    <link rel="stylesheet" href="assets/css/calender.css">

    <title>PHP TP 1 - Calendrier</title>
</head>

<body class="container">
    <section class="row">

        <div class="col s12">
            <h1>Calendrier ( TP-PHP-1 ):</h1>
            <form action="index.php" method="post" id="formDate">
                <input type="text" class="datepicker" name="inputDate" id="inputDate">
                <input type="submit" value="Aller à">
            </form>
            <p><?= fraStrDate($selectDate)?></p>
            <div class="row">
                <div class="col s1 center">
                    <</div> <div class="col s10">
                        <table id="calendarTable" class="centered">
                            <thead>
                                <tr>
                                    <th colspan="7" class="centered calendarDaysHead">
                                        <?= strftime('%B %Y', $selectDate -> format('U')) ?></th>
                                </tr>
                                <tr class="calendarDaysHead">
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
                                <?php                             
                                 drawCalendar($nbDaysInMonths,$wdayFirstDay,$selectDate);
                            ?>

                            </tbody>

                        </table>
                </div>
                <div class="col s1 center">></div>
            </div>
        </div>


    </section>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('.datepicker');
            var options = {
                format: 'mmm dd, yyyy'
            }
            var instances = M.Datepicker.init(elems, options);
        });

        let daysInMonths = document.getElementsByClassName(`calendarDay`);
        let dateInput = document.getElementById(`inputDate`);
        let formDate = document.getElementById(`formDate`);

        console.log(daysInMonths);
        for (let element of daysInMonths) {
            element.addEventListener(`click`, function () {
                let str1 = element.innerText;
                let str0 = `0`;
                if (str1.length === 1) {
                    var numDay =  str0.concat(str1);
                } else {
                    var numDay = str1;
                }
                console.log(numDay);
                let selectedDate = `<?=$selectDate -> format('M')?> ${numDay}, <?=$selectDate -> format('Y')?>`;
                dateInput.setAttribute(`value`, selectedDate);
                formDate.submit();

                console.log(selectedDate);
            })
        };
    </script>
    <script src="assets/js/calendar.js"></script>
</body>

</html>