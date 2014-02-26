function createStatusTable(jsonData) {


    // Binding json data from json object instead of reading from file
    data = JSON.parse(jsonData);

    var reg = new RegExp("(-)", "g");
    data.forEach(function (d) {

        d.event = d.event.toLowerCase();
        d.event = d.event.charAt(0).toUpperCase() + d.event.substr(1);
        d.event = d.event.replace(reg, " ");

    });

    var margin = {top: 40, right: 20, bottom: 0, left: 50};

    var w = window.innerWidth,                           //width
        h = window.innerHeight * 2 / 3;                            //height

    // -------------------------------------------------------------------------------------------------------------------------------
    // CREATION OF TABLE


    function tabulate(data, columns) {
        var table = d3.select("#statustable")
                .append("table")
                .attr("width", document.getElementById("statustable").offsetWidth)
                .attr("height", h)
                .style("max-height", '400px')
                // Make it responsive.
                .attr("viewBox", "0 0 " + w * 0.6 + " " + h)
                .attr("preserveAspectRatio", "xMidYMid")
                .attr("class", "resizeStatusTable"),

            thead = table.append("thead"),
            tbody = table.append("tbody");

        // append the header row
        thead.append("tr")
            .selectAll("th")
            .data(columns)
            .enter()
            .append("th")
            .text(function (column) {
                return column;
            });

        // create a row for each object in the data
        var rows = tbody.selectAll("tr")
            .data(data)
            .enter()
            .append("tr");

        // create a cell in each row for each column
        var cells = rows.selectAll("td")
            .data(function (row) {
                return columns.map(function (column) {
                    return {column: column, value: row[column]};
                });
            })
            .enter()
            .append("td")
            .text(function (d) {
                if (d.column == "lastTime")return " ";
                else return d.value;
            })
            .append("svg")
            .attr("width", 25)
            .attr("height", 25)
            .append("circle")
            .attr("cx", 10)
            .attr("cy", 10)
            .attr("r", function (d) {
                if (d.column == "event")return 0;
                else return 10;
            })
            .style("fill", function (d) {
                // rule for red dot : more than 1 day
                if (d.value >= 3600 * 24) return "red";
                // rule for orange dot : between 0.5 and 1 day
                if (3600 * 12 <= d.value < 3600 * 24) return "orange";
                // rule for green dot : less than 0.5 day
                if (d.value < 3600 * 12) return "green";
            });

        return table;
    }

// render the table
    var activities = tabulate(data, ["event", "lastTime"]);

// uppercase the column headers
    activities.selectAll("thead th")
        .text(function (column) {
            return column.charAt(0).toUpperCase() + column.substr(1);
        });

// sort by patientId
    activities.selectAll("tbody tr")
        .sort(function (a, b) {
            return d3.ascending(a.lastTime, b.lastTime);
        });

};