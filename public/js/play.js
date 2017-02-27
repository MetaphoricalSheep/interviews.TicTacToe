boardDiv = $(".board");
let board = new Board(boardDiv.data("gameId"))
    .SetPlayer1(boardDiv.data("player1"))
    .SetPlayer2(boardDiv.data("player2"))
    .SetCanvas("tic-tac-toe-board");

$(document).ready(() => {
});
