function calcMaxBoatSpeed() {
    const boatWeightInput = document.getElementById("boat-weight");
    const horsepowerInput = document.getElementById("horsepower");
    const hullTypeInput = document.getElementById("hull-type");
    const resultSpeedText = document.getElementById("result-speed");

    const boatWeight = boatWeightInput.value;
    const boatHorsepower = horsepowerInput.value;
    const boatHullTypeValue = calculateHullTypeConstant(hullTypeInput.value);

    if(
        isNaN(boatWeight) || isNaN(boatHorsepower) || isNaN(boatHullTypeValue) ||
        boatWeight < 0 || boatWeight >= 45000 || boatHorsepower < 0 || boatHorsepower >= 750
        ) {
            alert("Inputs invalid. Boat weight: (0-44999), Horsepower: (0-749).");
            console.log(`boatWeightInput: ${boatWeight}; horsepowerInput: ${boatHorsepower}.`)
    } else {
        const boatSpeed = (boatHorsepower/boatWeight) * boatHullTypeValue;
        resultSpeedText.innerHTML = boatSpeed.toFixed(2);
    }
        
}

function calculateHullTypeConstant(hullType) {
    switch(hullType) {
        case "heavy-v-bottom":
            return 225;
        case "fast-v-bottom":
            return 250;
        case "catamaran":
            return 275;
        case "fast-catamaran":
            return 300;     
        default:
            alert("Please select a Hull Type.")
    }
}

function resetInputs() {
    document.getElementById("boat-weight").value = "";
    document.getElementById("horsepower").value = "";
    document.getElementById("result-speed").textContent = "0";
}

//calculator button event listener
const calculateButton = document.getElementById("calculate-button");
calculateButton.addEventListener("click", calcMaxBoatSpeed);

//reset button event listener
const resetButton = document.getElementById("reset-input-button");
resetButton.addEventListener("click", resetInputs);
