<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF8">
    <title>NetVis</title>
    <script type="text/javascript" src="vis/vis.js"></script>
    <link type="text/css" rel="stylesheet" href="vis/vis-network.min.css">
    <link type="text/css" rel="stylesheet" href="netvis.css">
    <script type="text/javascript">
        function loadJSON(path, success, error) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        success(JSON.parse(xhr.responseText));
                    } else {
                        error(xhr);
                    }
                }
            };
            xhr.open('GET', path, true);
            xhr.send();
        }
    </script>

</head>

<body>

    <div id="mynetwork"></div>

    <script type="text/javascript">
        var network;

        var nodes = new vis.DataSet();
        var edges = new vis.DataSet();

        var nodeContent = document.getElementById('nodeContent');

        loadJSON('data.json', redrawAll, function(err) {
            console.log('error')
        });

        var container = document.getElementById('mynetwork');
        var data = {
            nodes: nodes,
            edges: edges
        };

        var options = {
            nodes: {
                shape: 'circle',
                font: {
                    face: 'Tahoma'
                }
            },
            edges: {
                width: 0.5,
                smooth: {
                    type: 'continuous'
                }
            },
            interaction: {
                tooltipDelay: 200,
                hideEdgesOnDrag: true
            },
            physics: {
                stabilization: false,
                barnesHut: {
                    gravitationalConstant: -10000,
                    springConstant: 0.002,
                    springLength: 100
                }
            }
        };

        network = new vis.Network(container, data, options);
        network.on('click', function(params) {})

        /**
         * This function fills the DataSets. These DataSets will update the network.
         */
        function redrawAll(json) {

            console.log(json);

            // clear old data
            nodes.clear();
            edges.clear();

            // add the parsed data to the DataSets.
            nodes.add(json.nodes);
            edges.add(json.edges);

            var data = nodes.get(2); // get the data from node 2 as example
            network.fit(); // zoom to fit
        }
    </script>

</body>

</html>