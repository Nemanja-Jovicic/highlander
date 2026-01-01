const contactFormValidation = ({first_name, last_name, email, message}) => {
    let errors = [];
    let regFirstLastName = ''
    let regEmail = ''
    let regMessage  =''


    inputFieldValidation(first_name, regFirstLastName, errors, "first_name_error", "Ime nije u redu!")
    inputFieldValidation(last_name, regFirstLastName, errors, "last_name_error", "Prezime nije u redu!")
    inputFieldValidation(email, regEmail, errors, "email_error", "Email nije u redu!")
    inputFieldValidation(message, regMessage, errors, "message_error", "Poruka nije u redu!")

    return errors;
}