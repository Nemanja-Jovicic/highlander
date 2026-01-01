const userObj = {
    userObjData : {},
    userObjFormData : new FormData()
}

const btnContactUs = document.querySelector('#btnContactUs')
document.contains(btnContactUs) 
    ? addEventListener('click', (e) => {
        e.preventDefault()
        transformUserData('contact', userObj)
        contactFormValidation(userObj.userObjData).length === 0 
            ? sendPostRequest("models/contact/store.php", userObj.userObjFormData)
            : ""
    })
    :'' 