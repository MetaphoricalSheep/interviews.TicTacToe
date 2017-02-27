function Game() {
    let _playerIds = [];
    let _gameTypeId = [];

    this.AddPlayer = (id) => {
        _playerIds.push(id);
        return this;
    };

    this.GetGameTypeId = () => {
        return _gameTypeId;
    };

    this.SetGameTypeId = (id) => {
        _gameTypeId = id;
        return this;
    };

    this.Create = () => {
        if (_playerIds.length !== 2) {
            alert("Two players makes a game! Play against Marvin if you're feeling depressed.");
            return false;
        }
        _createGame();
    };

    let _createGame = () => {
        $.ajax({
            type: "POST",
            url: "/game-setup/create-game",
            dataType: "json",
            data: {
                "players": [_playerIds[0], _playerIds[1]],
                "gameType": _gameTypeId
            },
            success: (response) => {
                if (response.success === false)
                {
                    alert(response.error);
                    return false;
                }
                window.location.href = "/play/" + response.data.gameid;
            },
            error: (a, b) => {
                alert(b);
            }
        });
    };

    return this;
}
