document.querySelectorAll(".stars").forEach((starsWrapper) => {
    starsWrapper.addEventListener("click", (event) => {
      if (event.target.tagName === "LABEL") {
        const starIndex = Array.from(starsWrapper.children).indexOf(event.target);
        const input = starsWrapper.previousElementSibling;
        input.value = 5 - starIndex;
      }
    });
  });
  

  function createStudentScoresChart(labels, category1Data, category2Data, category3Data, category4Data) {
    const ctx = document.getElementById('studentScoresChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Category 1',
            data: category1Data,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 2',
            data: category2Data,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 3',
            data: category3Data,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          },
          {
            label: 'Category 4',
            data: category4Data,
            backgroundColor: 'rgba(153, 102, 255, 0.2)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
  