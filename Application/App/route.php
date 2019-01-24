<?php


$route[] = ['/','DeviceController@index'];                                                               
$route[] = ['/create','DeviceController@create'];                                                               
$route[] = ['/device/store','DeviceController@store']; 					
$route[] = ['/edit/{id}/Device','DeviceController@edit'];
$route[] = ['/update/{id}/Device','DeviceController@update'];
$route[] = ['/delete/{id}/Device','DeviceController@delete'];
$route[] = ['/conect/{id}','DeviceController@conect'];
$route[] = ['/conect/device/{id}','DeviceController@setConnection'];
$route[] = ['/exec','DeviceController@ssh_Exec'];
$route[] = ['/cript','DeviceController@criptView'];
$route[] = ['/run/cript','DeviceController@cript'];
$route[] = ['/run/decript','DeviceController@managerDecript'];
$route[] = ['/hashcompare','DeviceController@compareView'];
$route[] = ['/run/compare','DeviceController@compareHash'];

return $route;