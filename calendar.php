
<?php
/*

  Да се създаде работещ календар. За целта трябва да бъдат изпълнени следните условия:

  1. При избран месец от падащото меню и попълнена година в полето - да се визуализира календар за въпросните месец и година
  2. Ако не е избран месец или година, да се използват текущите (пример: ноември, 2021)
  3. Месецът и годината, за които е показан календар да са попълнени в падащото меню и полето за година
  4. При натискане на бутон "Today" да се показва календар за текущите месец и година

  5. В първия ред на календара да има:
  1. Стрелка на ляво, която да показва предишния месец при кликване
  2. Текст с името на месеца и годината, за които са показани дните
  3. Стрелка в дясно, която да показва следващия месец при кликване

  6. Таблицата да показва дни от предишния и/или следващия месец до запълване на седмиците (пример: Ако месеца започва в сряда, да се покажат последните два дни от предишния месец за вторник и понеделник)
  7. Показаните дни в таблицата трябва да са черни и удебелени за текущия месец, и сиви за предишен или следващ месец (css клас "fw-bold" за текущия месец и "text-black-50" за останалите)

 */
//Масиви, в които се запазват имената на дните и месеците
$dayNames = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
$monthsNames = array(
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July ',
    'August',
    'September',
    'October',
    'November',
    'December',
);

$currentDate; //запазва текущата дата
$currentDateArray; //масив, запазващ отделните съставни части на датата - ден, месец, година

$firstDayOfMonth = ""; //в кой ден (пон.-нед.)е 1ви от дадения месец
$daysNumberInMonth = 30; //брой дни в даден месец

$dayIndex = 0; //индекса на първия ден от месец в масива $dayNames

$currentDay = 1; //инкрементира се за да запълни таблицата с датите
$selectedMonthString;

//1. При избран месец от падащото меню и попълнена година в полето - да се визуализира календар за въпросните месец и година
//2. Показване на текущите месец и година, в случай че не са избрани във формата

if (strtolower($_SERVER['REQUEST_METHOD']) === 'get') {
    //Запазване на текущата дата
        $currentDate = date('Y.m.d');
    //Парсване на стринга, за да вземем текущите стойности за ден, месец, година 
        $currentDateArray = date_parse_from_format('Y.m.d', $currentDate);

    //Текущите месец и година се задават като избрани, за да се използват в случай, че потребителя не избере други
        $selectedMonth = $currentDateArray["month"];
        $selectedMonthString = date("F", mktime(0, 0, 0, $selectedMonth));
        $selectedYear = $currentDateArray["year"];
       
 }
//Проверка дали има метод POST и дали са избрани месец и година
 else if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (!empty($_POST['m']) && !empty($_POST['y'])) {

        $selectedMonth = $_POST['m'];
        $selectedMonthString = date('F', mktime(0, 0, 0, $selectedMonth, 10));
        $selectedYear = $_POST['y'];

//Намира първия ден на избран месец
        $firstDayOfMonth = date("D", mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));

//Намира броя на дните в  избран месец
        $daysNumberInMonth = date("t", mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));

//Намира индекса на деня, в който се пада 1ви 
        for ($i = 0; $i < 7; $i++) {

            if ($dayNames[$i] === $firstDayOfMonth) {
                //Взема индекса на първия ден от месеца, като срявнява с имената на дните, намиращи се в масива $dayNames
                $dayIndex = array_search($firstDayOfMonth, $dayNames);
                break;
            }
            //Започва да попълва таблицата на месеца, докато стигне до последния ден според $daysNumberInMonth
        }
        //календара да визуализира месеца
    }
} else {
    //Some Error
}
?>

<!doctype html>
<html lang = "en">
    <head>
        <!--Required meta tags-->
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">

        <!--Bootstrap CSS-->
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel = "stylesheet" integrity = "sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin = "anonymous">

        <title>Calendar</title>
    </head>
    <body>
        <div class = "container">
            <div class = "row">
                <div class = "col">
                    <h1>Calendar</h1>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                    <form class = "row g-3" method = "post" action = "?<?= $_SERVER['PHP_SELF']; ?>">
                        <div class = "col-md-6 col-lg-6">
                            <label class = "form-label" for = "month">Select month:</label>
                            <select name = "m" class = "form-control" id = "month">
                                <!-- Падащо меню с месеци за избор -->
                                <?php foreach ($monthsNames as $var => $month): ?>
                                    <option value="<?php echo $var + 1 ?>"
                                    <?php if ($var == ($selectedMonth - 1)): ?> 
                                                selected="selected"
                                            <?php endif; ?>>
                                                <?php echo $month ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class = "col-md-6 col-lg-6">
                            <label class = "form-label" for = "year">Year:</label>
                            <input type = "text" name = "y" class = "form-control" value = <?= $selectedYear ?>>
                        </div>
                        <div class = "col-md-12 col-lg-12">
                            <button type = "submit" class = "btn btn-primary">Show</button>
                            <!-- При натискане на бутон "Today" да се показва календар за текущите месец и година-->
                            <a href = "?m=<?= $currentDateArray["month"]; ?>&y=<?= $currentDateArray["year"]; ?>" class = "btn btn-secondary">Today</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-6 mt-5 offset-md-3 col-lg-6 offset-lg-3">
                    <table class = "table table-bordered text-center">
                        <thead>
                            <!--Показва стрелки за минал и следващ месец-->
                        <th>
                            <?php $selectedMonth -= 1;
                           if($selectedMonth === 1) :
                               $selectedYear -= 1;
                           endif;?>
                            <a  href = "?m=<?= $selectedMonth; ?>&y=<?= $selectedYear; ?>" title = "Previous month">&larr;
                            </a>
                        </th>
                        <th colspan = "5" class = "text-center"><?= $selectedMonthString . ', ' . $selectedYear; ?></th>
                        <th>
                            <?php $selectedMonth += 1;
                           if($selectedMonth === 12) :
                               $selectedYear += 1;
                           endif;?>
                            <a href = "?m=<?= $selectedMonth; ?>&y=<?= $selectedYear; ?>" title = "Next month">&rarr;
                            </a>
                        </th>

                        <tr>
                            <!--Показване на имената на дните от седмицата -->
                            <?php for ($day = 0; $day < 7; $day++): ?>
                                <th><?php echo $dayNames[$day]; ?></th>
                            <?php endfor; ?>
                        </tr>
                        </thead>
                        <tbody>
                            <!-- Показва дните за съответния избран  месец: -->

                            <tr>
                                <!--Дните на предишния месец в по-светъл цвят -->
                                <?=$prevMonthDayNum = date("t", mktime(0, 0, 0, $selectedMonth - 1, 1, $selectedYear));//колко дни има предходния месец
                                    ?>
                                <?php for ($i = 0; $i < $dayIndex; $i++):?>
                                <!--От броя на дните в месеца изваждаме индекса на дена,в който започва избрания месец +1, тъй като броим от 0-->
                                    <td class="text-black-50"><?= $prevMonthDayNum-$dayIndex+1 ?> </td>
                                    <?=$prevMonthDayNum++;?>
                                    <?php endfor;
                                //Принтират се дните от месеца според $daysNumberInMonth
                                while ($currentDay <= $daysNumberInMonth):
                                    if (($dayIndex < 7)): ?>
                                        <td class="fw-bold"><?= $currentDay; ?> </td>
                                        <?=
                                        $currentDay++;
                                        $dayIndex++;
                                        ?>
                                        <?php else:
                                        $dayIndex = 0;
                                        ?>
                                        <!--За да минем на нов ред, когато сме стигнали неделя-->
                                    </tr><tr>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                                <!--Запълваме празните клетки с дните на следващия месец в по-светъл цвят -->
                                   <?= $nextMonthStartDay = 1;
                                     for ($i = $dayIndex; $i < 7; $i++):
                                    ?>
                                    <td class="text-black-50"><?= $nextMonthStartDay; ?> </td>
                                    <?= $nextMonthStartDay++;?>
                                <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>