$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "/results/history/5",
        dataType: "json",
        success: (response) => {
            if (response.success === false) {
                alert(response.error);
                return false;
            }

            $.each(response.data, (i, e) => {
                let id = "history_" + e.gameId;
                $("#sidebar-wrapper.history").append("<div><canvas id='" + id + "' class='history'></canvas></div>");

                let _board = new Board()
                    .SetPlayer1(e.player1)
                    .SetPlayer2(e.player2)
                    .SetTurn(e.turn)
                    .PopulateBoard(e.board)
                    .SetCanvas(id, 150)
                    .Terminate(e.state);
            });
        }
    });


});