
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

//Запазване на текущата дата
$currentDate = date('Y.m.d');

//Парсване на стринга, за да вземем текущите стойности за ден, месец, година 
$currentDateArray;
$currentDateArray = date_parse_from_format('Y.m.d', $currentDate);
$selectedMonth = $currentDateArray["month"];
$selectedYear = $currentDateArray["year"];
$firstDayOfMonth = 1;
$daysNumberInMonth = 30;

//1. При избран месец от падащото меню и попълнена година в полето - да се визуализира календар за въпросните месец и година
//Проверка дали има метод POST и дали са избрани месец и година
if (strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    if (!empty($_POST['m']) && !empty($_POST['y'])) {

        $selectedMonth = $_POST['m'];
        $selectedYear = $_POST['y'];

        //Намира първия ден на  избран месец
        $firstDayOfMonth = mktime(0, 0, 0, $_POST['m'], 1, $_POST['y']);

        //Намира броя на дните в  избран месец
        $daysNumberInMonth = date("t", $firstDayOfMonth);
    }
//2. Показване на текущите месец и година, в случай че не са избрани във формата
} else {
    
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
                                    <?php foreach ($monthsNames as $var => $month): ?>
                                        <option value="<?php echo $var+1 ?>"
                                            <?php if ($var == ($selectedMonth-1)): ?> 
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
                            <a href = "?m=<?= $currentDateArray["month"]; ?>&y=<?= $currentDateArray["year"]; ?>" class = "btn btn-secondary">Today</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class = "row">
                <div class = "col-md-6 mt-5 offset-md-3 col-lg-6 offset-lg-3">
                    <table class = "table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>
                                    <a href = "?m=10&y=2021" title = "Previous month">&larr;
                                    </a>
                                </th>
                                <th colspan = "5" class = "text-center">November, 2021</th>
                                <th>
                                    <a href = "?m=12&y=2021" title = "Next month">&rarr;
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th><?= $dayNames[0]; ?></th>
                                <th><?= $dayNames[1]; ?></th>
                                <th><?= $dayNames[2]; ?></th>
                                <th><?= $dayNames[3]; ?></th>
                                <th><?= $dayNames[4]; ?></th>
                                <th><?= $dayNames[5]; ?></th>
                                <th><?= $dayNames[6]; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--remove the following and add your code to display the days of month: -->
                            <!--                            
                                                            <td class="fw-bold">1</td>
                                                            <td class="fw-bold">2</td>
                                                            <td class="fw-bold">3</td>
                                                            <td class="fw-bold">4</td>
                                                            <td class="fw-bold">5</td>
                                                            <td class="fw-bold">6</td>
                                                            <td class="fw-bold">7</td>
                                                        </tr>-->
                            <tr>
                                <?php
                                for ($i = 1; $i < 7; $i++):
                                    for ($j = $i; $j <= $daysNumberInMonth; $j++):
                                        $firstDayOfMonth = 1;
                                        ?>
                                        <td class="fw-bold"> <?= $j; ?></td>
                                <?php endfor; ?>
                                </tr>
<?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>