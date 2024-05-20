import { isEmpty, isCorrectVerifyPassword } from "./config.js";

$(document).ready(function () {
  // Handle events
  const btnGroup = $(".btns-group > .btn");
  const customerinfoContent = $(".customerinfo-content > div");

  // Format vnd currency
  function formatVndPrice(price) {
    return price.toLocaleString("it-IT", { style: "currency", currency: "VND" });
  }

  btnGroup.each(function () {
    $(this)
      .unbind("click")
      .click(() => {
        // Side effects
        btnGroup.removeClass("active");
        $(this).addClass("active");

        const elementOfLink = $(`.${Object.keys($(this).data())[0]}`);
        // Refresh
        customerinfoContent.removeClass("d-block").addClass("d-none");
        // Show the current page
        elementOfLink.removeClass("d-none").addClass("d-block");
      });
  });

  function isValidChangePwd() {
    const changePwdForm = $(".customerinfo__changepwd > .form-group");
    let isValid = true;

    if (changePwdForm) {
      changePwdForm.each(function () {
        const inputField = $(this).find("input");
        const error = $(this).find(".error-message");

        if (inputField.length && !isEmpty(inputField.val(), error)) {
          isValid = false;
        }

        inputField.on("input", () => error.text(""));
      });
    }

    return isValid;
  }

  function handleResetPwd() {
    let isValid = isValidChangePwd();
    let correctPwd = true;

    const oldPwd = $("#oldpwd");
    const oldPwdError = oldPwd.closest(".form-group").find(".error-message");
    const newPwd = $("#newpwd");
    const verifypwd = $("#verifypwd");
    const verifypwdError = verifypwd.closest(".form-group").find(".error-message");

    if (isValid) {
      if (!isCorrectVerifyPassword(newPwd.val(), verifypwd.val(), verifypwdError)) {
        correctPwd = false;
      }
    }

    if (isValid && correctPwd) {
      $.ajax({
        type: "post",
        url: "../includes/changepwd.inc.php",
        data: { oldPwd: oldPwd.val(), newPwd: newPwd.val(), type: "changepwd" },
        success: function (response) {
          if (response) {
            alert("Đổi mật khẩu thành công");
            window.location.reload();
          } else {
            oldPwdError.text("Mật khẩu cũ không đúng");
          }
        },
      });
    }
  }

  $(".resetpwd-btn").unbind("click").click(handleResetPwd);

  function handleSeeOrderDetails(value) {
    $.ajax({
      type: "GET",
      url: "../includes/customerorderdetails.inc.php",
      data: { orderid: value.orderid, type: "getCustomerOrderDetails" },
      success: function (response) {
        const customerinfoContent = $(".customerinfo-content > div");
        const orderDetails = $(".customerinfo_orderdetails");
        const data = JSON.parse(response);
        console.log(data);

        // Refresh
        customerinfoContent.removeClass("d-block").addClass("d-none");
        // Show the current page
        orderDetails.removeClass("d-none").addClass("d-block");

        let html = `
        <div class="d-flex align-items-center justify-content-between">
          <h5>Chi tiết đơn hàng #${value.customerorderid}</h5>
          <p>Ngày tạo: ${value.orderdate}</p>
        </div>
        <div>
          <span class="me-5" style="font-size:14px">Trạng thái thanh toán: <i style="font-weight: 600; font-size: 16px; color:red">Chưa thanh toán</i></span>
          <span style="font-size:14px">Trạng thái vận chuyển: <i style="font-weight: 600; font-size: 16px; color:red">${data[0].status == 1 ? "Đang vận chuyển" : "Đang xử lý"}</i></span>
        </div>
        <div class="container mt-4">
          <div class="row">
            <div class="col-lg-7 col-12 ps-0">
              <p class="m-0">ĐỊA CHỈ GIAO HÀNG</p>
              <div class="box">
                <p>${value.fullname}</p>
                <p>Địa chỉ: ${value.orderaddress}</p>
                <p>Số điện thoại: ${value.phonenumber}</p>
              </div>
            </div>
            <div class="col-lg-2 col-12">
              <p class="m-0">THANH TOÁN</p>
              <div class="box">
                <p>Thanh toán khi giao hàng (COD)</p>
              </div>
            </div>
            <div class="col-lg-3 col-12 pe-0">
              <p class="m-0">GHI CHÚ</p>
              <div class="box">
                <p>${value.note}</p>
              </div>
            </div>
          </div>
          <div class="row mt-4" style="padding: 14px; border-radius: 4px; border: 1px solid #ccc">
            <table class="table productlist-table my-0">
              <thead>
                <tr>
                  <th colspan="2">Sản phẩm</th>
                  <th class="text-center">Đơn giá</th>
                  <th class="text-center">Số lượng</th>
                  <th class="text-center">Tổng</th>
                </tr>
              </thead>
              <tbody class="productlist-tbody">
        `;

        html += data
          .map((order, index) => {
            return `
            <tr class="border-bottom">
            <td colspan="2">
              <img src="${order.thumbnail}" alt="" style="width: 90px">
              <span class="ms-2">${order.title}</span>
            </td>
            <td class="text-center" style="vertical-align:middle;">
              <p class="m-0">${formatVndPrice(Number(order.orderdetail_price))}</p>
            </td>
            <td class="text-center" style="vertical-align:middle;">
              <p class="m-0">${order.num}</p>
            </td>
            <td class="text-center" style="vertical-align:middle;">
              <p class="m-0">${formatVndPrice(Number(order.total_money))}</p>
            </td>
          </tr>
            `;
          })
          .join("");

        html += `
                <tr>
                  <td>
                    <span>Khuyến mại</span>
                  </td>
                  <td>
                    <span>0</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Phí vận chuyển</span>
                  </td>
                  <td>
                    <span>40.000 VND(Giao hàng tận nơi)</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Tổng tiền</span>
                  </td>
                  <td>${formatVndPrice(Number(value.ordertotal))}</td>
                </tr>
              </tbody>
            </table>
          </div>
				</div>
        `;

        orderDetails.html(html);
      },
    });
  }

  // Render customer's orders
  async function handleRenderOrders() {
    const tbody = $(".customerinfo__orders-tbody");
    if (tbody) {
      const orders = await fetchData("../includes/customerorders.inc.php");

      const ordersMap = orders
        .map((value, index) => {
          return `
            <tr>
              <td class="text-center order-row" 
                data-orderid="${value.id}" 
                data-orderdate="${value.order_date}" 
                data-orderaddress="${value.address}" 
                data-ordertotal="${value.total_money}" 
                data-orderstatus="${value.status}"
                data-phonenumber="${value.phone_number}"
                data-email="${value.email}"
                data-note="${value.note}"
                data-fullname="${value.fullname}"
                data-customerorderid="${index}"
                style="cursor:pointer; color:#7fcbc9!important"
              >
                #${index}
              </td>
              <td class="text-center">${value.order_date}</td>
              <td class="text-center">${value.address}</td>
              <td class="text-center">${formatVndPrice(Number(value.total_money))}</td>
              <td class="text-center">${value.status == 1 ? "Đang vận chuyển" : "Đang xử lý"}</td>
            </tr>
          `;
        })
        .join("");

      tbody.html(ordersMap);

      // Click to see order details
      $(".order-row")
        .unbind("click")
        .click(function () {
          const orderid = $(this).data("orderid");
          const orderdate = $(this).data("orderdate");
          const orderaddress = $(this).data("orderaddress");
          const ordertotal = $(this).data("ordertotal");
          const orderstatus = $(this).data("orderstatus");
          const phonenumber = $(this).data("phonenumber");
          const note = $(this).data("note");
          const fullname = $(this).data("fullname");
          const customerorderid = $(this).data("customerorderid");

          const value = { orderid, orderdate, orderaddress, ordertotal, orderstatus, phonenumber, note, fullname, customerorderid };

          handleSeeOrderDetails(value);
        });
    }
  }
  handleRenderOrders();

  async function fetchData(url) {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const dataJson = await response.json();
    console.log(dataJson);
    return dataJson;
  }
});
