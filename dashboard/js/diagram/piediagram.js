fetch('../../backend/piebiblio.php')
    .then(response => response.json())
    .then(data => {
        // Definisikan lebar dan tinggi SVG
        var width = 200;
        var height = 200;

        // Buat SVG di dalam elemen dengan id "pie-chart"
        var svg = d3.select("#pie-chart")
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        // Definisikan skala warna
        var color = d3.scaleOrdinal(d3.schemeCategory10);

        // Buat pie chart
        var pie = d3.pie().value(function (d) {
            return d.count;
        });

        var arc = d3.arc()
            .innerRadius(0)
            .outerRadius(80);

        var path = svg.selectAll("path")
            .data(pie(data))
            .enter()
            .append("path")
            .attr("d", arc)
            .attr("fill", function (d) {
                return color(d.data.publisher_id);
            });

        // Tambahkan label dengan nama dan persentase di dalam pie chart
        var label = svg.selectAll("text")
            .data(pie(data))
            .enter()
            .append("text")
            .attr("transform", function (d) {
                var pos = arc.centroid(d);
                // Menggunakan trigonometri untuk menentukan posisi teks yang lebih akurat
                var x = pos[0] * 0.85;
                var y = pos[1] * 0.85;
                return "translate(" + x + "," + y + ")";
            })
            .attr("dy", "0.35em")
            .text(function (d) {
                var percentage = ((d.data.count / data.reduce((acc, curr) => acc + curr.count, 0)) * 100)
                    .toFixed(2);
                return d.data.publisher_id + " (" + percentage + "%)";
            })
            .style("text-anchor", "middle");
    })
    .catch(error => console.error(error));