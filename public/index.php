<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <title>Крестики-нолики</title>
  <style>
      #board {display: none;}
      #hallOfFame {display: none;}
      #yourName {display:none;}
      .cell {display:inline-block; width:30px; height: 30px; background-color: #eeeeee; border:1px solid black;}
  </style>
 </head>
 <body>
  <H1>Крестики-нолики</H1>
  <ul>
      <li><a href="#" id="play">Играть</a></li>
      <li><a href="#" id="table">Таблица результатов</a></li>
  </ul>

  <div id="board"></div>

  <div id="hallOfFame"></div>

  <div id="yourName">
      <input type="hidden" name="time" id="timeSpent" />
        Name: <input id="winner" name="name" />&nbsp;&nbsp;<button id="submit">Send</button>
  </div>

  <script src="http://yastatic.net/jquery/2.2.3/jquery.min.js"></script>
  <script>
      let $userId = '';
      let $board = $('#board');
      let $hallOfFame = $('#hallOfFame');
      let $yourName = $('#yourName');
      let $gameOver = false;

    function generateBoard() {
        $board.empty();
        $gameOver = false;
        for (let i = 0; i < 20; i++) {
            $board.append($('<div>').addClass('row').data('row', i));
            for (let j = 0; j < 20; j++) {
                $board.find('.row').last().append($('<div>').addClass("cell").data('column', j).html('&nbsp;'));
            }
        }
    }

    function generateTable(data) {
        $hallOfFame.empty();
        let tbl = $('<table>').append($('<tr>').append($('<th>').html("Имя")).append($('<th>').html("Время")))
        for (const row in data) {
            tbl.append($('<tr>').append($('<td>').html(data[row][0])).append($('<td>').html(data[row][1])))
        }
        $hallOfFame.append(tbl);
    }

    $('#play').on('click', function(){
        $userId = Math.random().toString(36);
        $.post(
            'ajax.php',
            {action: 'start', user: $userId},
            function(data){}
        );
        generateBoard();
        $board.show();
        $hallOfFame.hide();
        $yourName.hide();
    });

    $('#table').on('click', function(){
        $.post(
            'ajax.php',
            {action: 'table'},
            function(result){
                if (result['message'] === 'table') {
                    generateTable(result['payload']);
                }
            }
        );
        $board.hide();
        $yourName.hide();
        $hallOfFame.show();
    });

    $board.on('click', '.cell', function(){
        if(!$gameOver && !['x', 'o'].includes($(this).html())) {
            var row = $(this).parent().data('row');
            var col = $(this).data('column');
            $.post(
                'ajax.php',
                {action: 'turn', user: $userId, row: row, col: col},
                function (result){
                    for (i = 0; i < 20; i++){
                        for (j = 0; j < 20; j++) {
                            if (result['payload'][i][j] !== 0) {
                                $('#board .row:nth-child(' + (i+1) + ') .cell:nth-child(' + (j+1) + ')').html(result['payload'][i][j]);
                            }
                        }
                    }
                    if (result['message'] === 'you win') {
                        $gameOver = true;
                        $('#yourName').show();
                        $('#timeSpent').val(result['time']);

                    }
                    if (result['message'] === 'you lose') {
                        $gameOver = true;
                        alert('You lose! Game Over!');
                    }

                }
            );
        } else {
            const $alert = ($gameOver) ? 'GameOver' : 'Cell is already taken';
            alert($alert);
        }
    });

    $('#submit').on('click', function(){
        $.post(
            'ajax.php',
            {action: 'winner', user: $userId, name: $('#winner').val(), time: $('#timeSpent').val()},
            function(result){
                $board.hide();
                $yourName.hide();
                $hallOfFame.show();
                generateTable(result['payload']);
            }
        );
    });
  </script>

 </body>
</html>