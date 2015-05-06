<?php

	function updateMoneyArray(){
      //sleep(10);
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
      $moneyArray = $json->d->liveNavList[0]->values;
      return $moneyArray;
    };

	



?>
