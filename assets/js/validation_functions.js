const utilityClasses = ["text-danger"];

// validation functions
const inputFieldValidation = (inputEl, regexInput, errorArray, errorElement, errorMessage) => {
    if(!regexInput.test(inputEl)){
        errorArray.push(errorMessage)
        createValidationMessage(errorElement, errorMessage)
    }else{
        removeValidationMessage(errorElement)
    }
}

const checkBoxValidation = (inputArray, errorArray, errorElement, errorMessage) => {
    if(inputArray.length === 0 ){
        errorArray.push(errorMessage)
        createValidationMessage(errorElement, errorMessage)
    }else{
        removeValidationMessage(errorElement)
    }
}

const inputFileValidation = (inputFile, errorArray, errorElement, [emptyError, invlaidType, invalidSize]) => {
    if(inputFile.length ===  0 ){
        errorArray.push(errorElement)
        createValidationMessage(errorElement, emptyError)
    }else{
        const image_type = inputFile['type']
        const image_size = inputFile['size']

        const invalidTypes = ['image/png','image/jpeg','image/jpg'];
        if(!invalidTypes.includes(image_type)){
            errorArray.push(errorArray, invlaidType)
        }
        if(image_size > 3 * 1024 * 1024){
            errorArray.push(invalidSize)
        }
    }
}

const inputFieldValidationSpecial = (inputElArray, regInput, errorArray, errorElement, errorMessage) => {
    const arrayOfIn = [];
    inputElArray.forEach((index, inputEl) => {
        if(!regInput.test(inputEl)){
            arrayOfIn.push(index)
        }else{
            arrayOfIn.pop(index)
        }
    })

    if(arrayOfIn.length > 0){
        const message = `${errorMessage} ${arrayOfIn.join(', ')}!`
        errorArray.push(message)
        createValidationMessage(errorElement, message)
    }else{
        removeValidationMessage(errorElement)
    }
}

// proveriti kako se radi sa timestampom
const inputDateValidation = (dateInput, errorArray, errorElement, [emptyError, invalidDate]) => {
    if(dateInput === ""){
        errorArray.push(emptyError)
        createValidationMessage(errorElement, emptyError)
    }else{
        // const myTimeStamp = 
        const currentDate = new Date();
        const currentTimeStamp = currentDate.toLocaleDateString().getTime();
        if(currentDate < dateInput) {
            errorArray.push(invalidDate)
            createValidationMessage(errorElement, invalidDate)
        }else{
            removeValidationMessage(errorElement)
        }
    }
}

// validation message

const createValidationMessage = (errorElementId, errorMesasge) => {
    const element = document.querySelector(`#${errorElementId}`)
    element.classList.add(...utilityClasses)
    element.textContent = errorMesasge
}

const removeValidationMessage = (errorElementId) => {
    const element = document.querySelector(`#${errorElementId}`)
    element.classList.remove(...utilityClasses)
    element.textContent = ''
}