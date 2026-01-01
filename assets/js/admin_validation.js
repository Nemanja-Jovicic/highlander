const dataFormValidation = (entity, dataObj) => {
    const errors = []
    switch(entity) {
        case 'category':
            categoryFormValidation(errors, dataObj);
            break;
        case 'tour':
            tourFormValidation(errors, dataObj);
            break;
        case 'date':
            dateFormValidation(errors, dataObj);
            break;
    }
    return errors
}

const categoryFormValidation = (errorArray, {category_name}) => {

    const regCategoryName = /^[A-Z][a-z]{2,10}$/;
    inputFieldValidation(category_name, regCategoryName, errorArray, "category_name_error", "Naziv kategorije nije u redu!");

    return errorArray
    
}
const tourFormValidation = (errorArray, {tour_name, tour_price, tour_duration, tour_categories, tour_descrption, tour_banner, tour_tags}) => {
    
    const regTourName = /^$/ // regex za naziv ture
    const regTourPrice = /^$/ // regex za cenu
    const regTourDuration = /^$/ // regex za trajanje izleta


    // dodati validaciju za quill

    inputFieldValidation(tour_name, regTourName, errorArray, "tour_name_error", "Naziv ture nije u redu!");
    inputFieldValidation(tour_price, regTourPrice, errorArray, "tour_price_error", "Cena nije u redu!")
    inputFieldValidation(tour_duration, regTourDuration, errorArray, "tour_duration_error", "Broj dana nije validan")

    checkBoxValidation(tour_categories, errorArray, "tour_category_error", "Morate odabrati barem jednu kategoriju!")
    inputFileValidation(tour_banner,errorArray, "tour_banner_error", ['Morate odabrati sliku!', 'Tip slike nije u redu!','Velicina slike nije u redu!'])

    inputFieldValidationSpecial(tour_tags.split(','), regTourTag, errors, "tour_tag_error" , "Tagovi nisu ispravni")

    return errorArray;
}
const dateFormValidation = (errorArray, {tour_date}) => {
    
    inputDateValidation(tour_date, errorArray, "tour_date_id", ["Morate odabrati datum!", "Datum nije validan"])

    return errorArray
}