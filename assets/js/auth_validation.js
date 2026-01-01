const registerFormValidation = ({ first_name, last_name, email, password }) => {
  const errors = [];

  const regFirstLastName = /\b([A-ZÀ-ÿ][-,a-z. ']+[ ]*)+/;
  const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  const regPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

  inputFieldValidation(first_name, regFirstLastName, errors, "first_name_error", "Ime nije u redu");
  inputFieldValidation(last_name, regFirstLastName, errors, "last_name_error", "Prezime nije u redu");
  inputFieldValidation(email, regEmail, errors, "email_error", "Email nije u redu!")
  inputFieldValidation(password, regPassword, errors, "password_error", "Lozinka nije u redu!");

  return errors;
};


const loginFormValidation  = ({email, password}) => {
  const regEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  const regPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

  const errors = [];

  inputFieldValidation(email, regEmail, errors, "email_error", "Email nije u redu!")
  inputFieldValidation(password, regPassword, errors, "password_error", "Lozinka nije u redu!");

  return errors;
}