function Board(gameId) {
    let _gameId = gameId,
        _locked = false,
        _lineColor = "#39ADC6",
        _canvas,
        _context,
        _canvasSize,
        _sectionSize,
        _board = [[]],
        _player1 = "",
        _player2 = "",
        _currentPlayer = _player1,
        _whoami = _player1; //used for AI and multiplayer

    this.SetCanvas = (canvasId, size = 500) => {
        _canvas = document.getElementById(canvasId);
        _context = _canvas.getContext("2d");
        _canvasSize = size;
        _sectionSize = size / 3;
        _CreateBoard();
        return this;
    };

    this.SetPlayer1 = (id) => {
        _player1 = id;
        _currentPlayer = id;
        _whoami = id;
        return this;
    };

    this.SetPlayer2 = (id) => {
        _player2 = id;
        return this;
    };

    this.SetLineColor = (color) => {
        _lineColor = color;
        return this;
    };

    let _DrawX = (x, y) => {
        _context.strokeStyle = "#f1be32";
        _context.beginPath();

        let offset = 50;

        _context.moveTo(x + offset, y + offset);
        _context.lineTo(x + _sectionSize - offset, y + _sectionSize - offset);

        _context.moveTo(x + offset, y + _sectionSize - offset);
        _context.lineTo(x + _sectionSize - offset, y + offset);

        _context.stroke();
    };

    let _DrawO = (x, y) => {
        let halfSectionSize = (0.5 * _sectionSize),
            centerX = x + halfSectionSize,
            centerY = y + halfSectionSize,
            radius = (_sectionSize - 100) / 2,
            startAngle = 0,
            endAngle = 2 * Math.PI;

        _context.lineWidth = 10;
        _context.strokeStyle = "#01bBC2";
        _context.beginPath();
        _context.arc(centerX, centerY, radius, startAngle, endAngle);
        _context.stroke();
    };

    let _ProgressTurn = () => {
        if (_currentPlayer == _player1) {
            _whoami = _player2;
        } else {
            _whoami = _player1;
        }
        _currentPlayer = _whoami
    };

    let _ValidateMove = (x, y, boardX, boardY) => {
        if (_board[boardX][boardY] !== "") {
            return false;
        }

        // if not your turn in multiplayer or singleplayer, do nothing
        if (_currentPlayer !== _whoami) {
            return false;
        }

        let piece = "X";
        let player = _player1;

        if (_currentPlayer === _player2) {
            piece = "O";
            player = _player2;
        }

        _locked = true;

        $.ajax({
            type: "POST",
            url: "/play/move/" + _gameId,
            dataType: "json",
            data: {
                "piece": piece,
                "player": player,
                "x": boardX,
                "y": boardY,
            },
            success: (response) => {
                if (response.success === false)
                {
                    alert(response.error);
                    return false;
                }

                if (response.data.piece == "X") {
                    _DrawX(x, y);
                } else {
                    _DrawO(x, y);
                }
                _board[boardX][boardY] = response.data.piece;

                if (response.data.state > 1) {
                    _terminate(response.data.state);
                }

            },
            complete: (jqXHR, status) => {
                if (status === "success") {
                    _ProgressTurn();
                }

                _locked = false;
            }
        });
    };

    let _AddPiece = (pos) => {
        for (let x = 0; x < 3; x++) {
            for (let y = 0; y < 3; y++) {
                let xCoord = x * _sectionSize,
                    yCoord = y * _sectionSize;

                /**8. This will trigger the win highlight method
                9. The state of the game will already be updated on the backend
                10. no further moves allowed.
                11. Bring up a back or rematch button
                12. Players still needs to be randomized
                13. results screen still needs to populate
                14. Results page still needs to be built
                15. colors of pieces needs to be customizable
                16. do basic (random) ai
                17. do min/max ai
                18. do ai taunts
                19. do character customization
                20. show avatars on new game screen so that you can pick one
                21. mouse interaction on main menu...

                 winner is not set
                 date ended is not set
                 highlight needs to move to correct position
                 draw does not notify or draw the last marker**/

                if (pos.x >= xCoord && pos.x <= xCoord + _sectionSize && pos.y >= yCoord
                    && pos.y <= yCoord + _sectionSize) {
                    _ValidateMove(xCoord, yCoord, x, y);
                    return;
                }
            }
        }
    };

    let _GetCanvasMousePosition = (e) => {
        let rect = _canvas.getBoundingClientRect();
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        }
    };

    let _CreateBoard = () => {
        _canvas.width = _canvasSize;
        _canvas.height = _canvasSize;
        _context.translate(0.5, 0.5);
        _DrawLines(10);

        _canvas.addEventListener('mouseup', (e) => {
            if (!_locked) {
                let pos = _GetCanvasMousePosition(e);
                _AddPiece(pos);
                _DrawLines(10);
            }
        });

        for (let x = 0; x < 3; x++) {
            _board.push([]);
            for (let y = 0; y < 3; y++) {
                _board[x].push("");
            }
        }
    };

    let _DrawLines = (width) => {
        let lineStart = 4;
        let lineLength = _canvasSize - 5;
        _context.lineWidth = width;
        _context.lineCap = 'round';
        _context.strokeStyle = _lineColor;
        _context.beginPath();

        for (let y = 1, x = 1; y <= 2; y++, x++) {
            _context.moveTo(lineStart, y * _sectionSize);
            _context.lineTo(lineLength, y * _sectionSize);
            _context.moveTo(x * _sectionSize, lineStart);
            _context.lineTo(x * _sectionSize, lineLength);
        }
        _context.stroke();
    };

    let _drawWinner = () => {
        _context.strokeStyle = "#77A836";
        _context.lineWidth = 15;
        _context.beginPath();

        let lineStart = (_sectionSize / 2) - (_sectionSize/3);
        let lineLength = (_sectionSize * 2.5) + (_sectionSize/3);

        //vertical
        let x = 3;
        _context.moveTo(0.5 * _sectionSize * x, lineStart);
        _context.lineTo(0.5 * _sectionSize * x, lineLength);

        //horizontal
        let y = 5;
        _context.moveTo(lineStart, 0.5 * _sectionSize * y);
        _context.lineTo(lineLength, 0.5 * _sectionSize * y);


        let offset = 50;

        //diagonal  0, 8
        _context.moveTo((_sectionSize - offset) * 4, (_sectionSize - offset) * 4);
        _context.lineTo(0.5 + offset, 0.5 + offset);

        //diagonal 3, 7
        _context.moveTo((_sectionSize - offset - 5) * 4, 0.5 + offset);
        _context.lineTo(0.5 + offset, (_sectionSize - offset - 5) * 4);

        _context.stroke();
    };

    let _terminate = (state) => {
        _locked = true;
        if (state == 2) {
            alert("Player 1 wins");
            _drawWinner();
        } else if (state == 3) {
            alert("Player 2 wins");
            _drawWinner();
        } else {
            alert("Draw");
        }
    };

    return this;
}
