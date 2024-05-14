$(document).ready(function () {
  //   Get date from server
  async function fetchData(url) {
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = response.json();
      return data;
    } catch (error) {
      console.log("Fetch data error:", error);
      return null; // Return null in case of an error
    }
  }

  //   Darw line chart
  function drawChart(haxis, vaxis, chartElement, chartType) {
    const ctx = $(chartElement)[0].getContext("2d");

    const myChart = new Chart(ctx, {
      type: chartType, // kind of chart
      data: {
        labels: haxis, // horizontal axis
        datasets: [
          {
            label: "Revenue", // Note
            backgroundColor: "transparent",
            borderColor: "rgb(47, 128, 237)",
            pointBorderWidth: 3,
            pointRadius: 8,
            data: vaxis, // vertical axis
          },
        ],
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    });
  }

  function activeRevenueBtns(type) {
    const monthlyBtn = $("#monthly");
    const anuallyBtn = $("#anually");

    monthlyBtn.removeClass("btn--active");
    anuallyBtn.removeClass("btn--active");

    if (type === "monthly") {
      monthlyBtn.addClass("btn--active");
    } else {
      anuallyBtn.addClass("btn--active");
    }
  }

  // Render best seller
  function renderBestSeller() {
    fetchData("../server/models/bestseller.s.php").then((data) => {
      const dataTable = data
        .map((curData) => {
          return `<tr>
                    <td>${curData.product_id}</td>
                    <td>${curData.title}</td>
                    <td>${curData.sold_amount}</td>
                  </tr>`;
        })
        .join("");

      $(".sold-amount-tbody").html(dataTable);
    });
  }

  // Handle events
  function handleClickRevenue(url, type, chartElement, chartType) {
    fetchData(url).then((data) => {
      const haxis = [];
      const vaxis = [];

      data.forEach((item) => {
        if (!item || typeof item !== "object") {
          console.error("Invalid item in data:", item);
          return;
        }

        haxis.push(item.order_date);
        vaxis.push(item.revenue);
      });

      drawChart(haxis, vaxis, chartElement, chartType);
      activeRevenueBtns(type);
    });
  }

  // Common click handler for both monthly and yearly buttons
  function handleRevenueButtonClick(revenueURL, importURL, type) {
    handleClickRevenue(revenueURL, type, "#export-chart", "line");
    handleClickRevenue(importURL, type, "#import-chart", "line");
  }

  // Click events
  $("#monthly").click(() => {
    handleRevenueButtonClick("../server/models/revenuemonth.s.php", "../server/models/importmonth.s.php", "monthly");
  });

  $("#anually").click(() => {
    handleRevenueButtonClick("../server/models/revenueyear.s.php", "../server/models/importyear.s.php", "yearly");
  });

  // Initial fetch and rendering
  handleRevenueButtonClick("../server/models/revenuemonth.s.php", "../server/models/importmonth.s.php", "monthly");
  handleRevenueButtonClick("../server/models/revenueyear.s.php", "../server/models/importyear.s.php", "yearly");

  // Render best seller
  renderBestSeller();
});
