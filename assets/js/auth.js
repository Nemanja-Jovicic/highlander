const authObj = {
  authDataObj: {},
  authFormData: new FormData(),
};
const registerButton = document.querySelector("#btnRegister");
const loginButton = document.querySelector('#btnLogin')

document.contains(registerButton)
  ? registerButton.addEventListener("click", (e) => {
      
      registerFormValidation(collectDataFromReg(authObj.authDataObj)).length ===  0
        ? sendPostRequest("models/auth/register.php", transformDataIntoObjReg(authObj))
        : "";
      
    })
  : "";

  document.contains(loginButton) 
    ?loginButton.addEventListener('click', (e) => {
      loginFormValidation(collectDataFromLogIn(authObj.authDataObj)).length === 0 
      ? sendPostRequest("models/auth/login.php", transfomrDataIntoObjLog(authObj)) : "" 
    }) : ""
