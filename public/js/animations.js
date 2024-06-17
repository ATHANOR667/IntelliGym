const element = document.querySelector('.container1');

function interpolate(startValue, endValue, stepNumber, totalSteps) {
    return startValue + (endValue - startValue) * (stepNumber / totalSteps);
}

function applyColorTransition(startColor, endColor, duration, callback) {
    const steps = 100;
    const timePerStep = duration / steps;
    let stepNumber = 0;

    const intervalId = setInterval(() => {
        if (stepNumber >= steps) {
            clearInterval(intervalId);
            if (callback) callback(); // Appelle la fonction de rappel une fois la transition terminée
            return;
        }

        const r = Math.round(interpolate(startColor.r, endColor.r, stepNumber, steps));
        const g = Math.round(interpolate(startColor.g, endColor.g, stepNumber, steps));
        const b = Math.round(interpolate(startColor.b, endColor.b, stepNumber, steps));

        element.style.backgroundImage = `linear-gradient(310deg, #141727 0%, rgb(${r}, ${g}, ${b}) 100%)`;

        stepNumber++;
    }, timePerStep);
}

const normalColor = { r: 222, g: 91, b: 9 };
const roseColor = { r: 202, g: 35, b: 113 };

function startTransition() {
    applyColorTransition(normalColor, roseColor, 10000, () => {
        applyColorTransition(roseColor, normalColor, 5000, startTransition);
    });
}

startTransition(); // Lance la transition répétitive




$(document).ready(function () {
    $('.divaverti').hide();
    $('.contmpass').hide();
    $(".continscrip").hide();
    $(".pagesUser2").hide();
    $('.pagesUser').not('.Page1').hide();
    // $(".ulbar").hide();

    //affiche profil
    $('.btninscrire').click(function () {
        $('.connexion').hide();
        $('.continscrip').fadeTo(2000, 1);
        $('.inscription').fadeTo(2000, 1);
    });

    $('.btnconnexion').click(function () {
        $('.inscription').hide();
        $('.continscrip').fadeTo(2000, 1);
        $('.connexion').fadeTo(2000, 1);
    });

    //changer de formulaire a partir des liens
    $('.liensconnexion').click(function () {
        $('.inscription').fadeOut(2000);
        $('.connexion').fadeTo(2000, 1);

    });
    $('.lieninscription').click(function () {
        $('.connexion').fadeOut(2000);
        $('.inscription').fadeTo(2000, 1);
    });
    //tout fermer
    // $('.continscrip').click(function () {
    //     $('.continscrip').fadeOut(1000);
    // })

    //animation de reservation

    $('.divheure').click(function () {
        $('.divaverti').fadeTo(2000, 1);
    });


     //animation de setting profil
     $('.divisecur').click(function() {
        // $('body').css('overflow', 'hidden');
        $('.contmpass').fadeTo(2000, 1);
     });

     $('.contmpass').click(function() {
        // $('body').css('overflow', 'hidden');
        $('.contmpass').fadeOut(2000);
     });



     $('.pluss').click(function() {
        $('.ulbar').fadeTo(2000, 1).css('display', 'flex');
     });
     $('.close').click(function() {
        $('.ulbar').fadeOut(2000);
     });







});
