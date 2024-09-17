<script>$(document).ready(function() {
    // Initialize everything on document load
    initDateRangePicker();
    plotAllCharts();

    // Functions definitions

    // Initialize the Date Range Picker
    function initDateRangePicker() {
        const dateRangeSettings = {
            startDate: moment().subtract(6, 'days'),
            endDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                    .endOf('year')
                ],
                'Custom Range': [null, null]
            },
            alwaysShowCalendars: true,
            locale: {
                format: 'MM/DD/YYYY'
            }
        };

        $('.date_range_filter').daterangepicker(dateRangeSettings, function(start, end) {
            $('.date_range_filter').val(start.format('MM/DD/YYYY') + ' ~ ' + end.format(
                'MM/DD/YYYY'));
            refreshCharts();
        });

        $('.date_range_filter').on('cancel.daterangepicker', function() {
            $('.date_range_filter').val('');
            refreshCharts();
        });
    }

    // Function to refresh all charts when data or filters are updated
    function refreshCharts() {
        plotStatisticsOverview();
        plotLoanOverview();
        plotExpensesChart();
        plotRevenuesIncomes();
    }
    

    // Plot statistics overview chart
    function plotStatisticsOverview() {
        try {
            const statisticsData = @json($statisticsData); // Get the data from Laravel
            const formattedData = formatDataForMorris(statisticsData);
            renderMorrisLineChart('#statisticsChart', formattedData);
        } catch (error) {
            console.error("Error plotting statistics overview:", error);
        }
    }

    // Function to format data for Morris chart
    function formatDataForMorris(data) {
        return Object.keys(data).map(key => ({
            y: key,
            value: data[key]
        }));
    }

    // Function to render Morris Line Chart
    function renderMorrisLineChart(elementId, data) {
        new Morris.Line({
            element: elementId.substring(1), // Remove the '#' for Morris
            data: data,
            xkey: 'y',
            ykeys: ['value'],
            labels: ['Value'],
            lineColors: ['#0b62a4'],
            parseTime: false,
            hideHover: 'auto',
            resize: true
        });
    }

    // Plot loan overview (stacked bar chart)
    function plotLoanOverview() {
        try {
            const loan = @json($monthlyLoanData);
            const {
                issuedData,
                repaidData,
                dueData
            } = formatLoanData(loan);
            renderBarChart('#chartStacked1', issuedData, repaidData, dueData);
        } catch (error) {
            console.error("Error plotting loan overview:", error);
        }
    }

    // Format loan data into issued, repaid, and due arrays
    function formatLoanData(loan) {
        const issuedData = Array(12).fill(0);
        const repaidData = Array(12).fill(0);
        const dueData = Array(12).fill(0);

        loan.forEach(item => {
            const monthIndex = parseInt(item.date.split('-')[1]) - 1; // 0-based month index
            issuedData[monthIndex] = item.principal_amount;
            repaidData[monthIndex] = item.repaid_amount;
            dueData[monthIndex] = item.loan_amount - item.repaid_amount;
        });

        return {
            issuedData,
            repaidData,
            dueData
        };
    }

    // Render the Bar Chart for loan overview
    function renderBarChart(elementId, issuedData, repaidData, dueData) {
        const ctx = $(elementId);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                    'Nov', 'Dec'
                ],
                datasets: [{
                        label: 'Loans Issued',
                        data: issuedData,
                        backgroundColor: '#6610f2',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Loans Repaid',
                        data: repaidData,
                        backgroundColor: '#00cccc',
                        borderWidth: 1,
                        fill: true
                    },
                    {
                        label: 'Loans Due',
                        data: dueData,
                        backgroundColor: '#ffcc00',
                        borderWidth: 1,
                        fill: true
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11
                        }
                    }],
                    xAxes: [{
                        barPercentage: 0.6,
                        categoryPercentage: 0.8,
                        ticks: {
                            fontSize: 11
                        }
                    }]
                },
                legend: {
                    display: true
                }
            }
        });
    }

    // Plot expense donut chart
    function plotExpensesChart() {
        try {
            const expenseData = @json($expenseCategoryData);
            const formattedData = formatExpenseData(expenseData);
            renderFlotPieChart('#expenseChart', formattedData);
        } catch (error) {
            console.error("Error plotting expenses chart:", error);
        }
    }

    // Format data for Flot donut chart
    function formatExpenseData(data) {
        return Object.keys(data).map(key => ({
            label: key,
            data: parseFloat(data[key])
        }));
    }

    // Render Flot Donut Chart
    function renderFlotPieChart(elementId, data) {
        $.plot(elementId, data, {
            series: {
                pie: {
                    show: true,
                    radius: 0.8,
                    innerRadius: 0.5,
                    label: {
                        show: true,
                        radius: 2 / 3,
                        formatter: labelFormatter,
                        threshold: 0.1,
                        background: {
                            opacity: 0.5,
                            color: "#000"
                        }
                    }
                }
            },
            legend: {
                show: true,
                container: '#donut-chart-legend',
                labelFormatter: function(label, series) {
                    return `<span class="legendLabel">${label} (UGX ${series.data[0][1].toLocaleString()})</span>`;
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            }
        });
    }

    // Plot revenue/income pie chart
    function plotRevenuesIncomes() {
        try {
            const revenueData = @json($revenueData);
            const data = formatRevenueData(revenueData);
            renderFlotPieChart('#flotPie', data);
        } catch (error) {
            console.error("Error plotting revenues/incomes chart:", error);
        }
    }

    // Format data for revenue/income pie chart
    function formatRevenueData(data) {
        return [{
                label: 'Loan Interest',
                data: [
                    [1, data.Loan_interest]
                ],
                color: '#6f42c1'
            },
            {
                label: 'Loan Charges',
                data: [
                    [1, data.Loan_charges]
                ],
                color: '#007bff'
            }
        ];
    }

    // Formatter for pie chart labels
    function labelFormatter(label, series) {
        return `<div style="font-size:10px; text-align:center; padding:2px; color:white;">${Math.round(series.percent)}%</div>`;
    }

    // Initialize all charts when page loads
    function plotAllCharts() {
        plotStatisticsOverview();
        plotLoanOverview();
        plotExpensesChart();
        plotRevenuesIncomes();
    }
});
</script>