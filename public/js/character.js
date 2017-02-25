function Character() {
    let _id, _name;

    this.SetId = (id) => {
        _id = id;
        return this;
    };

    this.GetId = () => { return _id };

    this.SetName = (name) => {
        _name = name;
        return this;
    };

    this.GetName = () => { return _name };
    return this;
}

function Characters() {
    let _names = $(".GameSetup .character .character-name");
    let _characters = [];

    this.Create = () => {
        _names.each((i, e) => {
            let name = $(e).val();

            if (name.trim() === "") {
                alert("Please enter a valid character name!");
                return false;
            }

            if (name.length < 4 || name.length > 80) {
                alert("Character name must be between 4 and 80 characters long.");
                return false;
            }

            if (this.FindByName(name) === false) {
                let response = _createCharacter(name);

                if (response !== true) {
                    alert(response);
                    return false;
                }
            }
        });

        //proceed
    };

    let _createCharacter = (name) => {
        $.ajax({
            type: "GET",
            url: "/game-setup/create-character/" + name,
            dataType: "json",
            success: (response) => {
                if (response.success) {
                    let char = new Character().SetId(response.id).SetName(response.name);
                    this.Characters.add(char);
                    return true;
                }

                return response.error();
            }
        });
    };

    this.FindByName = (name) => {
        let result = $.grep(_characters, (c) => { return c.name === name });
        if (result.length === 0) {
            return false;
        }
        return result[0];
    };

    this.FindById = (id) => {
        let result = $.grep(_characters, (c) => { return c.id === id });
        if (result.length === 0) {
            return false;
        }
        return result[0]
    };

    this.ReturnAll = () => { return _characters }
}

