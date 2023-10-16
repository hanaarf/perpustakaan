    
var dataa = [
    { year: 1986, indexGain: 14.50, name: 'Book A' },
    { year: 1987, indexGain: 24.43, name: 'Book B' },
    { year: 1988, indexGain: 17.50, name: 'Book C' },
    { year: 1989, indexGain: 45.90, name: 'Book D' },
];

// Lebar dan tinggi diagram
var width = 990;
var height = 250;

// Margin
var margin = { top: 10, right: 10, bottom: 30, left: 40 };

// Buat SVG
var svg = d3.select('#horizontal-chart-container').append('svg')
    .attr('width', width)
    .attr('height', height)
    .append('g')
    .attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

// Skala X
var x = d3.scaleLinear()
    .domain([d3.min(dataa, d => d.indexGain) - 5, d3.max(dataa, d => d.indexGain) + 5])
    .range([0, width - margin.left - margin.right]);

// Skala Y
var y = d3.scaleBand()
    .domain(dataa.map(d => d.year))
    .range([0, height - margin.top - margin.bottom])
    .padding(0.1);

// Buat sumbu X
svg.append('g')
    .attr('class', 'axis x')
    .attr('transform', 'translate(0,' + (height - margin.top - margin.bottom) + ')')
    .call(d3.axisBottom(x));

// Buat sumbu Y
svg.append('g')
    .attr('class', 'axis y')
    .call(d3.axisLeft(y));

// Buat grid lines horizontal
svg.append('g')
    .selectAll('line')
    .data(y.domain())
    .enter().append('line')
    .attr('class', 'grid-line horizontal')
    .attr('x1', 0)
    .attr('x2', width - margin.left - margin.right)
    .attr('y1', d => y(d) + y.bandwidth() / 2)
    .attr('y2', d => y(d) + y.bandwidth() / 2);

// Buat bubble chart
var bubbles = svg.selectAll('.bubble')
    .data(dataa)
    .enter().append('g')
    .attr('class', 'bubble')
    .attr('transform', d => 'translate(' + x(d.indexGain) + ',' + y(d.year) + ')');

// Buat lingkaran untuk setiap data point
bubbles.append('circle')
    .attr('class', 'bubble')
    .attr('fill', '#ffffbf')
    .attr('r', 20)
    .attr('opacity', 1);

// Tambahkan teks ke dalam lingkaran
bubbles.append('text')
    .attr('text-anchor', 'middle')
    .attr('dy', '.3em')
    .attr('opacity', 1)
    .text(d => d.name);

// Tambahkan tooltip
bubbles.append('title')
    .text(d => d.name + '\nYear: ' + d.year + '\nIndex Gain: ' + d.indexGain.toFixed(2) + '\n' + 'Fluctuation / Index Ratio: ' + (d.indexGain * 100 / d.year).toFixed(2) + '%');
