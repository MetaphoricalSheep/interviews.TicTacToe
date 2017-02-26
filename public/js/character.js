function Character() {
    this.Id = "";
    this.CharacterName = "";

    this.SetId = (id) => {
        this.Id = id;
        return this;
    };

    this.SetName = (name) => {
        this.CharacterName = name;
        return this;
    };

    return this;
}

function Characters(gameTypeId = 1) {
    let _names = $(".GameSetup .character .character-name");
    let _characters = [];
    let _expectedPlayerCount = 2;
    let _gameTypeId = gameTypeId;

    this.Create = () => {
        _names.each((i, e) => {
            let name = $(e).val().trim();

            if (name === "") {
                alert("Please enter a valid character name!");
                return false;
            }

            if (name.length < 4 || name.length > 80) {
                alert("Character name must be between 4 and 80 characters long.");
                return false;
            }

            if (name === "Marvin") {
                alert("Marvin: Do you want me to sit in a corner and rust or just fall apart where I'm standing?");
                return false;
            }

            if (this.FindByName(name) !== false) {
                alert(name + "!!1! You can't play against yourself...")
                return false;
            }

            _createCharacter(name);
        });
    };

    let _createCharacter = (name) => {
        $.ajax({
            type: "GET",
            url: "/game-setup/create-character/" + name,
            dataType: "json",
            success: (response) => {
                if (response.success === false)
                {
                    alert(response.error);
                    return false;
                }

                let char = new Character().SetId(response.data._id).SetName(response.data._name);
                _characters.push(char);

                if (_characters.length == _expectedPlayerCount)
                {
                    new Game()
                        .AddPlayer(_characters[0].Id)
                        .AddPlayer(_characters[1].Id)
                        .SetGameTypeId(_gameTypeId)
                        .Create();
                }
            }
        });
    };

    this.FindByName = (name) => {
        let result = $.grep(_characters, (c) => { return c.CharacterName.toLocaleLowerCase() === name.toLowerCase() });
        if (result.length === 0) {
            return false;
        }
        return result[0];
    };

    this.FindById = (id) => {
        let result = $.grep(_characters, (c) => { return c.Id === id });
        if (result.length === 0) {
            return false;
        }
        return result[0]
    };

    this.ReturnAll = () => { return _characters };

    if (_gameTypeId == 1) {
        _createCharacter("Marvin");
    }
}

