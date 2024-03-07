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

export function isCorrectVerifyPassword(password, verify_password) {
  return verify_password === password;
}

export function isPhoneNumber(phone_number) {
  return /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/.test(phone_number);
}
