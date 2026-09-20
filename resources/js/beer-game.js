const beerGame = document.querySelector('[data-beer-game]');

if (beerGame) {
    const bottle = beerGame.querySelector('[data-beer-bottle]');
    const cup = beerGame.querySelector('[data-beer-cup]');
    const pour = beerGame.querySelector('[data-beer-pour]');
    const cupLiquid = beerGame.querySelector('[data-beer-cup-liquid]');
    const count = beerGame.querySelector('[data-beer-count]');
    let sips = 0;
    let busy = false;

    const render = () => {
        cupLiquid.style.setProperty('--beer-level', `${sips * 25}%`);
        count.textContent = `${sips} / 4 глотка`;
        cup.disabled = sips === 0 || busy;
        bottle.disabled = sips === 4 || busy;
    };

    bottle.addEventListener('click', () => {
        if (busy || sips >= 4) return;

        busy = true;
        bottle.classList.add('is-pouring');
        pour.classList.add('is-active');
        render();

        window.setTimeout(() => {
            sips += 1;
            bottle.classList.remove('is-pouring');
            pour.classList.remove('is-active');
            busy = false;
            render();
        }, 700);
    });

    cup.addEventListener('click', () => {
        if (busy || sips === 0) return;

        busy = true;
        cup.classList.add('is-drinking');

        window.setTimeout(() => {
            sips = 0;
            cup.classList.remove('is-drinking');
            busy = false;
            render();
        }, 550);
    });

    render();
}
