<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Таблица умножения</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #000;
        }

        .selected {
            font-weight: bold;
            color: blue;
        }

        #product_menu {
            margin-right: 20px;
            display: flex;
            flex-direction: column;
        }

        .container {
            display: flex;
        }

        a:hover {
            color: blue;
            text-decoration: none;
            transition: all 0.6s ease;
        }

        a {
            color: black;
            text-decoration: none;
            transition: all 0.6s ease;
        }
    </style>
</head>

<body>
    <header style="background-color: #336699; color: #fff; padding: 10px 0; display: flex; align-items: center;">
        <div id="main_menu" style="margin-left:10px;">
            <?php
            $contentParam = isset($_GET['content']) ? '&content=' . $_GET['content'] : '';
            $htmlType = $_GET['html_type'] ?? 'TABLE'; //?? - установить значение по умолчанию
            
            echo '<a href="?html_type=TABLE' . $contentParam . '"' .
                ($htmlType === 'TABLE' && isset($_GET['html_type']) ? ' class="selected"' : '') . 
                '>Табличная форма</a> | ';

            echo '<a href="?html_type=DIV' . $contentParam . '"' .
                ($htmlType === 'DIV' ? ' class="selected"' : '') .
                '>Блочная форма</a>';
            ?>


        </div>
    </header>

    <div class="container">
        <div id="product_menu" style="margin-left:10px; margin-top:10px;">
            <?php
            echo '<a href="?html_type=' . ($htmlType ?? 'TABLE') . '&content=all"' .
                (!isset($_GET['content']) || $_GET['content'] === 'all' ? ' class="selected"' : '') .
                '>Вся таблица умножения</a>';

            for ($i = 2; $i <= 9; $i++) {
                echo '<a href="?html_type=' . ($htmlType ?? 'TABLE') . '&content=' . $i . '"' .
                    (isset($_GET['content']) && $_GET['content'] == $i ? ' class="selected"' : '') .
                    ' style="margin-bottom:5px;">Таблица умножения на ' . $i . '</a>';
            }
            ?>

        </div>

        <div id="multiplication_table" style="margin-left:40px; margin-top:10px;">
            <?php
            function outNumAsLink($x, $resetHtmlType = false)//сгенерировать ссылку на указанное число $x
            {
                $link = '?content=' . $x;
                if (!$resetHtmlType && isset($_GET['html_type'])) {
                    $link .= '&html_type=' . $_GET['html_type'];
                }
                echo '<a href="' . $link . '">' . $x . '</a>';
            }

            function outResult($result)//проверить и вывести результат умножения, как ссылку или текст
            {
                // Если результат <= 9, делаем ссылку, иначе выводим просто число
                if ($result <= 9) {
                    outNumAsLink($result, true); // Ссылка на результат
                } else {
                    echo $result; // Просто число
                }
            }

            function outTableForm($number = null) //вывод таблицы в табличной форме
            {
                echo '<table border="2">';
                for ($i = 1; $i <= 9; $i++) {
                    echo '<tr>';
                    if ($number) {
                        echo '<td>';
                        outNumAsLink($number, true);//н-р "?content=5"
                        echo ' x ';
                        outNumAsLink($i, true);
                        echo ' = ';
                        outResult($number * $i);
                        echo '</td>';
                    } else {
                        for ($j = 1; $j <= 9; $j++) {
                            echo '<td>';
                            outNumAsLink($j, true);
                            echo ' x ';
                            outNumAsLink($i, true);
                            echo ' = ';
                            outResult($j * $i);
                            echo '</td>';
                        }
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }

            function outDivForm($number = null)
            {
                echo '<div style="display: flex; flex-wrap: wrap;">';
                for ($i = 1; $i <= 9; $i++) {
                    if ($number) {
                        echo '<div style="width: 100%;">';
                        outNumAsLink($number, true);
                        echo ' x ';
                        outNumAsLink($i, true);
                        echo ' = ';
                        outResult($number * $i); // Используем функцию outResult для результата
                        echo '<br></div>';
                    } else {
                        for ($j = 1; $j <= 9; $j++) {
                            echo '<div style="width: 10%;">';
                            outNumAsLink($j, true);
                            echo ' x ';
                            outNumAsLink($i, true);
                            echo ' = ';
                            outResult($j * $i); // Используем функцию outResult для результата
                            echo '<br></div>';
                        }
                    }
                }
                echo '</div>';
            }
            //определить, какую таблицу отображать и в каком формате
            $content = isset($_GET['content']) && $_GET['content'] != 'all' ? (int) $_GET['content'] : null;

            if ($htmlType == 'TABLE') {
                outTableForm($content);
            } else {
                outDivForm($content);
            }
            ?>
        </div>
    </div>
    <footer>
        <div id="footer"
            style="font-size: 14px; background-color: #336699; color: #fff; padding: 10px 0; text-align: center; position: fixed; bottom: 0; width: 100%;">
            <?php
            date_default_timezone_set('Europe/Moscow');
            echo "<p>Тип верстки: " . ($htmlType === 'TABLE' ? 'Табличная' : 'Блочная') . "</p>";
            echo "<p>Таблица умножения: " . ($content ? "На $content" : 'Полная') . "</p>";
            echo "<p>Дата и время: " . date('Y-m-d H:i:s') . "</p>";
            ?>
        </div>
    </footer>
</body>

</html>