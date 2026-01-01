const sendPostRequest = async (urlRequest, data) => {
  const splitedUrl = urlRequest.split("/");
  const directory = splitedUrl[1];
  const file = splitedUrl[2].split(".")[0];

  try {
    const response = await axios.post(urlRequest, data);
    if (response.status >= 200 && response.status <= 299) {
      const responseData = await response.data;
      if (directory === "auth") {
        if (file === "register") {
          window.location.href = "index.php?page=login";
        } else {
          responseData.role_id === 1
            ? (window.location.href = "admin.php")
            : (window.location.href = "index.php");
        }
      } else {
        if (action === "delete") {
          replaceAfterSoftDelete(directory, responseData);
        } else if (action === "store" || action === "update") {
          createResponseMessage("success", responseData.message);
          clearFormData(directory);
        } else if (action === "promotion") {
          replaceAfterPromotion(directory, responseData);
        }
      }
    }
  } catch (error) {
    createResponseMessage("danger", error.response?.data.message);
  }
};

// kreriati get request (proveriti - testirati)
const sendGetRequest = async (url, params = "") => {
  const splitedUrl = url.split("/");
  const action = splitedUrl[splitedUrl.length - 1]
  const directory = splitedUrl[splitedUrl.length - 2]

  try {
    const request = await axios.get(`url?${params}`);
    if (request.status >= 200 || request.status <= 299) {
      if(action === 'edit'){

      }
    }
  } catch (error) {
    createResponseMessage('danger', error)
    console.log(error);
  }
};

const createResponseMessage = (color, message) => {
  const res = `
    <div class="alert alert-${color} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>`;
  document.querySelector("#message").innerHTML = res;
};
