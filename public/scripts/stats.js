var labels = [];
var data = [];

pageData.forEach(function (record) {
    var date = Object.keys(record)[0];
    var weight = record[date];

    labels.push(date);
    data.push(weight);
});


var minYValue = Math.min(...data);

var ctx = document.querySelector('#chart').getContext('2d');
var weightChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Weight Loss',
            data: data,
            borderColor: 'red',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        scales: {
            x: {
                type: 'category',
                labels: labels
            },
            y: {
                beginAtZero: false,  // Start y-axis from the minimum value
                suggestedMin: minYValue,  // Set the suggested minimum value
            }
        }
    },
    plugins: {
        legend: {
            display: true,
            position: 'top'
        }
    }
});