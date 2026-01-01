const collectDataFromReg = (authObj) =>{
   authObj['first_name'] = document.querySelector('#first_name').value
   authObj['last_name'] = document.querySelector('#last_name').value
   authObj['email'] = document.querySelector('#email').value
   authObj['password'] = document.querySelector('#password').value
   
   console.log(authObj)
   return authObj
}

const transformDataIntoObjReg = (authObj) => {
   const {authDataObj, authFormData} = authObj

   authFormData.set("first_name", authDataObj['first_name']) 
   authFormData.set('last_name',authDataObj['last_name'])
   authFormData.set('email',authDataObj['email'])
   authFormData.set("password",authDataObj['password'])

   return authFormData
}

const collectDataFromLogIn = (authObj) => {
   authObj['email'] = document.querySelector('#email').value
   authObj['password'] = document.querySelector('#password').value

   return authObj
}

const transfomrDataIntoObjLog = (authObj) => {
   const {authDataObj, authFormData} = authObj
   authFormData.set('email',authDataObj['email'])
   authFormData.set("password",authDataObj['password'])

   return authFormData
}