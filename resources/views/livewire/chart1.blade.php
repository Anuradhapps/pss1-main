
<h1>Dashboard</h1>







<div class="text-lg">
<?php                                        
    $dataPoints1 = array();
    echo ( "From : ".$this->fromdate);
    echo (" &nbsp &nbsp &nbsp &nbsp   ");
    echo (" To : ".$this->todate);
?>
</div>
<br>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>









                                        
@foreach ($alldatadis as $item)
    
    @if ( $item->reccount!=0)
    <?php
    
    $newdata =  array(
        "label" => $item->district,
        "y" => ($item->thrips/$item->reccount),

    );
    array_push($dataPoints1, $newdata);
    ?>
    @endif
@endforeach





<?php
$dataPoints2 = array();
?>

@foreach ($alldatadis as $item)
@if ($item->tillers!=0 && $item->reccount!=0)
    @if (((($item->gallmidge/$item->reccount)/($item->tillers/$item->reccount))*100)==0)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @elseif(((($item->gallmidge/$item->reccount)/($item->tillers/$item->reccount))*100)<=1)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 1,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @elseif(((($item->gallmidge/$item->reccount)/($item->tillers/$item->reccount))*100)<=5)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 3,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @elseif(((($item->gallmidge/$item->reccount)/($item->tillers/$item->reccount))*100)<=10)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 5,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @elseif(((($item->gallmidge/$item->reccount)/($item->tillers/$item->reccount))*100)<=25)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 7,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @else
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 9,
        );
        array_push($dataPoints2, $newdata);
        ?>
    @endif
@else
<?php
$newdata =  array(
        "label" => $item->district,
        "y" => 0,
    );
array_push($dataPoints2, $newdata);
?>
@endif    
@endforeach





<?php
$dataPoints3 = array();
?>
@foreach ($alldatadis as $item)
@if ($item->tillers!=0 && $item->reccount!=0)
    @if (((($item->leaffolder/$item->reccount)/($item->tillers/$item->reccount))*100)==0)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @elseif (((($item->leaffolder/$item->reccount)/($item->tillers/$item->reccount))*100)<=5)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 1,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @elseif (((($item->leaffolder/$item->reccount)/($item->tillers/$item->reccount))*100)<=10)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 3,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @elseif (((($item->leaffolder/$item->reccount)/($item->tillers/$item->reccount))*100)<=20)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" =>5,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @elseif (((($item->leaffolder/$item->reccount)/($item->tillers/$item->reccount))*100)<=50)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 7,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @else
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 9,
        );
        array_push($dataPoints3, $newdata);
        ?>
    @endif
@else
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints3, $newdata);
        ?>
@endif
@endforeach



<?php
$dataPoints4 = array();
?>
@foreach ($alldatadis as $item)
@if ($item->tillers!=0 && $item->reccount!=0)
    @if (((($item->yellowerstemborer/$item->reccount)/($item->tillers/$item->reccount))*100)==0)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @elseif (((($item->yellowerstemborer/$item->reccount)/($item->tillers/$item->reccount))*100)<=1)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 1,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @elseif (((($item->yellowerstemborer/$item->reccount)/($item->tillers/$item->reccount))*100)<=3)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 3,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @elseif (((($item->yellowerstemborer/$item->reccount)/($item->tillers/$item->reccount))*100)<=10)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" =>5,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @elseif (((($item->yellowerstemborer/$item->reccount)/($item->tillers/$item->reccount))*100)<=50)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 7,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @else
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 9,
        );
        array_push($dataPoints4, $newdata);
        ?>
    @endif
@else
<?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints4, $newdata);
        ?>
@endif
@endforeach




<?php
$dataPoints5 = array();
?>
@foreach ($alldatadis as $item)
@if ( $item->reccount!=0)
    @if (((($item->bhp/$item->reccount)/50))==0)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @elseif (((($item->bhp/$item->reccount)/50))<=2)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 1,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @elseif (((($item->bhp/$item->reccount)/50))<=5)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 3,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @elseif (((($item->bhp/$item->reccount)/50))<=10)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" =>5,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @elseif (((($item->bhp/$item->reccount)/50))<=20)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 7,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @else
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 9,
        );
        array_push($dataPoints5, $newdata);
        ?>
    @endif
@endif
@endforeach



<?php
$dataPoints6 = array();
?>
@foreach ($alldatadis as $item)
@if ( $item->reccount!=0)
    @if (((($item->paddybug/$item->reccount)/10))==0)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 0,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @elseif (((($item->paddybug/$item->reccount)/10))<=1)
    <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 1,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @elseif (((($item->paddybug/$item->reccount)/10))<=4)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 3,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @elseif (((($item->paddybug/$item->reccount)/10))<=15)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" =>5,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @elseif (((($item->paddybug/$item->reccount)/10))<=20)
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 7,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @else
        <?php
        $newdata =  array(
            "label" => $item->district,
            "y" => 9,
        );
        array_push($dataPoints6, $newdata);
        ?>
    @endif
@endif
@endforeach



<script>
window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: ""
	},
	axisX:{
		title: "Districts"
	},
	axisY:{
		title: "",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	axisY2:{
		title: "Code",
		titleFontColor: "#C0504E",
		lineColor: "#C0504E",
		labelFontColor: "#C0504E",
		tickColor: "#C0504E"
	},
	legend:{
		cursor: "pointer",
		dockInsidePlotArea: false,
		itemclick: toggleDataSeries
	},
	data: [{
		type: "line",
		name: "thrips",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		axisYType: "secondary",
		name: "gallmidge",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		axisYType: "secondary",
		name: "leaffolder",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		axisYType: "secondary",
		name: "Yellower Stem Borer",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		axisYType: "secondary",
		name: "BPH",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
	},{
		type: "line",
		axisYType: "secondary",
		name: "Paddy Bug",
		markerSize: 0,
		toolTipContent: "District: {label} <br>{name}: {y}",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();

function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
}
</script>





















