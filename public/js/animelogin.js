const element = document.querySelector('.continscrip2');

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
