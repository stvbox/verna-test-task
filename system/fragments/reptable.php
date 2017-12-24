
<?php
pr($arResult["REQ"]);
pr($arResult["SQL"]);
pr($arResult["DBG"]);
//foreach($arResult["RES"] AS $row) pr($row);
?>

<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Сеть</th>
      <th scope="col">Агенство</th>
      <th scope="col">Сумма</th>
    </tr>
  </thead>
  <tbody>
        <?php $fullSumm = 0;
        foreach($arResult["RES"] as $index => $arRow):
            $fullSumm+= $arRow["sum"];
        ?>
        <tr>
            <th scope="row"><?php echo ($index + 1);?></th>
            <td><?php echo $arRow["agency_network_name"];?></td>
            <td><?php echo $arRow["agency_name"];?></td>
            <td><?php echo intval($arRow["sum"]);?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <th scope="row"></th>
            <td></td>
            <td></td>
            <td><?php echo $fullSumm;?></td>
        </tr>
  </tbody>
</table>