function isEmpty(value) {
  return value.value.trim() !== "";
}

function isEmail(value) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return !regex.test(value);
}

$("button").click(() => {
  let useremail = $("input[type=email]").val();
  let password = $("input[type=password]").val();
  console.log(useremail, password);

  if (useremail !== "" && password !== "") {
    $.post("../includes/login.inc.php", { useremail: useremail, password: password }, (data, status) => {
      console.log(data);
      alert(status);
    });
  } else {
    alert("Không hợp lệ!");
  }
});
