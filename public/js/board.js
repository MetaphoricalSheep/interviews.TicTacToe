function Board(gameId) {
    let _gameId = gameId,
        _locked = false,
        _lineColor = "#39ADC6",
        _canvas,
        _context,
        _canvasSize,
        _sectionSize,
        _board = null,
        _turn = 'X',
        _player1 = "",
        _player2 = "",
        _currentPlayer = _player1,
        _gameTypeId,
        _whoami = _player1; //used for AI and multiplayer

    this.SetTurn = (turn) => {
        _turn = turn;

        if (_gameTypeId === 1) {
            if ((turn == "X" && _player1 !== _whoami) || (turn == "O" && _player2 !== _whoami)) {
                _callMarvin();
            }
        }

        return this;
    };

    this.SetGameTypeId = (id) => {
        _gameTypeId = id;
        return this;
    };

    this.SetCanvas = (canvasId, size = 500) => {
        _canvas = document.getElementById(canvasId);
        _context = _canvas.getContext("2d");
        _canvasSize = size;
        _sectionSize = size / 3;
        _CreateBoard();

        if (_turn === "X") {
            _currentPlayer = _player1;
        } else {
            _currentPlayer = _player2;
        }

        if (_gameTypeId === 3) {
            _whoami = _currentPlayer;
        }

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

    let _callMarvin = () => {
        if (_currentPlayer !== _player2 && _gameTypeId !== 1)
        {
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/play/marvin/" + _gameId,
            dataType: "json",
            data: {
                "piece": "O",
                "player": _player2,
            },
            success: (response) => {
                if (response.success === false)
                {
                    alert(response.error);
                    return false;
                }

                this.PopulateBoard(response.data.board);
                _DrawBoard();

                if (response.data.state > 1) {
                    this.Terminate(response.data.state);
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

    let _DrawX = (x, y) => {
        _context.strokeStyle = "#F2640C";
        _context.beginPath();

        if (_canvasSize < 300) {
            _context.lineWidth = 5;
        }

        let offset = _canvasSize / 10;

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
            radius = (_sectionSize - (_canvasSize / 5)) / 2,
            startAngle = 0,
            endAngle = 2 * Math.PI;

        _context.lineWidth = 10;

        if (_canvasSize < 300) {
            _context.lineWidth = 5;
        }

        _context.strokeStyle = "#FFC859";
        _context.strokeStyle = "#02A43E";
        _context.beginPath();
        _context.arc(centerX, centerY, radius, startAngle, endAngle);
        _context.stroke();
    };

    let _ProgressTurn = () => {
        if (_currentPlayer == _player1) {
            _currentPlayer = _player2;
        } else {
            _currentPlayer = _player1;
        }

        if (_gameTypeId === 3) {
            _whoami = _currentPlayer;
        }

        if (_gameTypeId === 1 && _whoami !== _currentPlayer) {
            _callMarvin();
            return;
        }

        _locked = false;
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
                    this.Terminate(response.data.state);
                }

            },
            complete: (jqXHR, status) => {
                if (status === "success") {
                    _ProgressTurn();
                }
            }
        });
    };

    let _AddPiece = (pos) => {
        for (let x = 0; x < 3; x++) {
            for (let y = 0; y < 3; y++) {
                let xCoord = x * _sectionSize,
                    yCoord = y * _sectionSize;

                /**
                14. Results page still needs to be built
                17. do min/max ai
                22. Responsiveness needs work
                 **/

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

        if (_board == null) {
            _board = [[]];
            for (let x = 0; x < 3; x++) {
                _board.push([]);
                for (let y = 0; y < 3; y++) {
                    _board[x].push("");
                }
            }
        } else {
            _DrawBoard();
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

    let _DrawBoard = () => {
        if (_board !== null) {
            for (let x = 0; x < 3; x++) {
                for (let y = 0; y < 3; y++) {
                    switch (_board[x][y]) {
                        case "X":
                            _DrawX(x * _sectionSize, y * _sectionSize);
                            break;
                        case "O":
                            _DrawO(x * _sectionSize, y * _sectionSize);
                            break;
                    }
                }
            }
        }
    };

    let _drawWinner = (p) => {
        let offset = _canvasSize / 10;
        let lineStart = (_sectionSize / 2) - (_sectionSize/3);
        let lineLength = (_sectionSize * 2.5) + (_sectionSize/3);

        _context.strokeStyle = "#77A836";
        _context.lineWidth = 20;

        if (_canvasSize < 300) {
            _context.lineWidth = 10;
        }

        _context.beginPath();

        // horizontal win
        for (let x = 0; x < 3; x++) {
            if (p === _board[x][0] && p === _board[x][1] && p === _board[x][2]) {
                _context.moveTo(0.5 * _sectionSize * (x * 2 + 1), lineStart);
                _context.lineTo(0.5 * _sectionSize * (x * 2 + 1), lineLength);
            }
        }

        // vertical win
        for (let y = 0; y < 3; y++) {
            if (p === _board[0][y] && p === _board[1][y] && p === _board[2][y]) {
                _context.moveTo(lineStart, 0.5 * _sectionSize * (y * 2 + 1));
                _context.lineTo(lineLength, 0.5 * _sectionSize * (y * 2 + 1));
            }
        }

        // diagonal left to right
        if (p === _board[0][0] && p === _board[1][1] && p === _board[2][2]) {
            _context.moveTo((_sectionSize - offset - _canvasSize / 100) * 4, (_sectionSize - offset - _canvasSize / 100) * 4);
            _context.lineTo(0.5 + offset, 0.5 + offset);
        }

        // diagonal right to left
        if (p === _board[2][0] && p === _board[1][1] && p === _board[0][2]) {
            _context.moveTo((_sectionSize - offset - _canvasSize * 0.01) * 4, 0.5 + offset);
            _context.lineTo(0.5 + offset, (_sectionSize - offset - _canvasSize * 0.01) * 4);
        }

        _context.stroke();

        if (_canvas.className !== "history") {
            $(".Play .buttons").removeClass("hidden");
        }
    };

    this.Terminate = (state) => {
        if (state == 2) {
            if (_canvas.className !== "history") {
                $(".Play .status").text("Player 1 Wins");
            }
            _drawWinner("X");
            _locked = true;
        } else if (state == 3) {
            if (_canvas.className !== "history") {
                $(".Play .status").text("Player 2 Wins");
            }
            _drawWinner("O");
            _locked = true;
        } else if (state == 4) {
            if (_canvas.className !== "history") {
                $(".Play .status").text("Draw");
                $(".Play .buttons").removeClass("hidden");
            }
            _locked = true;
        }

        return this;
    };

    this.PopulateBoard = (flatBoard) => {
        _board = [[]];
        for (let x = 0, y = 0, px = 0; x < 9; x++, y++) {
            if (y === 3) {
                y = 0;
                px++;
                _board[px] = [];
            }
            _board[px][y] = flatBoard[x];
        }

        return this;
    };

    return this;
}
