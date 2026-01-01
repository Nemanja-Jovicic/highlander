// prepering data for edit and delete operation

const transformDataIntoObj = (element, adminDataForm) => {
  adminDataForm.set("id", element.dataset.id);
  adminDataForm.set("index", element.dataset.index);
  element.hasAttribute("data-status")
    ? adminDataForm.set("status", element.dataset.status)
    : "";
  element.hasAttribute("data-promotion")
    ? adminDataForm.set("promotion", element.dataset.promotion)
    : "";
};

// replacing

const replaceAfterSoftDelete = (entity, { id, is_deleted }) => {
  const row = document.querySelector(`#${entity}_${id - 1}`);
  const button = row.querySelector("td:last-child button");
  button.dataset.status = is_deleted;
  button.textContent = parseInt(is_deleted) === 0 ? "Izbrisi" : "Aktiviraj";
};

const replaceAfterPromotion = (entity, { id, is_promoted }) => {
  const row = document.querySelector(`#${entity}_${id - 1}`);
  const button = row.querySelector("td:last-child button");
  button.dataset.promotion = is_promoted;
  button.textContent =
    parseInt(is_promoted) === 0 ? "Aktiviraj" : "Deaktiviraj";
};

// functions for collecting and transfering data into working objects

const collectDataFromForm = (entity, { adminObjData, adminFormData }) => {
  switch (entity) {
    case "category":
      collectCategoryFormData(adminObjData);
      transformCategoryFormData(adminObjData, adminFormData);
      break;
    case "tour":
      collectTourFormData(adminObjData);
      transformTourFormData(adminObjData, adminFormData);
      break;
    case 'date':
      collectDateFormData(adminObjData);
      transformDateFormData(adminObjData, adminFormData);
      break;
  }
};
const collectCategoryFormData = (adminObj) => {
  document.querySelector("#category_id").value !== ""
    ? (adminObj["category_id"] = document.querySelector("#category_id").value)
    : "";
  document.querySelector("#category_index").value !== ""
    ? (adminObj["category_id"] =
        document.querySelector("#category_index").value)
    : "";
  adminObj["category_name"] = document.querySelector("#category_name").value;
};
const transformCategoryFormData = (adminObj, adminDataForm) => {
  adminObj.hasOwnProperty("category_id")
    ? adminDataForm.set("id", adminObj["category_id"])
    : "";
  adminObj.hasOwnProperty("category_index")
    ? adminDataForm.set("index", adminObj["category_index"])
    : "";
  adminDataForm.set("category_name", adminObj["category_name"]);
};
const collectTourFormData = (adminObj) => {
  document.querySelector("#tour_id").value !== ""
    ? (adminObj["id"] = document.querySelector("#tour_id").value)
    : "";
  document.querySelector("#tour_index").value !== ""
    ? (adminObj["index"] = document.querySelector("#tour_index").value)
    : "";
  adminObj["tour_name"] = document.querySelector("#tour_name").value;
  adminObj["tour_price"] = document.querySelector("#tour_price").value;
  adminObj["tour_duration"] = document.querySelector("#tour_duration").value;
  const tourCategory = [];
  const categories = document.querySelectorAll(
    'input[name="tour_categories"]:checked'
  );
  categories.forEach((category) => tourCategory.push(category.value));
  adminObj["tour_categories"] = tourCategory;
  adminObj["tour_description"] = ""; // quill editors
  if (document.querySelector("#tour_id").value === "") {
    adminObj["tour_banner"] = document.querySelector("#tour_banner");
  } else if (document.querySelector("#tour_banner").length > 0) {
    adminObj["tour_banner"] = document.querySelector("#tour_banner");
  } // proveriti da li postoji, jer moze da se ne prosledi
  adminObj["tour_tags"] = document.querySelector("#tour_tags").value;
};
const transformTourFormData = (adminObj, adminFormData) => {
  adminObj.hasOwnProperty("#tour_id")
    ? adminFormData.set("id", adminObj["tour_id"])
    : "";
  adminObj.hasOwnProperty("#tour_index")
    ? adminFormData.set("index", adminObj["tour_index"])
    : "";
  adminFormData.set('tour_name', adminObj['tour_name']); 
  adminFormData.set('tour_description' , adminObj['tour_description']) // quill editor
  adminFormData.set('tour_price' ,adminObj['tour_price'])
  adminFormData.set('tour_duration', adminObj['tour_duration'])
  adminFormData.set('categories[]', adminObj['tour_categories'])
  adminFormData.set('banner', adminObj['banner'].files[0])
  adminFormData.set('tour_tags', adminObj['tour_tags'])
};
const collectDateFormData = (adminObj) => {
  adminObj['tour_id'] = document.querySelector('#tour_id').value
  document.querySelector('#date_id').value !== '' ? 
    adminObj['date_id'] = document.querySelectory('#date_id').value
    : ''
  document.querySelectory('#date_index').value !== '' ? 
    adminObj['date_index'] = document.querySelector('#date_index').value
    : ''
  adminObj['tour_date'] = document.querySelector('#tour_date').value
}
const transformDateFormData = (adminObj, adminFormData) => {
  adminDataForm.set('tour_id', adminObj['tour_id'])
  adminObj.hasOwnProperty('date_id') ? adminFormData.set('date_id', adminObj['date_id']) : '';
  adminObj.hasOwnProperty('date_index') ? adminFormData.set('date_index', adminObj['date_index']) : '';

  adminFormData.set('tour_date', adminObj['tour_date'])
  
}
// clear form from data

const clearFormData = (entity) => {
  switch (entity) {
    case "category":
      clearCategoryData();
      break;
    case 'tour':
      clearTourData()
      break;
    case 'date':
      clearDateData()
      break;
  }
};

const clearCategoryData = () => {
  document.querySelector("#category_index").value = "";
  document.querySelector("#category_id").value = "";
  document.querySelector("#name").value = "";
};
const clearTourData = () => {
  document.querySelector('#tour_id').value  =''
  document.querySelector('#tour_index').value =''
  document.querySelector('#tour_name').value = ''
  // set quill da bude '' -> opis ture
  document.querySelector("#tour_price").value = ""
  document.querySelector('#tour_duration').value = ''
  document.querySelectorAll('input[name="category_tags"]:checked').forEach(tag => {
    tag.checked = false
  })
  document.querySelector('#tour_banner').value = ''
}
const clearDateData = () => {
 document.querySelector('#date_id').value = ''
 document.querySelector('#tour_index').value = '' 
 document.querySelector('#tour_date').value = ''
}