<?php
error_reporting(-1);
if (!isset($_COOKIE['test'])) {
    setcookie('test', uniqid());
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <title>Пример страницы</title>
  <style>
      #board {display: none;}
      #hallOfFame {display: none;}
      .cell {display:inline-block; width:30px; height: 30px; background-color: #eeeeee; border:1px solid black;}
  </style>
 </head>
 <body>
  <p>Крестики-нолики</p>
  <ul>
      <li><a href="#" id="play">Играть</a></li>
      <li><a href="#" id="table">Таблица результатов</a></li>
  </ul>

  <div id="board"></div>

  <div id="hallOfFame"></div>

  <script src="http://yastatic.net/jquery/2.2.3/jquery.min.js"></script>
  <script>
      $userId = '<?= uniqid(); ?>';
      $board = $('#board');
      $hallOfFame = $('#hallOfFame');

    function generateBoard() {
        $board.empty();
        for (i = 0; i < 20; i++) {
            $board.append('<div class="row" data-row='+i+'></div>');
            for (j = 0; j < 20; j++) {
                $board.find('.row').last().append('<div class="cell" data-column='+j+'>&nbsp;</div>');
            }
        }
    }

    function generateTable(table) {
        $hallOfFame.empty();
        $hallOfFame.append('<table><tr><td>Имя</td><td>Время</td></tr>');
        for (row in table) {
            $hallOfFame.append('<tr><td>' + table[row][0] + '</td><td>' + table[row][1] + '</td></tr>');
        }
        $hallOfFame.append('</table>');
    }

    $('#play').on('click', function(){
        $.post(
            'ajax.php',
            {action: 'start', user: $userId},
            function(data){console.log('data ' + data)}
        );
        generateBoard();
        $board.show();
        $('#hallOfFame').hide();
    });

    $('#table').on('click', function(){
        $.post(
            'ajax.php',
            {action: 'table'},
            function(data){
                generateTable(JSON.parse(data));
                table = JSON.parse(data);
                console.log('table ' + data + table);
                for (row in table) {
                    console.log(table[row]);
                }
            }
        );
        $board.hide();
        $('#hallOfFame').show();
    });

    $('#board').on('click', '.cell', function(){
        if($(this).html() == '&nbsp;') {
        $.post(
            'ajax.php',
            {action: turn, row: 1, cell: 1},
            function (data){console.log('response ' + data);}
        );
    } else {
        alert("Cell is already taken");
    }
    });
  </script>

 </body>
</html>