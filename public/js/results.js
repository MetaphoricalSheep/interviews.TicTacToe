$(document).ready(() => {
    $.ajax({
        type: "GET",
        url: "/results/history/500",
        dataType: "json",
        success: (response) => {
            if (response.success === false) {
                alert(response.error);
                return false;
            }

            $.each(response.data, (i, e) => {
                let id = "history_" + e.gameId;
                $(".Results .history").append("<div class='col-md'><canvas id='" + id + "' class='cHistory'></canvas></div>");

                let _board = new Board()
                    .SetPlayer1(e.player1)
                    .SetPlayer2(e.player2)
                    .SetTurn(e.turn)
                    .PopulateBoard(e.board)
                    .SetCanvas(id, 250)
                    .Terminate(e.state);
            });
        }
    });
});

