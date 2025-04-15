const getChartOptions = (data) => {
    return {
        series: [
            data.clubStudents, // Club Students
            data.allStudents, // All Students 
            data.nonClubStudents
        ], // Non Club Students
        colors: ["#1C64F2", "#16BDCA", "#9061F9"],
        chart: {
            height: 420,
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: ["white"],
            lineCap: "",
        },
        plotOptions: {
            pie: {
                labels: {
                    show: true,
                },
                size: "100%",
                dataLabels: {
                    offset: -25,
                },
            },
        },
        labels: [
            "Members", 
            "Non-Members", 
            "No Club"
        ],
        dataLabels: {
            enabled: true,
            formatter: function (value, { seriesIndex, w }) {
                const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(2);
                return `${percentage}%`; // Display percentage
            },
            style: {
                fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    console.log
                    return data.clubStudents + "%";
                },
            },
        },
        xaxis: {
            labels: {
                formatter: function (value) {
                    return value + "%";
                },
            },
            axisTicks: {
                show: false,
            },
            axisBorder: {
                show: false,
            },
        },
    };
};

if (document.getElementById("pie-chart") && typeof ApexCharts !== "undefined") {
    const chart = new ApexCharts(
        document.getElementById("pie-chart"),
        getChartOptions(chartData)
    );
    chart.render();
}
