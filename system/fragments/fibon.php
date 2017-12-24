<?php

function fib($n){
	
	$a = 1; $ta;
	$b = 1; $tb;
	$c = 1; $rc = 0;  $tc;
	$d = 0; $rd = 1;
	
	while($n) {
		if($n%2) {
			$tc = $rc;
			$rc = $rc*$a + $rd*$c;
			$rd = $tc*$b + $rd*$d;
		}
		
    	$ta = $a; $tb = $b; $tc = $c;
		$a = $a*$a  + $b*$c;
		$b = $ta*$b + $b*$d;
		$c = $c*$ta + $d*$c;     
		$d = $tc*$tb+ $d*$d;
		
		$n = $n >> 1;
	}
	
	return $rc;
}

?>


<div class="container">
	<div class="row">
		<div class="col-sm"></div>
		<div class="col-sm">
			<div class="card" >
				<?php for($i=0; $i < 11 ; $i++):?>
					<?=fib($i);?>
				<?php endfor;?>
			</div>
			<div>
				Задача:
				<p style="text-align: justify;" >
Напишите функцию определения n-го числа Фибоначчи, где в качестве параметра передается n/ Использовать PHP. Код можно вставить сюда или приложить в файле к письму.
				</p>
			</div>
		</div>
		<div class="col-sm">
<pre>
function fib($n){
	
	$a = 1; $ta;
	$b = 1; $tb;
	$c = 1; $rc = 0;  $tc;
	$d = 0; $rd = 1;
	
	while($n) {
		if($n%2) {
			$tc = $rc;
			$rc = $rc*$a + $rd*$c;
			$rd = $tc*$b + $rd*$d;
		}
		
    	$ta = $a; $tb = $b; $tc = $c;
		$a = $a*$a  + $b*$c;
		$b = $ta*$b + $b*$d;
		$c = $c*$ta + $d*$c;     
		$d = $tc*$tb+ $d*$d;
		
		$n = $n >> 1;
	}
	
	return $rc;
}
</pre>
		</div>
		<div class="col-sm"></div>
	</div>
</div>