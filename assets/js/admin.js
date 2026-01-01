const adminObj = {
  adminObjData: {},
  adminFormData: new FormData(),
};

const events = document.querySelector("#events");
document.contains(events)
  ? events.addEventListener("click", (event) => {
      if (event.target.type === "button") {
        const element = event.target;
        const lastClass = element.classList[element.classList.length - 1].split('-');

        const directory = lastClass[lastClass.length - 1]
        let action = lastClass[lastClass.length - 2]


        if (element.classList.contains("btn-edit")) {
           const transformedData = transformDataIntoObj(element, adminObj.adminFormData)
        } else if (element.classList.contains("btn-delete")) {
           const transformedData = transformDataIntoObj(element, adminObj.adminFormData)
           sendPostRequest(`models/${directory}/${action}.php`, transformedData)
        } else if (element.classList.contains("btn-save")) {
           const element_index = document.querySelector(`#${directory}_index`).value
           action = element_index === "" ? "store" : "update"
           collectDataFromForm(directory, adminObj)
           dataFormValidation(directory, adminObj.adminObjData).length ===  0 ? 
                sendPostRequest(`models/${directory}/${action}.php`, adminObj.adminFormData) 
                : ''
        } else if (element.classList.contains("btn-reset")) {
          console.log("reset");
        }else if(element.classList.contains('btn-promotion')){
          const transformData = transformDataIntoObj(element, adminObj.adminFormData)
          sendPostRequest(`models/${directory}/${action}.php`, transformData)
        }
      }
    })
  : "";
