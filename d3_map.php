<?php 
require 'LiveNumber.php';


session_start();
session_unset();
$url = 'http://www.nbim.no//LiveNavHandler/Current.ashx?l=no&t=1430796488754&PreviousNavValue=6787804971058&key=263c30dd-d5ba-41d6-a9b1-c1fb59cf30da';

$curlHandle = curl_init($url);

$headers = array(
    'Content-Type : application/json',
    );

    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);


    $json = (String)curl_exec($curlHandle);
    curl_close($curlHandle);
    $json = json_decode($json);
    $oneValue = $json->d->liveNavList[0]->values[0]->Value;
    $moneyArray = $json->d->liveNavList[0]->values;
    //var_dump($json->d->liveNavList[0]->values[0]->Value); 

    foreach ($json->d->liveNavList[0]->values as $money) {
      //echo $money->Value;
      $oneValue = $money->Value;
    };
    function addStuff($a, $b){
      $c = $a+$b;
      return $c; 
    };
    
    $moneyArray = updateMoneyArray();


    
    
   
?>
<!DOCTYPE html>

<html>
<head>
  <style>
    .active { fill: blue !important;}
          /*.datamaps-key dt, .datamaps-key dd {float: none !important;}
          .datamaps-key {right: -50px; top: 0;}*/

          
    </style>
        <style type="text/css">
          body{
            background-color: #A2DED0;

          }
          #infoDiv{
            background-color: #ecf0f1;
            border-color: black;
            border-width: 10px;
            border-radius:10px;
            height: 600px;
            width: 600px;
          }
          #infoDiv2{
            background-color: #ecf0f1;
            border-color: black;
            border-width: 10px;
            border-radius:10px;
            height: 600px;
            width: 600px;
          }

          #header1{
            color: #6C7A89;
            margin: 10px;
            font: 50px Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            text-shadow: 0px 1px black;
            text-align: center;
          }
          #header2{
            color: #6C7A89;
            margin: 10px;
            font: 50px Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            text-shadow: 0px 1px black;
            text-align: center;
          }
          #totalEquityValue1{
            color: #1F3A93;
            margin: 10px;
            font: 30px Arial, sans-serif;
          }
          #totalEquityValue2{
            color: #1F3A93;
            margin: 10px;
            font: 30px Arial, sans-serif;
          }
          input[type=checkbox] {
             visibility: hidden;
          }
          .compare {
            width: 180px;
            height: 36px;
            background: gray;
            margin: 20px auto;

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            position: relative;

            -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
            -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
            box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
          }

        .compare:after {
          content: 'compare';
          font: 18px/26px Arial, sans-serif;
          color: #000;
          position: absolute;
          right: 10px;
          top: 7px;
          z-index: 0;
          font-weight: bold;
          
        }

      .compare:before {
        content: 'compare';
        font: 18px/26px Arial, sans-serif;
        color: #1E824C;
        position: absolute;
        left: 10px;
        top: 7px;
        z-index: 0;
        font-weight: bold;
      }

    .compare label {
      display: block;
      width: 90px;
      height: 30px;

      -webkit-border-radius: 50px;
      -moz-border-radius: 50px;
      border-radius: 50px;

      -webkit-transition: all .4s ease;
      -moz-transition: all .4s ease;
      -o-transition: all .4s ease;
      -ms-transition: all .4s ease;
      transition: all .4s ease;
      cursor: pointer;
      position: absolute;
      top: 3px;
      left: 3px;
      z-index: 1;

      -webkit-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
      -moz-box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
      box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.3);
      background: #fcfff4;

      background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
      background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
      background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
      background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
      background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
    }

    .compare input[type=checkbox]:checked + label {
      left: 87px;
    }


          rect {
        
            fill-opacity:.6;
         }
        </style>
      </head>
      
      <body>

        
       <h1 id = "money"></h1>

        <script type="text/javascript">
        //var php_var = <?php echo ($jsonLiveNumbers); ?>;
        </script>
          
        <div id="container" style="position: relative; width: 1000px; height: 500px;"></div>
        <div class="compare">  
        <input type="checkbox" value="compare" id="compare" name="compare" onclick= 'handleClick(this);'/>
        <label for="compare"></label>


        </div>
        <div> 
       <div class = "information";   style = "width: 100% overflow: hidden;">
        <div id = "infoDiv"  class = "infoDiv" style="margin-left:20px; float: left" position: relative  height = "600" width = "500">
          <h1 id = "header1"></h1>
          <p id = "totalEquityValue1"></p>
          <svg version="1.1" id="svg1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          width="600px" height="600px" viewBox="0 0 600 600"
          xml:space="preserve"></svg>  
        Left</div>
      <div></div>
        <div id = "infoDiv2"  class = "infoDiv" style="margin-left:650px" position: relative  height = "100" width = "500">
          <h1 id = "header2"></h1>
          <p id = "totalEquityValue2"></p>
          <svg version="1.1" id="svg2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          width="500px" height="500px" viewBox="0 0 500 500"
          xml:space="preserve"></svg>  
        Right</div>
      </div>
        
        <script src="/src%20/js/components/d3/d3.min.js"></script>
        <script src="/src%20/js/components/topojson/topojson.js"></script>
        <!-- <script src="/src/js/json2.js"></script> -->
        <script src="/dist/datamaps.world.js"></script>
        <script src="http://d3js.org/d3.v3.min.js"></script>
        <script src="/d3-tip-master/index.js"></script>

        </form>

        <script>
        var m = 0
        var max
        var min = 0.1
        var firstTime = true

        var totalFundEquityValue = 0

        var realEstateArray = []
        var data
        
        var margin = {top: 50, bottom: 10, left:200, right: 40};
        var width = 450 - margin.left - margin.right;
        var height = 400 - margin.top - margin.bottom;

        var width2 = 800 - margin.left - margin.right;
        var height2 = 400 - margin.top - margin.bottom;

        var xScale = d3.scale.linear().range([0, width]);
        var yScale = d3.scale.ordinal().rangeRoundBands([0, height], .8, 0);


//Barchart
        var width = 960,
            height = 500,
            radius = Math.min(width, height) / 2;

      var color = d3.scale.ordinal().range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

      var arc = d3.svg.arc()
                  .outerRadius(radius - 10)
                  .innerRadius(radius - 70);

      var pie = d3.layout.pie()
          //.sort(null)
          .value(function(d) { 
            console.log(d)
          return d.value; });

      var svg = d3.select("body").append("svg")
          .attr("width", width)
          .attr("height", height)
          .append("g")
          .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");


        var svg1 = d3.select(document.getElementById('svg1')).append("svg")
                .attr("width", width+margin.left+margin.right)
                .attr("height", height+margin.top+margin.bottom);
                //.attr("element", document.getElementById('svg1'));
 
        var g1 = svg1.append("g")
                .attr("transform", "translate("+margin.left+","+margin.top+")")
                .attr("text", "translate("+margin.left+","+margin.top+")");

        var svg2 = d3.select(document.getElementById('svg2')).append("svg")
                .attr("width", width+margin.left+margin.right)
                .attr("height", height+margin.top+margin.bottom);
                  //.attr("element", document.getElementById('infoDiv2'));

        var g2 = svg2.append("g")
                .attr("transform", "translate("+margin.left+","+margin.top+")")
                .attr("text", "translate("+margin.left+","+margin.top+")");


       //console.log("php variable: "+php_var)

        var rows
        var bars

        var javaScriptMoneyArray = <?php echo json_encode($moneyArray); ?>;
        console.log(javaScriptMoneyArray)
        var moneyTitle = document.getElementById('money')

        

        var myVar=setInterval(function(){updateMoneyTitle()},200);


        updateMoneyTitle()

        function updateMoneyTitle(){
          
          if (m<60){
            moneyTitle.innerHTML = javaScriptMoneyArray[m].Value
            m ++;
          }
          else{
            //javaScriptMoneyArray = <?php echo json_encode(updateMoneyArray());?>;
            m = 0

          }
         
        }
       
        document.getElementById("infoDiv2").style.display = 'none';


        var compare = false
       

        var segmentArray = ["Oil & Gas", "Industrials", "Financials", "Health Care", "Basic Materials", "Consumer Goods", "Telecommunications", "Technology", undefined, "Consumer Services", "Utilities"]

        
        //console.log(returnBalle())


    d3.json("NBIM_map_2014.json", function(data) {
        //svg1.element = document.getElementById('svg1')
        //svg2.element = document.getElementById('svg2')

          //var map = new Datamap({element: document.getElementById('container')});
         // var tip = d3.tip().attr('class', 'd3-tip').html(function(d) { return d.segment });
          //var companyValue = d3.tip().attr('class', 'd3-tip').html(function(d) { return "$"+d.value });
          //svg1.call(tip)
          //svg1.call(companyValue)
          var realestateMap = new Datamap({
            //datamaps-subunit.y = 0,
            element: document.getElementById('container'),
            scope: 'world',
            position : 'relative',  
            //element: document.getElementById('map'),
            responsive: true,
            done: function(datamap) {
            datamap.svg.selectAll('.datamaps-subunit').on('click', function(geography) {
                            
                if (firstTime == true){ 
                  //createBars(getTopTenCompanies(geography.properties.name), "svg1")
                  createChart(getInvestmentValues(geography.properties.name))
                  createBars(getTopTenCompanies(geography.properties.name), "svg2")
                  header1.innerHTML = geography.properties.name 
                  totalEquityValue1.innerHTML = "Fraction of fund:" + convertToPercentString(getEquityInformation(geography.properties.name))
                  header2.innerHTML = geography.properties.name
                  totalEquityValue2.innerHTML = "Fraction of fund:" + convertToPercentString(getEquityInformation(geography.properties.name))
                  //createBars(getTopTenCompanies(geography.properties.name), svg2, "g2")
                  firstTime = false
                }
                else{
                  if (compare) {
                    console.log("burde skje")
                    updateBars(getTopTenCompanies(geography.properties.name), "svg2")
                    header2.innerHTML = geography.properties.name
                    totalEquityValue2.innerHTML = "Fraction of fund:" + convertToPercentString(getEquityInformation(geography.properties.name))
                  }
                  else{
                    updateBars(getTopTenCompanies(geography.properties.name), "svg1")
                    updateBars(getTopTenCompanies(geography.properties.name), "svg2")
                    header1.innerHTML = geography.properties.name 
                    totalEquityValue1.innerHTML = "Fraction of fund:" + convertToPercentString(getEquityInformation(geography.properties.name))
                    header2.innerHTML = geography.properties.name
                    totalEquityValue2.innerHTML = "Fraction of fund:" + convertToPercentString(getEquityInformation(geography.properties.name))
                  }
                  
                  
                }


                
            });
            },
            geographyConfig: {
              popupOnHover: true,
              highlightOnHover: true,
              borderColor: '#444',
              borderWidth: 0.5
            },
            bubblesConfig: {
              popupTemplate: function(geography, data) {
                return '<div class="hoverinfo">Some From New: data about ' + data.centered + '</div>'
              },
              fillOpacity: 0.2
            },
            fills: {
              
              defaultFill: '#ffffff'
            }
             
      
          });
        data = data.re
        changeUSName()
        getMaxEquity()
        getTotalFundEquityValue()
        console.log(max)
        console.log(data)
        mapIdDataToMap()
        getSegments()
       


        function getSegments(){
          var segmentArray = []
          for (i in data){
            
            for (j in data[i].ct){
              for (k in data[i].ct[j].eq){
                for (l in data[i].ct[j].eq[k]){

                

               if (segmentArray.indexOf(data[i].ct[j].eq[k][l].s)<0){
                segmentArray.push(data[i].ct[j].eq[k][l].s)
               }
                }

              }

            }
          }
          console.log(segmentArray)
        }

        function getInvestmentValues(name){
          var total_equity 
          var total_fixed
          var total_real_estate
          var total
          for (i in data){
            for (j in data[i].ct){
              if (data[i].ct[j].n == name){
                total_equity = data[i].ct[j].eq.vu
                total_fixed = data[i].ct[j].fi.vu
                total_real_estate = data[i].ct[j].re.vu
                total = total_fixed+total_equity+total_equity
                var investmentObject = [{total_equity: total_equity, total_fixed: total_fixed, total_real_estate
                : total_real_estate, total: total}]
                var investmentArray = [{total_equity: total_equity}, {total_fixed: total_fixed}, {total_real_estate: total_real_estate}, {total: total}]

              }
            }
          }
          return investmentArray

        }

        function createChart(data){
          
          //var dataArray = Object.keys(data).map(function (key) {return data[key]});
          console.log(data)
           var g = svg.selectAll(".arc")
                      
                      .data(pie(data))
                      .enter().append("g")
                      .attr("class", "arc");

          g.append("path")
            .attr("d", arc)
            .style("fill", function(d) { return color(d.value); });

          g.append("text")
             .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
              .attr("dy", ".35em")
              .style("text-anchor", "middle")
              .text(function(d) { return d; });
          }



        function createBars(data, svg_name){
            
            max = d3.max(data, function(d) { return d.value; } );
            console.log("max value is: "+max)
            min = 0;
            xScale.domain([min, max]);
            yScale.domain(data.map(function(d) { return d.name; }));
           
            console.log(height)
            var height = 20
            console.log(height)
            

            
            rows = d3.select(document.getElementById(svg_name)).append("g")

                    .selectAll("g")
                    .data(data)
                    .enter()
                    .append("g")
                    .attr("class", "row");       
            //rect.enter().append("rect");

            bars = rows.append("rect")
                .attr("width", function(d) {
                 return xScale(d.value); })
                .attr("height", height)
                .attr("fill", function(d){
                      return getColor(d.segment);
                    })
                .attr("x", 0)
                .attr("y", function(d) { return yScale(d.name); })
               // .on('mouseover', tip.show)
                //.on('mouseout', tip.hide)

            var text = rows
                        .append("text")
                        .text(function (d) {  
                        return getCompanyString(d)
                        });
                      
 
          text.attr("x", function (d, i) {
          return xScale(min) + 300;
          })
          .attr("y", function(d) { return yScale(d.name)+height; })
          .attr("width", 300)
          .attr("fill", "black")
          .style("font-size","15px")
          //.on('mouseover', companyValue.show)
          //.on('mouseout', companyValue.hide)
              }


      function updateBars(newData, svg_name){

            max = d3.max(newData, function(d) { return d.value; } );
            console.log("update on max: " +max)
            min = 0;
            xScale.domain([min, max]);
            yScale.domain(newData.map(function(d) { return d.name; }));
                
                var height = 20

          rows = d3.select(document.getElementById(svg_name))
                    .selectAll("g.row")
                    .data(newData);
                         
            //rect.enter().append("rect");
         
              rows.enter().append("rect");

              rows.select("rect")
                    .attr("fill", function(d){
                      return getColor(d.segment);
                    })
                    .attr("x", 0)
                    .attr("y", function(d) { 
                    return yScale(d.name); })

                  .attr("width", function(d) {
                    return xScale(d.value); })
                  .attr("height", height)
 
              rows.enter().append("text");

              text = rows.select("text")
                .text(function (d) { return getCompanyString(d)});

              text.attr("y", function(d) { return yScale(d.name)+height; })

              rows.exit().remove();
             

            }
        
      function getTotalFundEquityValue(){
        for (i in data){
            for (j in data[i].ct){
              if (data[i].ct[j].eq != undefined){
                totalFundEquityValue += data[i].ct[j].eq.vu
              }
        }
      }
    }
   
      function getEquityInformation(name){
        for (i in data){
            for (j in data[i].ct){
                if (data[i].ct[j].n == name){
                    return data[i].ct[j].eq.vu/totalFundEquityValue
                }
            }
        }
      }

      function convertToPercentString(number){
        var percentNumber = number*100
        var numberString = String(percentNumber)
        if (percentNumber < 0.01){
          return numberString.substring(0,6)+"%"
        }
        else{
           return numberString.substring(0,4)+"%"
        }
      }
      function converFromPercentToString(number){
        var numberString = String(number)
        return numberString.substring(0,4)+"%"
      }

      function getCompanyString(data){
        var companyName = data.name
        var companyPercent = converFromPercentToString(data.ownership)
        //console.log(companyName+ ", " +companyPercent)
        if (data.ownership != 0){
           return companyName+ ", " +companyPercent
        }
       
      }

      function getTopTenCompanies(name){
   
        for (i in data){
            for (j in data[i].ct){
                if (data[i].ct[j].n == name && data[i].ct[j].eq != undefined){

                  var companyArray = data[i].ct[j].eq.cp
                  companyArray.sort(function(a,b){
                    return  b.h.vu - a.h.vu
                  })
            }
          }
        }
        var slicedArray =  companyArray.slice(0,10)
        console.log(slicedArray.length)
        var returnArray = []
        for (i in slicedArray){
          var companyInfo = {name: slicedArray[i].n, ownership: slicedArray[i].h.o, value: slicedArray[i].h.vu, segment: slicedArray[i].s}
          //returnArray.push(slicedArray[i].n, slicedArray[i].h.o))
          returnArray.push(companyInfo)
        }
        var name = 1
        while(returnArray.length<10){
          var companyInfoNil = {name: name, ownership: 0, value: 0, segment: ""}
          name += 1
          returnArray.push(companyInfoNil)

        }
        return returnArray
      }

    function tableCreate(topTen){
      var tbl = document.getElementById('topTenCompanies')
      tbl.innerHTML =""
      //var body = document.body,
      //    tbl  = document.createElement('table');
      //    tbl.setAttribute("topTenCompanies", "infoDiv" )
      //tbl.style.width  = '100px';
      console.log(tbl)
      //tbl.style.border = "1px solid black";

    for(var i = 0; i < 10; i++){
        var tr = tbl.insertRow();
        for(var j = 0; j < 3; j++){    
            var td = tr.insertCell();
                console.log(topTen)
                if (j == 0){
                  td.appendChild(document.createTextNode(topTen[i].name));
                }
                else if(j == 1){
                  td.appendChild(document.createTextNode(topTen[i].ownership));
                }
                else{
                 // var svg = d3.select("td").append("svg").attr("width", 50).attr("height", 20).attr("x", 10000).attr("y", 20*i)
                  //td.appendChild(document.createTextNode(topTen[i].value));
                }
         
            }
        }
    console.log(tbl)
    body.appendChild(tbl);
  }

  function upDateTable(){
    tbl = document.getElementById('table');
    console.log(tbl)
  }


 // tableCreate();


        

      function getMaxEquity(){
        max = 0
        for (i in data){
            for (j in data[i].ct){
                if (data[i].ct[j].eq != undefined && data[i].ct[j].eq.vu >= max){
                    max = data[i].ct[j].eq.vu
                }
              }
                
            }

        }
        function changeUSName(){
          for (i in data){
            for (j in data[i].ct){
              if (data[i].ct[j].n == "United States"){
                data[i].ct[j].n = "United States of America"
              }
            }
        }
      }

      function mapIdDataToMap(){
        var mapArray =  realestateMap.options.element.firstElementChild.children[0].children
        
        for (g in data){
            for (h in data[g].ct){
                for(var i = 0; i < mapArray.length; i++){ 
                    if (mapArray[i].__data__.properties.name == data[g].ct[h].n){
                       
                        data[g].ct[h].id = mapArray[i].__data__.id
                        if (data[g].ct[h].eq != undefined){
                          mapArray[i].style.fill = gradient(data[g].ct[h].eq.vu)
                        }
                        else{
              
                          console.log(mapArray[i].style.fill)
                          mapArray[i].style.fill = 'white'
                        }
                        
                         }
                    }
                }

            }
            console.log(data)
        }

        function gradient(totalEquityValue){
          var fillScale = d3.scale.log().domain([0.005*max, max]).range(["yellow", "red"])
          console.log(fillScale(totalEquityValue))
          return fillScale(totalEquityValue)
        }

        function getColor(segment){
          switch(segment){
            case "Oil & Gas":
            return "#49ef70"
            case "Industrials":
            return "b9005c"
            case "Financials":
            return "#a200ff"
            case "Health Care":
            return "#f09609"
            case "Basic Materials":
            return "#e13636"
            case "Consumer Goods":
            return "#00ffff"
            case "Telecommunications":
            return "006400"
            case "Technology":
            return "#0000ff"
            case "Consumer Services":
            return "#ffff00"
            case "Utilities":
            return "#8a2be2"
            default:
            return "#000000"


          }

        }
var segmentArray = ["Oil & Gas", "Industrials", "Financials", "Health Care", "Basic Materials", "Consumer Goods", "Telecommunications", "Technology", undefined, "Consumer Services", "Utilities"]
  });
    
  window.addEventListener('resize', function() {
        realestateMap.resize();
    });

    //alternatively with d3
    d3.select(window).on('resize', function() {
        realestateMap.resize();
    });
     function handleClick(cb){
      console.log("neger i beger")
      d3.selectAll("input").each(function(d){
         
        if (d3.select(cb).attr("value") == "compare" && d3.select(cb).node().checked){
          console.log("balle")
          compare = true
          document.getElementById("infoDiv2").style.display = 'block';
        }
        else{
          compare = false
          document.getElementById("infoDiv2").style.display = 'none';
        }
      }
      )}
      



</script>
</body>
</html>