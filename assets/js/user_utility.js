const transformUserData = (entity, {userObj, userFormData}) => {
    switch(entity){
        case 'contact':
            collectUserData(userObj)
            transformInFormData(userObj, userFormData)
            break
    }
}

const collectUserData = (userObj) => {
    userObj['first_name'] = document.querySelector('#first_name').value
    userObj['last_name'] = document.querySelector('#last_name').value
    userObj['email'] = document.querySelector("#email").value
    userObj['message'] = document.querySelector('#message').value

    return userObj
}

const transformInFormData = (userObj, userFormData) => {
    userFormData.set('first_name', userObj['first_name'])
    userFormData.set('last_name', userObj['last_name'])
    userFormData.set('email', userObj['email'])
    userFormData.set('message', userObj['message'])
}