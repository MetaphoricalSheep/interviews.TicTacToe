$(document).ready(() => {
    boardDiv = $(".board");
    let board = new Board(boardDiv.data("gameId"))
        .SetPlayer1(boardDiv.data("player1"))
        .SetPlayer2(boardDiv.data("player2"))
        .SetGameTypeId(boardDiv.data("gameTypeId"));

    $.ajax({
        type: "GET",
        url: "/results/board/" + boardDiv.data("gameId"),
        dataType: "json",
        success: (response) => {
            if (response.success === false) {
                alert(response.error);
                return false;
            }

            board
                .PopulateBoard(response.data.board)
                .SetCanvas("tic-tac-toe-board")
                .Terminate(response.data.state)
                .SetTurn(response.data.turn);
        }
    });

    $(".Play .buttons .rematch").click(() => {
        new Game()
            .AddPlayer(boardDiv.data("player1"))
            .AddPlayer(boardDiv.data("player2"))
            .SetGameTypeId(boardDiv.data("gameTypeId"))
            .Create();
        return false;
    })
});

