function NewGameMenu() {
    let _items = [
        $(".NewGame .menu .item-1"),
        $(".NewGame .menu .item-2"),
        $(".NewGame .menu .item-3")
    ];

    let _active = _items[0];
    let _next = _items[1];
    let _previous = _items[2];
    let _start = $(".NewGame .menu .start");

    this.MoveDown = () => {
        _active.removeClass("active");
        let $oldActive = _active;
        _next.addClass("active");
        _active = _next;
        _next = _previous;
        _previous = $oldActive;
        _update();
    };

    this.MoveUp = () => {
        _active.removeClass("active");
        let $oldActive = _active;
        _previous.addClass("active");
        _active = _previous;
        _previous = _next;
        _next = $oldActive;
        _update();
    };

    this.Start = () => {
        _start[0].click();
    };

    let _update = () => {
        _start.attr("href", "/game-setup/" + _active.data("id"));
        _start.text(_active.data("startLabel"));
    };

    _update();
}

menu = new NewGameMenu();

$(document).keydown((key) => {
    switch (key.which) {
        case 13: // enter
            menu.Start();
            break;

        case 38: // up
            menu.MoveUp();
            break;

        case 40: // down
            menu.MoveDown();
            break;

        default: return;
    }
});
