	<div class="container">
		<div class="row">
			<div class="col-sm">
<div style="text-align: justify;" >				
Задача:
<p>
Написать код, который выполнит следующие действия.
При первом нажатии на Button, первая ячейка окрашивается в красный цвет. При последующих нажатиях добавляется еще одна строка в которой окрашивается в красный цвет вторая ячейка, третья, и так далее пока не будет всего 5 строк и красной диагонали. Так же в каждой нечетной строке в окрашенной ячейке меняем «*» на «+».
</p>
<p>
При шестом нажатии на Button должна появиться надпись поверх таблицы «Test Complete». Если нажать на надпись она плавно исчезнет. Код можно вставить сюда или приложить в файле к письму.
</p>
</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm"></div>
			<div class="col-sm">
				<div class="card" >
					<table class="stars-table" >
						<tr>
							<td>*</td>
							<td>*</td>
							<td>*</td>
							<td>*</td>
							<td>*</td>
						</tr>
					</table>
					<div class="fire-button btn btn-primary btn-sm" >
						жги!!!
					</div>
					<div class="overlay" ><h5>Test Complete</h5></div>
				</div>
			</div>
			<div class="col-sm"></div>
		</div>
		<div class="row">
			<div class="col-sm">

<pre>
$(function(){
	
	function showOverlay() {
		var parent = $(".overlay").parent();
		$(".overlay").width(parent.width());
		$(".overlay").height(parent.height());
		$(".overlay").show(100);
		
		$(".overlay").bind("click", function(){
			$(this).hide(500);
		});
		
	}
	
	$(".fire-button").bind("click", function() {
		var tableRows = $(".stars-table tr");
		if(tableRows.length && !tableRows.hasClass("marked")) {
			var cell = tableRows.find("td")[0];
			$(cell).addClass("red");
			$(cell).css('background', 'red');
			$(cell).html("+");
			tableRows.addClass("marked");
		}
		else if(tableRows.length == 5){
			$(".fire-button").hide();
			showOverlay();
		}
		else {
			var tableRow = $(".stars-table tr:last-child");
			var newRowElement = $(tableRow.clone());
			
			var redCell = newRowElement.find(".red");
			redCell.html(redCell.html()=="*"?"+":"*");
			
			var td = newRowElement.find("td:last-child");
			newRowElement.prepend(td);
			
			$(".stars-table").append(newRowElement);
		}
	});
});
</pre>

			</div>
		</div>
	</div>

	<style media="screen">
		table.stars-table {
			width: 100%;
		}
		table.stars-table td {
			border: 1px solid black;
			/*width: 20px;
			height: 20px;*/
			vertical-align: middle;
			text-align: center;
		}
		table.stars-table td.red {
			background-color: red;
		}
		.overlay {
			display: none;
			position: absolute;
			background-color: #fff3cd;
		}
	</style>
	
<script>
$(function(){
	
	function showOverlay() {
		var parent = $(".overlay").parent();
		$(".overlay").width(parent.width());
		$(".overlay").height(parent.height());
		$(".overlay").show(100);
		
		$(".overlay").bind("click", function(){
			$(this).hide(500);
		});
		
	}
	
	$(".fire-button").bind("click", function() {
		var tableRows = $(".stars-table tr");
		if(tableRows.length && !tableRows.hasClass("marked")) {
			var cell = tableRows.find("td")[0];
			$(cell).addClass("red");
			$(cell).css('background', 'red');
			$(cell).html("+");
			tableRows.addClass("marked");
		}
		else if(tableRows.length == 5){
			$(".fire-button").hide();
			showOverlay();
		}
		else {
			var tableRow = $(".stars-table tr:last-child");
			var newRowElement = $(tableRow.clone());
			
			var redCell = newRowElement.find(".red");
			redCell.html(redCell.html()=="*"?"+":"*");
			
			var td = newRowElement.find("td:last-child");
			newRowElement.prepend(td);
			
			$(".stars-table").append(newRowElement);
		}
	});
});

</script>
