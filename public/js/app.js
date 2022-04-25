/**
 * Variables that are necessary for the correct functioning of the dynamic form.
 */
const petInfoForm = document.getElementById("pet-info-form");
const totalSteps = document.getElementsByClassName("kc-step").length;
const continueBtn = document.getElementById("step-continue");
const sendBtn = document.getElementById("send-data");
const goBackBtn = document.getElementById("go-back");
let InputPupName = document.getElementById("pup-name");
let pupName = InputPupName.value;

/**
 * Description: Event listener (Click) that validates step 8 and if it is correct sends the form.
 */
sendBtn.addEventListener('click', function(e){
    e.preventDefault();
    //if(validateFieldsByStep('8')){
        petInfoForm.submit();
    //}
});

/**
 * Description: Event listener (Click) for the continue button.
 */
continueBtn.addEventListener('click', function () {
    continueToNextStep();
});

/**
 * Description: Event listener (Click) for the Previous step button.
 */
goBackBtn.addEventListener('click', function () {
    goBack();
});

/**
 * Description: Event that is thrown when entering the name of the pet,
 * updates all pet name labels of the following questions.
 */
InputPupName.addEventListener('change', (event) => {
    let pupNameLabels = document.querySelectorAll(".pup-label");
    pupName = event.target.value;

    if(pupNameLabels.length){
        pupNameLabels.forEach(function(element) {
            element.textContent = pupName;
        });
    }
});

/**
 * Description: Event that is thrown when a question option is clicked,
 * it takes the chosen value and sets it as the value of the hidden input.
 */
document.querySelectorAll('.btn-option').forEach((item) => {
    item.addEventListener('click', (event) => {
        event.preventDefault();
        let value = item.getAttribute("data-value");
        let inputName = item.getAttribute("data-input");
        let input = document.getElementsByName(inputName)[0];
        let options = document.querySelectorAll('[data-input="'+inputName+'"]');

        options.forEach(function(option) {
            option.classList.remove("active");
        });

        item.classList.add("active");
        input.value = value;
        input.dispatchEvent(new Event('change'));
    });
});

/**
 * Description: Event that is thrown when an option of a multiple question (Allergies) is clicked, it takes the chosen values,
 * converts them into a single string separated by commas and places them as the value of the hidden input.
 */
document.querySelectorAll('.btn-multiple-option').forEach((item) => {
    item.addEventListener('click', (event) => {
        event.preventDefault();
        //let value = item.getAttribute("data-value");
        let inputName = item.getAttribute("data-input");
        let input = document.getElementsByName(inputName)[0];
        let options = document.querySelectorAll('[data-input="allergies"]');
        let activeOptions = [];

        if (item.classList.contains("active")) {
            item.classList.remove("active");
        } else {
            item.classList.add("active");
        }

        input.value = "";
        options.forEach(function (option) {
            if (option.classList.contains("active")) {
                let value = option.getAttribute("data-value");
                activeOptions.push(value);
            }
        });

        input.value = activeOptions.join(",");
        console.log(input.value);
    });
});

/**
 * Description:  Event that is thrown when an option of a question is chosen
 * and it needs another one to be answered, so it shows that question.
 */
document.querySelectorAll('.show-ask-if').forEach((item) => {
    item.addEventListener('change', (event) => {
        console.log("Change active");
        event.preventDefault();
        let valueToShow = item.getAttribute("data-if-is");
        let nextQuestion = item.getAttribute("data-next-question");
        let hasOtherResponse = item.hasAttribute("data-other-response");
        let otherQuestion = false;

        if(hasOtherResponse){
            otherQuestion = item.getAttribute("data-other-response");
        }


        if(event.target.value == valueToShow){
            document.getElementById(nextQuestion).classList.remove("d-none");
            if(hasOtherResponse) document.getElementById(otherQuestion).classList.add("d-none");
        }else{
            document.getElementById(nextQuestion).classList.add("d-none");

            if(hasOtherResponse){
                document.getElementById(otherQuestion).classList.remove("d-none");
            }
        }
    });
});

/**
 * Description:  Function to show the image that is selected for the pet.
 */
function loadFile(event) {
    var output = document.getElementById('image-output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
    }
}

/**
 * Description: Function that validates the questions of a given step,
 * before continuing to the next step.
 */
function continueToNextStep(){
    let currentSectionLabel = continueBtn.getAttribute("data-section");
    let currentSectionContainer = document.querySelectorAll('[data-section="'+currentSectionLabel+'"]');
    currentSectionContainer = currentSectionContainer[0];

    let currentStep = continueBtn.getAttribute("data-step");
    let sectionSteps = currentSectionContainer.querySelectorAll('[data-step]');

    if(validateFieldsByStep(currentStep) && (currentStep < totalSteps)){
        let nextStep = parseInt(currentStep)+1;
        let containerNextStep = document.querySelectorAll('[data-step="'+nextStep+'"]');
        let stepLabel = document.getElementById("current-step").firstChild;

        sectionSteps.forEach(element => element.classList.add("d-none"));
        containerNextStep[0].classList.remove("d-none");

        goBackBtn.classList.remove("d-none");
        continueBtn.setAttribute("data-step", nextStep);
        stepLabel.nodeValue = nextStep;

        if(nextStep == 8){
            continueBtn.style.display = 'none';
            sendBtn.style.display = 'block';
        }
    }
}

/**
 * Description:  Function to return to the previous step.
 */
function goBack(){
    let currentSectionLabel = continueBtn.getAttribute("data-section");
    let currentSectionContainer = document.querySelectorAll('[data-section="'+currentSectionLabel+'"]');
    currentSectionContainer = currentSectionContainer[0];

    let currentStep = continueBtn.getAttribute("data-step");
    let sectionSteps = currentSectionContainer.querySelectorAll('[data-step]');

    if(currentStep > 1) { //Crear función que compruebe si los inputs del step están correctos.
        let prevStep = parseInt(currentStep)-1;
        let containerPrevStep = document.querySelectorAll('[data-step="'+prevStep+'"]');
        let stepLabel = document.getElementById("current-step").firstChild;

        sectionSteps.forEach(element => element.classList.add("d-none"));
        containerPrevStep[0].classList.remove("d-none");

        continueBtn.setAttribute("data-step", prevStep);
        stepLabel.nodeValue = prevStep;

        if(prevStep == 1) goBackBtn.classList.add("d-none");

        if(prevStep <= 7){
            continueBtn.style.display = 'block';
            sendBtn.style.display = 'none';
        }
    }
}

/**
 * Description:  Function that validates the required questions of a step.
 */
function validateFieldsByStep(step){
    let result = true;

    switch (step) {
        case("1"):
            let
                email = document.getElementsByName("email")[0];
                pupName = document.getElementsByName("pup-name")[0];

            result = checkRequiredInputWithErrorDisplay(email);
            result = checkRequiredInputWithErrorDisplay(pupName);

            return result;
            break;
        case '2':
            let gender = document.getElementsByName("pup-gender")[0];

            result = checkRequiredInputWithErrorDisplay(gender);

                if(gender.value == "girl"){
                    let spayed = document.getElementsByName("spayed")[0];
                    result = checkRequiredInputWithErrorDisplay(spayed);

                    if(spayed.value == "no"){
                        let pregnant = document.getElementsByName("pregnant")[0];
                        result = checkRequiredInputWithErrorDisplay(pregnant);
                    }

                }else if(gender.value == "boy"){
                    let neutered = document.getElementsByName("neutered")[0];
                    result = checkRequiredInputWithErrorDisplay(neutered);
                }

            break;
        case '3':
            let haveAllergies = document.getElementsByName("have-allergies")[0];
            result = checkRequiredInputWithErrorDisplay(haveAllergies);
            break;
        case '4':
            let breed = document.getElementsByName("breed")[0];
            result = checkRequiredInputWithErrorDisplay(breed);
            break;
        case '5':
            let birthdate = document.getElementsByName("birthdate")[0];
            result = checkRequiredInputWithErrorDisplay(birthdate);
            break;
        case '6':
            let weight = document.getElementsByName("weight")[0];
            result = checkRequiredInputWithErrorDisplay(weight);
            break;
        case '7':
            let lifestyle = document.getElementsByName("lifestyle")[0];
            result = checkRequiredInputWithErrorDisplay(lifestyle);
            break;
        case '8':
            let goal = document.getElementsByName("goal")[0];
            result = checkRequiredInputWithErrorDisplay(goal);
    }

    return result;
}

/**
 * Description: Function that validates a given field, and being empty shows the error on the screen.
 */
function checkRequiredInputWithErrorDisplay(element){
    let result = true;

    if(element.value.length == 0) {
        element.classList.add("error-field");
        element.nextElementSibling.classList.remove("d-none");
        result = false;
    }else{
        element.classList.remove("error-field");
        element.nextElementSibling.classList.add("d-none");
    }

    return result;
}

if(pupName.length) {
    var event = new Event('change');
    InputPupName.dispatchEvent(event);
}

