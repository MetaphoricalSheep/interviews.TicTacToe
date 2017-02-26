characterSetup = new Characters($(".GameSetup .character").data("gameTypeId"));

$(document).ready(() => {
    let $start = $(".GameSetup .start");
    $start.click(() => {
        characterSetup.Create();
        return false;
    });

    $(".GameSetup .character .character-name").each((i, e) => {
        $(e).keydown((key) => {
            if (key.which === 13) {
                $start.click();
            }
        });
    });

    $(".GameSetup .character #player_1_name").focus();
});

