export function isEmpty(checkElement, errorElement) {
  // Refresh the content
  $(errorElement).text("");
  if (checkElement === "" || checkElement === null) {
    $(errorElement).text("Vui lòng điền đầy đủ thông tin");
    return false;
  }
  return true;
}

export function isEmail(email, errorElement) {
  // Refresh the content
  $(errorElement).text("");
  const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+[.][A-Za-z]{2,4}$/;
  if (!emailRegex.test(email)) {
    $(errorElement).text("Email không đúng định dạng");
    return false;
  }
  return true;
}

export function isCorrectVerifyPassword(password, verify_password, errorElement) {
  $(errorElement).text("");
  if (verify_password !== password) {
    $(errorElement).text("Mật khẩu khác nhận không đúng");
    return false;
  }
  return true;
}

export function isPhoneNumber(phone_number, errorElement) {
  $(errorElement).text("");
  const regex = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
  if (!regex.test(phone_number)) {
    $(errorElement).text("Số điện thoại không hợp lệ");
    return false;
  }

  return true;
}

export function isNumber(number, errorElement) {
  $(errorElement).text("");
  const regex = /^\d+$/;
  if (!regex.test(number)) {
    $(errorElement).text("Không đúng định dạng số");
    return false;
  }
  return true;
}

export function isExceedDefault(number, defaultNumber, errorElement) {
  $(errorElement).text("");
  if (number < 0) {
    $(errorElement).text("Số tiền không hợp lệ");
    return false;
  }
  if (number > defaultNumber) {
    $(errorElement).text(`Số tiền không được vượt quá ${defaultNumber}`);
    return false;
  }
  return true;
}

// Query the value of an url
export function queryValue(value) {
  const query_string = window.location.search;
  const url_params = new URLSearchParams(query_string);
  return url_params.get(value);
}
