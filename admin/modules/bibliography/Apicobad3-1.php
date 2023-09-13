<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contoh Grafik D3.js</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>
    <div id="grafik"></div>

    <script>
        d3.json("Apicobad3.php", function(data) {
            var xScale = d3.scaleLinear()
                .domain([0, d3.max(data, function(d) { return d.image; })])
                .range([0, 400]);

            d3.select("#grafik")
                .selectAll("div")
                .data(data)
                .enter()
                .append("div")
                .style("width", function(d) { return xScale(d.image) + "px"; })
                .text(function(d) { return d.title; });
        });
    </script>
</body>
</html>
